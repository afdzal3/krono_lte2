<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OTSubmitted extends Notification
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

            $subject = "Verification";
            $type = "verification";
            $toname = $this->claim->verifier->name;
            if($this->claim->verifier_id==NULL){
                $subject = "Approval";
                $type = "approval";
                $toname = $this->claim->approver->name;
            }
            // hantar email guna blade template yg berkaitan
            // boleh guna view / markdown
            return (new MailMessage)
            ->subject('Overtime claim '.$this->claim->refno.' - Pending '.$subject)
            ->markdown('email.ot.otsubmittedverified', [
                'url' => $url,
                'type' => $type,
                'appname' => $this->claim->name->name,
                'toname' => $toname,
                'extra' => '',
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
        $route = "ot.verify";
        $process = "Verification";
        if($this->claim->verifier_id==NULL){
            $route = "ot.approval";
            $process = "Approval";
        }
        return [
            'id' => $this->claim->id,
            'param' => '',
            'route_name' => $route,
            'text' => 'Overtime claim ' . $this->claim->refno.' - Pending '.$process,
            'icon' => 'far fa-clock'
          ];
    }
}
