#Install

- [Install package](#install)
- [Add Service Provider](#config)
- [Enviroment config](#env)

<a name="install"></a>
## Install package
### Via composer
Add at your composer file this:
```json
{
    "require": {
        "ynievesdotnet/fourstream": "*"
    }
}
```

TODO: Now its time to run `composer update` in your terminal.

<a name="config"></a>
## Add the Service Provider
Simply add both the service provider and facade classes to your project's `config/app.php` file:
##### Service Provider
```php
YnievesDotNet\FourStream\FourStreamServiceProvider::class,
```

##### Facade
```php
'FourStream' => YnievesDotNet\FourStream\Facades\TwoStream::class,
```

<a name="env"></a>
## Enviroment config
Add this lines in your .env file at the root of laravel directory variant this value according your settings
```
FOURSTREAM_WEBSOCKET_PORT = 8080;
FOURSTREAM_WEBSOCKET_HOST = '0.0.0.0';
```