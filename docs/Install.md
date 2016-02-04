#Install

- [Install package](#install)
- [Add Service Provider](#config)
- [Publish Assets](#assets)
- [Generating Database](#database)
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
## Generating Database
In this moment you can populate the database with the table for storing the relationships between your `Users` and `FourStream Socket Nodes`, execute in your console this command:
```
php artisan migrate
```
<a name="routes"></a>
## Mapping actions
For extend actions functionality is needed add this lines in your routes.php
```php
$fs = app('fs.router');
$fs->registerAction('myAction', 'MyController@myMethod');
```
See [Mapping actions use](docs/mapping.md).
<a name="events"></a>
## Listen events
Other method to interact with the message received at the FourStream WebSocket is using the Laravel Events. To do this you need add all the listeners at the`$listen` array in your  `App\Providers\EventServiceProvider.php`.
```php
/**
 * The event listener mappings for the application.
 *
 * @var array
 */
protected $listen = [
    'YnievesDotNet\FourStream\Events\MessageReceived' => [
        'App\Listeners\YourListener',
    ],
];
```
and in `YourListener` class your need add this `uses`.
```php
namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use YnievesDotNet\FourStream\Events\MessageReceived;


class YourListener
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
     * @param MessageReceived $event
     * @return void
     */
    public function handle(MessageReceived $event)
    {
        // Your Listener Handle Logic
    }
}
```
See [Listen events use](docs/events.md).