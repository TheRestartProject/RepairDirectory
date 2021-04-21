<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use TheRestartProject\Fixometer\Domain\Entities\User;
use TheRestartProject\RepairDirectory\Domain\Models\Business;

class AdminBusinessWebsiteInvalid extends Notification implements ShouldQueue
{
    use Queueable;

    protected $errors;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($errors)
    {
        $this->errors = $errors;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // Only email notifications supported so far - no in-app notifications.
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $msg = (new MailMessage)
            ->subject(__('notification.business_website_invalid_subject'))
            ->greeting(__('notification.business_website_invalid_greeting'));

        foreach ($this->errors as $error) {
            $msg->line(__('notification.business_website_invalid', $error));
        }

        return $msg;
    }
}
