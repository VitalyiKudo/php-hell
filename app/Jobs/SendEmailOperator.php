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
    public function __construct($data_emails)
    {
        $this->data_mail = $data_emails;
        #dd($this->data_mail);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->data_mail->operator_emails as $val) {
            $emails = [];

            if ($val == trim($val) && strpos($val, ' ') !== false) {
                $mail_list = explode(" ", $val);
                foreach($mail_list as $mail){
                    $emails[] = trim($mail);
                }
            } else if(strstr($val, PHP_EOL)) {
                $mail_list = explode(PHP_EOL, $val);
                foreach($mail_list as $mail){
                    $emails[] = trim($mail);
                }
            } else {
                $emails[] = trim($val);
            }

            $emails = array_unique($emails);

            try {

                foreach($emails as $email) {

                    Mail::send([], [$this->data_mail], function ($message) use ($email) {
                        #Mail::send('emails.welcome', $data, function ($message) {
                        $message->from('charter@jetoset.com', 'JetOnset team');
                        #$message->to($email)->subject(
                        $message->to($email);
                        $message->subject("We have request for you #{$this->data_mail->data_flight['order_id']}");
                        if ($this->data_mail->data_flight['start_city'] !== 'emptyLeg') {
                            $message->setBody(
                                "Hello!\n\nCan you send me a quote for a flight from {$this->data_mail->data_flight['start_city']}, {$this->data_mail->data_flight['start_state']} to {$this->data_mail->data_flight['end_city']}, {$this->data_mail->data_flight['end_state']} on {$this->data_mail->data_flight['date']} for {$this->data_mail->data_flight['pax']} person.\n\nBest regards,\nJetOnset\n");
                        }
                        else {
                            $message->setBody(
                                "Hello!\n\nWe are selling your empty leg {$this->data_mail->data_flight['start_city']}, {$this->data_mail->data_flight['start_state']} - {$this->data_mail->data_flight['end_city']}, {$this->data_mail->data_flight['end_state']} on {$this->data_mail->data_flight['date']}, please confirm it’s availability.\n\nBest regards,\nJetOnset\n");
                        }
                    });
                    sleep(rand(0, 3));
                }

                Mail::send([], [$this->data_mail], function ($message)  {
                    $message->from('quote@jetonset.com', 'JetOnset team');
                    $message->to($this->data_mail->data_user['user_email']);
                    $message->subject("We have received your request #{$this->data_mail->data_flight['order_id']}");
                    $message->setBody("Dear {$this->data_mail->data_user['first_name']} {$this->data_mail->data_user['last_name']},\n\nWe have received your payment. Our manager will contact you to discuss your flight details in the shortest time possible.\n\nBest regards,\nJetOnset Team");
                });

            } catch (Exception $e) {
                report($e);
                return false;
            }
        }
    }
}
