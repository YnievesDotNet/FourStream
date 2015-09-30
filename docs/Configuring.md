# Configuring the Nodes
One node is the `Object` container of the conection at the websocket, and have to sync with the users of system. In your `User` model you have aggregate this `Trait`:
```php
...
    use YnievesDotNet\FourStream\Traits\FourStreamUserTockens as Nodeable;
...    
    class User extends Model {
    	use Nodeable;
...
    }
```
This create one function accessible in User class for creation the one tocken ID for identification of your websocket session and your client. This is necessary when you need send message at one specific user or group of users.

This value is loading in your blade template and sending on the event connect:
```html
<script>
	...
	var tocken = '{{ $auth_user->generateTocken() }}';
    try {
        socket = new WebSocket(host);
        socket.onopen = function () {
            socket.send(tocken);
            return;
        };
	...
</script>
```

Now is time for create one controller helper, with the logic of our server and the personalize your send events.
```php
<?php
namespace App;

use FourStream;
use DB;

/**
 * Class MessageSender
 * @package App
 */
class MessageSender extends FourStream {

    /**
     * @param $message
     * @param null $source
     */
    public static function sendAdmins($message, $source = null) {
        self::sendRoleSlug($message, "admin", $source);
        return;
    }

    /**
     * @param $message
     * @param $role
     * @param null $source
     */
    public static function sendRoleSlug($message, $role, $source = null) {
        $items = DB::table('roles')
            ->join('role_users', 'roles.id', '=', 'role_users.role_id')
            ->join('fstockens', 'role_users.user_id', '=', 'fstockens.user_id')
            ->select('fstockens.user_id', 'fstockens.websocket_id', 'roles.slug')
            ->where('roles.slug', '=', $role)
            ->get();
        foreach ($items as $item) {
            $msg['text'] = $message;
            if(!$source){
                $msg['title'] = "Sistema:";
            } else {
                $msg['title'] = $source . " dice:";
            }
            self::send(json_encode($msg), $item->websocket_id);
        }
        return;
    }
	...
}
```
