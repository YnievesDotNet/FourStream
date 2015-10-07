#Install

- [Install package](#install)
- [Add Service Provider](#config)
- [Publish Assets](#assets)
- [Generating Database](#database)

<a name="install"></a>
## Install package
### Via composer
Add at your composer file this:
```json
{
    "require": {
        "ynievesdotnet/fourstream": "~0.4"
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
