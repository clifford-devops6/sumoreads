<?php

namespace App\Listeners;

use App\Events\ShareEvent;
use App\Notifications\ShareArticleNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class ShareListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ShareEvent  $event
     * @return void
     */
    public function handle(ShareEvent $event)
    {
        //
        $bcc=array();
        foreach ($event->share->users()->pluck('email') as $address){
            array_push($bcc, $address);
        }
        $groups=$event->share->groups()->get();
        foreach ($groups as $group){
            $email=$group->users()->pluck('email');
            foreach ($email as $address){
                array_push($bcc,$address);
            }

        }
        if ($event->share->email){
            array_push($bcc,$event->share->email);
        }
        $unique_bcc=array_unique($bcc);
        Notification::route('mail',$unique_bcc)->notify( new ShareArticleNotification($event->share));
    }
}
