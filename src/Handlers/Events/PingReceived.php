<?php

namespace YnievesDotNet\FourStream\Handlers\Events;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use YnievesDotNet\FourStream\Events\PingReceived as Received;

class PingReceived
{
    /**
     * Create the event handler.
     *
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param Received $event
     * @return void
     */
    public function handle(Received $event)
    {
        if (config('app.debug')) {
            echo "> Connection Opened: " . $node->getId() . " tocken: " . $tocken . "\n";
        }
    }
}
