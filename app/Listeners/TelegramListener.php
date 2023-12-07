<?php

namespace App\Listeners;

use App\Events\ReplyEvent;
use App\Jobs\TelegramJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TelegramListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ReplyEvent $event): void
    {
        TelegramJob::dispatch($event->reply);
    }
}
