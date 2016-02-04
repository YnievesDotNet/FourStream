#Editing Events and Handlers use
By defaults, the package handlers event have a native functions, here a list:

Handler Event  |  Function
------------- | -----------
ConnectionOpen | Auth the node with the user if the user has been autenticated
MessageReceived | Manage the process when a text message has been received
BinaryMessageReceived | Manage the process when a binary content has been received
PingReceived| By default, the server send a Pong, but is possible manage this event with this handler event
ConnectionClosed | Close the current node and erase the auth tocken in the database
ErrorGenerated | Is launched when one error is generated.

Now explained the ConnectionOpen Handler:
```php
namespace App\Handlers\Events;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
//Including the event
use YnievesDotNet\FourStream\Events\ConnectionOpen as Open;


class ConnectionOpen
{
    /**
     * Create the event handler.
     *
     */
    public function __construct()
    {
        // Your Listener Construct Logic
    }

    /**
     * Handle the event.
     *
     * @param Open $event
     * @return void
     */
    public function handle(Open $event)
    {
        // $node is the current node, obtain him from the $event container
        $node = $event->bucket->getSource()->getConnection()->getCurrentNode();
        // Getting if the user has been authenticated.
        // if your are using Sentinel or other package,
        // maybe you have edit this line.
        $user = Auth::user();
        if($user)
        {
            // Here is saved in the database a tocken,
            // this action create a reference between
            // the user and the node.
            $tocken = $user->generateTocken();
        } else {
            // if the user is not logged, the tocken has been
            //  declared as public and is not saved.
            $tocken = "public";
        }
        // If the app is running un debug mode echo a message
        if (config('app.debug')) {
            echo "> Connection Opened: " . $node->getId() . " tocken: " . $tocken . "\n";
        }
    }
}
```
Using this as template your mind is the limit.

Another else, you can declare some Handler Events(Listeners) for each Event. Please read the HOA Project Documentation for more info about the `$event->bucket()` properties.