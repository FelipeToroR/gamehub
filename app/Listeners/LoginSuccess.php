<?php

namespace App\Listeners;
use App\Models\UserLogin;
use IlluminateAuthEventsLogin;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LoginSuccess
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
     * @param  IlluminateAuthEventsLogin  $event
     * @return void
     */
    public function handle(\Illuminate\Auth\Events\Login $event)
    {
        $user = new UserLogin();
        $user->user_id = $event->user->id;
        $user->save();
    }
}
