<?php

namespace YnievesDotNet\FourStream\Handlers\Events;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use YnievesDotNet\FourStream\Events\MessageReceived as Received;
use YnievesDotNet\FourStream\Models\FourStreamNode as FSNode;

class MessageReceived
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
        $data = $event->bucket->getData();
        $node = $event->bucket->getSource()->getConnection()->getCurrentNode();
        $data = json_decode($data['message']);
        $nodes = $event->bucket->getSource()->getConnection()->getNodes();
        $fsnode = FSNode::where('node_id', $node->getId())->first();
        if($data->type == "auth") {
			$tck = $data->data;
			$fsnode = FSNode::where('tocken', $tck)->first();
			$fsnode->node_id = $node->getId();
			$fsnode->save();
            if ($data->tag != "" && $fsnode) {
                $fsnode->fstags()->create([
                    'tag' => $data->tag,
                ]);
            };
            return;
        }
        $router = app('fs.router');
        if (isset($router->actions[$data->type])) {
            $router->dispatch($event);
        }
        if (config('app.debug')) {
            echo "> Message Received. \n";
        }
    }
}
