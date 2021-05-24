<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use TheRestartProject\Fixometer\Domain\Entities\User;
use TheRestartProject\RepairDirectory\Domain\Models\Business;

class AdminBusinessHiddenByEditor extends Notification implements ShouldQueue
{
    use Queueable;

    protected $business;
    protected $by;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Business $business, User $by)
    {
        $this->business = $business;
        $this->by = $by;
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
        return (new MailMessage)
            ->subject(__('notification.business_hidden_by_editor_subject', [
                'business' => $this->business->getName()
            ]))
            ->greeting(__('notification.greeting'))
            ->line(__('notification.business_hidden_by_editor_body', [
                'by' => $this->by->getName(),
                'business' => $this->business->getName()
            ]))
            ->action(__('notification.business_hidden_by_editor_button'), route('admin.business.edit', $this->business->getUid()));
    }
}
