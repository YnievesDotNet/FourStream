<?php

namespace YnievesDotNet\FourStream\Handlers\Events;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use YnievesDotNet\FourStream\Events\ErrorGenerated as Generated;

class ErrorGenerated
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
     * @param Generated $event
     * @return void
     */
    public function handle(Generated $event)
    {

    }
}
