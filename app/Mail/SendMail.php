<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Order;
class SendMail extends Mailable
{
    use Queueable, SerializesModels;
    
    public $order;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('admin.emails.order_status')
                    ->subject('JOS Order Status')
                    ->from('info@jetonset.com', 'JOS')
                    ->with([
                        'order' => $this->order,
                    ]);
    }
}
