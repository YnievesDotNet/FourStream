# Configuring the Nodes
One node is the `Object` container of the conection at the websocket, and have to sync with the users of system. In your `User` model you have aggregate this `Trait`, for example:
```php
...
    use YnievesDotNet\FourStream\Traits\FourStreamUserTockens as Nodeable;
...    
    class User extends Model {
    	use Nodeable;
...
    }
```