<?php

namespace YnievesDotNet\FourStream\Handlers\Events;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use YnievesDotNet\FourStream\Events\ConnectionOpen as Open;
use YnievesDotNet\FourStream\Models\FourStreamNode as FSNode;

class ConnectionOpen
{
    /**
     * Create the event handler.
     *
     */
    public function __construct()
    {

    }

    /**
     * Handle the Event.
     *
     * @param Open $event
     * @return void
     */
    public function handle(Open $event)
    {
        $node = $event->bucket->getSource()->getConnection()->getCurrentNode();
        if (config('app.debug')) {
            echo "> Connection Opened: " . $node->getId() . "\n";
        }
    }
}
