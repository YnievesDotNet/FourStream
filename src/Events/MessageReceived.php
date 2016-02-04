<?php
namespace YnievesDotNet\FourStream\Events;

use App\Events\Event;
use Hoa\Event\Bucket as Bucket;
use Illuminate\Queue\SerializesModels;

class MessageReceived extends Event
{
    use SerializesModels;

    public $message;

    /**
     * MessageReceived constructor.
     * @param Bucket $bucket
     */
    public function __construct(Bucket $bucket)
    {
        $this->bucket = $bucket;
    }

}