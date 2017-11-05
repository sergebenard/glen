<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class sendInvoice extends Mailable
{
    use Queueable, SerializesModels;

    public $mailableData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(  )
    {
        //
        $this->mailableData = $request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.invoice');
    }
}
