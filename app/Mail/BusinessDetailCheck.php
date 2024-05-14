<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Doctrine\ORM\EntityManagerInterface;

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
     * The EntityManagerInterface to use for updating the business
     * 
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    public $em;

    /**
     * Create a new message instance.
     *
     * @param \TheRestartProject\RepairDirectory\Domain\Models\Business $business
     * @return void
     */
    public function __construct(Business $business, Array $reply_to, EntityManagerInterface $em)
    {
        $this->business = $business;
        $this->reply_to = $reply_to;
        $this->em = $em;
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
            subject: __(env('MAIL_BUSINESSCHECK_SUBJECT', '[Reuse Directory] Please review your details')),
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
