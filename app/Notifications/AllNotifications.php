<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AllNotifications extends Notification implements ShouldQueue
{
    use Queueable;

    protected $notif;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($notif)
    {
        $this->notif = $notif;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toArray($notifiable)
    {
        return [
            'notif_from' => $this->notif->user_id_01,
            'notif_to' => $this->notif->user_id_02,
            'notif_type' => $this->notif->status
        ];
    }
}
