<?php

namespace App\Listeners;

use App\Events\NewRegistered;
use App\Notifications\NewUserNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendEmailNewUserListener
{
    public function handle(NewRegistered $event): void
    {
        $event->user->notify(new NewUserNotification);
    }
}
