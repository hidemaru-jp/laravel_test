<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotifyCompleted extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
        public $carts;
        public $subtotals;
        public $totals;
        public $user;
        
    public function __construct($carts,$subtotals,$totals,$user)
    {
        $this->carts = $carts;
        $this->subtotals = $subtotals;
        $this->totals = $totals;
        $this->user = $user;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'テストメールです。',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            
            
            view: 'emails.test',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }

    public function build()
    {
        return $this
                ->subject('テストメールです。')
                ->view('emails/test.blade.php')
                ->to($this->user['email'],$this->user['name'])
                ->from("xxx@xxx");
    }
}
