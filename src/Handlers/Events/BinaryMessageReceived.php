<?php

namespace YnievesDotNet\FourStream\Handlers\Events;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use YnievesDotNet\FourStream\Events\BinaryMessageReceived as BinaryReceived;

class BinaryMessageReceived
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
     * @param BinaryReceived $event
     * @return void
     */
    public function handle(BinaryReceived $event)
    {

    }
}
