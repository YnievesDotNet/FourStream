#Install

- [Install package](#install)
- [Add Service Provider](#config)
- [Publish Assets](#assets)
- [Updating Database](#database)
- [Editing Events and Handlers](#events)
- [Mapping actions](#routes)

<a name="install"></a>
## Install package
### Via composer
Add at your composer file this:
```json
{
    "require": {
        "ynievesdotnet/fourstream": "~0.5"
    }
}
```

Now its time to run `composer update` in your terminal.

<a name="config"></a>
## Add the Service Provider
Simply add both the service provider and facade classes to your project's `config/app.php` file:
##### Service Provider
```php
YnievesDotNet\FourStream\FourStreamServiceProvider::class,
```

##### Facade
```php
'FourStream' => YnievesDotNet\FourStream\Facades\FourStream::class,
```

<a name="assets"></a>
## Publish Assets
Is necessary publish the migrate file and the config file, then you can execute in your terminal:
```
php artisan vendor:publish --provider="YnievesDotNet\FourStream\FourStreamServiceProvider"
```
Update config file to reference your User model, your host and your socket port.
```
config/fourstream.php
```

<a name="database"></a>
## Updating Database
In this moment you can populate the database with the table for storing the relationships between your `Users` and `FourStream Socket Nodes`, execute in your console this command:
```
php artisan migrate
```
<a name="events"></a>
## Editing Events and Handlers
Other method to interact with the message received at the FourStream WebSocket is using the Laravel Events. To do this you need add all the listeners at the`$listen` array in your `App\Providers\EventServiceProvider.php`.
```php
/**
 * The event listener mappings for the application.
 *
 * @var array
 */
protected $listen = [
    'YnievesDotNet\FourStream\Events\ConnectionOpen' => [
        'YnievesDotNet\FourStream\Handlers\Events\ConnectionOpen',
    ],
    'YnievesDotNet\FourStream\Events\MessageReceived' => [
        'YnievesDotNet\FourStream\Handlers\Events\MessageReceived',
    ],
    'YnievesDotNet\FourStream\Events\BinaryMessageReceived' => [
        'YnievesDotNet\FourStream\Handlers\Events\BinaryMessageReceived',
    ],
    'YnievesDotNet\FourStream\Events\PingReceived' => [
        'YnievesDotNet\FourStream\Handlers\Events\PingReceived',
    ],
    'YnievesDotNet\FourStream\Events\ErrorGenerated' => [
        'YnievesDotNet\FourStream\Handlers\Events\ErrorGenerated',
    ],
    'YnievesDotNet\FourStream\Events\ConnectionClose' => [
        'YnievesDotNet\FourStream\Handlers\Events\ConnectionClose',
    ],
];
```
thats are the original handlers for the six events, if you need edit the logic of any of this handlers, you can copy the originals handlers at your `App\Handlers\Events` and change the registry in the file `App\Providers\EventServiceProvider.php`, see the bellow:
```php
/**
 * The event listener mappings for the application.
 *
 * @var array
 */
protected $listen = [
    ...
    ],
    'YnievesDotNet\FourStream\Events\ConnectionOpen' => [
        'App\Handlers\Events\ConnectionOpen',
    ],
    ...
];
```
and in `ConnectionOpen` class your need add this `uses`.
```php
namespace App\Handlers\Events;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
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
        $node = $event->bucket->getSource()->getConnection()->getCurrentNode();
        $user = Auth::user();
        if($user)
        {
            $tocken = $user->generateTocken();
        } else {
            $tocken = "public";
        }
        if (config('app.debug')) {
            echo "> Connection Opened: " . $node->getId() . " tocken: " . $tocken . "\n";
        }
    }
}
```
See [Editing Events and Handlers use](docs/Events.md).
<a name="routes"></a>
## Mapping actions
For extend actions functionality is needed add this lines in your `routes.php`
```php
$fs = app('fs.router');
$fs->registerAction('myAction', 'MyNameSpace\MyController@myMethod');
```
This functionality is managed by `YnievesDotNet\FourStream\Handlers\Events\MessageReceived`, if you change or edit this Event Handlers, then you can lost this extend option. Becareful with this.

See [Mapping actions use](docs/Mapping.md).