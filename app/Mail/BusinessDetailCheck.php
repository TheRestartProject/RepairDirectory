<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

use TheRestartProject\RepairDirectory\Domain\Models\Business;

class BusinessDetailCheck extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Who to set as reply-to fields.
     */
    protected $reply_to;

    /**
     * The business to use.
     * 
     * @var \TheRestartProject\RepairDirectory\Domain\Models\Business
     */
    public $business;

    /**
     * Create a new message instance.
     *
     * @param \TheRestartProject\RepairDirectory\Domain\Models\Business $business
     * @return void
     */
    public function __construct(Business $business, Array $reply_to)
    {
        $this->business = $business;
        $this->reply_to = $reply_to;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {

        $reply_tos = [];
        foreach ($this->reply_to as $reply_to_address) {
            $reply_tos[] = new Address($reply_to_address);
        }

        return new Envelope(
            subject: __(env('MAIL_BUSINESSCHECK_SUBJECT', 'Business Detail Check')),
            from: new Address(env('MAIL_BUSINESSCHECK_FROM_MAIL'), env('MAIL_BUSINESSCHECK_FROM_NAME')),
            replyTo: $reply_tos,
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
            view: 'emails.businesses.details_check',
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
}
