<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OTQueryVerify extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($myot, $cc_email)
    {
        $this->claim = $myot;
        $this->cc_email = $cc_email;
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
        foreach($this->claim->log as $logs){
            if(strpos($logs->message,"Queried")!==false){
                $query = $logs->message; 
            }
        }
        $reason = str_replace('"', '', str_replace('Queried with message: "', '', $query));
        // hantar email guna blade template yg berkaitan
        // boleh guna view / markdown

        return (new MailMessage)
        ->subject('Overtime claim '.$this->claim->refno.' - Queried during verification')
        ->cc($this->cc_email)
        ->markdown('email.ot.otquery', [
            'url' => $url,
            'reason' => $query,
            'toname' => $this->claim->name->name,
            'date' => date("d.m.Y", strtotime($this->claim->date_expiry)),
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
        if($this->claim->status=="PA"){
            if($this->claim->verifier_id!=null){
                return [
                    'id' => $this->claim->id,
                    'param' => '',
                    'route_name' => 'ot.list',
                    'text' => 'Your claim ' . $this->claim->refno.' has been queried by your approver.',
                    'icon' => 'far fa-clock'
                ];
            }else{
                return [
                    'id' => $this->claim->id,
                    'param' => '',
                    'route_name' => 'ot.list',
                    'text' => 'Your claim ' . $this->claim->refno.' has been queried.',
                    'icon' => 'far fa-clock'
                ];
            }
        }else{
            return [
                'id' => $this->claim->id,
                'param' => '',
                'route_name' => 'ot.list',
                'text' => 'Your claim ' . $this->claim->refno.' has been queried by your verifier.',
                'icon' => 'far fa-clock'
              ];
        }
    }
}
