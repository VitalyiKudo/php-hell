<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendEmailOperator implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data_mail;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data_mail)
    {
        $this->data_mail = $data_mail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->data_mail->emails as $val) {
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

                    Mail::send([], [$this->data_mail->date, $this->data_mail->airports, $this->data_mail->order_id], function ($message) use ($email) {
                        #Mail::send('emails.welcome', $data, function ($message) {
                        $message->from('charter@jetoset.com', 'JetOnset team');
                        #$message->to($email)->subject(
                        $message->to($email)->subject("We have request for you #{$this->data_mail->order_id}");
                        $message->setBody(
                            "Hello!\n\nCan you send me a quote for a flight from {$this->data_mail->airports['start_city']->city}, {$this->data_mail->airports['start_city']->region} to {$this->data_mail->airports['end_city']->city}, {$this->data_mail->airports['end_city']->region} on {$this->data_mail->date} for {$this->data_mail->airports['pax']} person.\n\nBest regards,\nJetOnset\n"
                        );
                    });
                    sleep(rand(0, 3));
                }
            } catch (Exception $e) {
                report($e);
                return false;
            }
        }
    }
}
