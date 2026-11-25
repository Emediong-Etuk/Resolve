<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendWorkspaceInvite extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public readonly string $name, public readonly string $url, public readonly string $workspace)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__('auth.send_workspace_invite.subject'))
            ->markdown('mail.sendworkspaceinvite',[
                'name'=>$this->name,
                'url'=>$this->url,
                'workspace'=>$this->workspace
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
