<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendEmailOperatorDailyJobs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data_mail;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($operators)
    {
        $this->data_mail = $operators;
    }

    /**
     * Execute the job.
     *
     * @return bool
     */
    public function handle()
    {
        foreach ($this->data_mail as $val) {

            $emails = [];

            if ($val->email == trim($val->email) && strpos($val->email, ' ') !== false) {
                $mail_list = explode(" ", $val->email);
                foreach($mail_list as $mail){
                    $emails[] = trim($mail);
                }
            } else if(strstr($val->email, PHP_EOL)) {
                $mail_list = explode(PHP_EOL, $val->email);
                foreach($mail_list as $mail){
                    $emails[] = trim($mail);
                }
            } else {
                $emails[] = trim($val->email);
            }

            $emails = array_unique($emails);

            try {

                foreach($emails as $email) {

                    Mail::send([], [$email], function ($message) use ($email) {
                        $message->from('charter@jetonset.com', 'JetOnset team');
                        $message->to($email);
                        $message->subject("Could you be interested in providing us with the information about your empty legs?");
                        $message->setBody(
                            "Dear All,\n\nLet me introduce ourselves as JetOnSet, a young, fast-growing brokerage company.\nWe’re expanding and looking for new reliable partners. Are you interested in cooperation and selling more flights?\nCould you be interested in providing us with the information about your empty legs? We could advertise them on our website under special offers.\nIn addition, please let us know which types of aircrafts you have available and how many, so that we have an idea of the amount of orders we can process with you.\nLooking forward to hearing from you!\n\nKind regards,\nAnastasia\n");
                    });

                    sleep(rand(0, 3));
                }
            } catch (Exception $e) {
                report($e);
                return false;
            }
        }
        return true;
    }
}
