<?php

namespace YnievesDotNet\FourStream\Handlers\Events;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use YnievesDotNet\FourStream\Events\ConnectionClose as Close;
use YnievesDotNet\FourStream\Models\FourStreamNode as FSNode;

class ConnectionClose
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
     * @param Close $event
     * @return void
     */
    public function handle(Close $event)
    {
        $node = $event->bucket->getSource()->getConnection()->getCurrentNode();
        $data = $event->bucket->getData();
        FSNode::where('node_id', $node->getId())->delete();
        if (config('app.debug')) {
            echo "< Connection Closed: " . $node->getId() . " code: " . $data['code'] . " reason: " . $data['reason'] . "\n";
        }
    }
}
