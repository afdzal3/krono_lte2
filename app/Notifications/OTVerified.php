<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OTVerified extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($myot)
    {
        $this->claim = $myot;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // standardkan semua link ke email guna yg ni supaya dia 'mark as read'
           $url = route('notify.read', ['nid' => $this->id]);

           // hantar email guna blade template yg berkaitan
           // boleh guna view / markdown
           return (new MailMessage)
           ->subject('Overtime claim '.$this->claim->refno.' - Pending Approval')
           ->markdown('email.ot.otsubmittedverified', [
               'url' => $url,
               'type' => 'approval',
               'appname' => $this->claim->name->name,
               'toname' => $this->claim->approver->name,
               'extra' => 'verified and ',
               'claim' => $this->claim->refno
           ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'id' => $this->claim->id,
            'param' => '',
            'route_name' => 'ot.approval',
            'text' => 'Overtime claim ' . $this->claim->refno.' - Pending Approval',
            'icon' => 'far fa-clock'
          ];
    }
}