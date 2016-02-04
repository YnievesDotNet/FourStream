# Configuring the Nodes
One node is the `Object` container of the conection at the websocket, and have to sync with the users of system. In your `User` model you have aggregate this `Trait`:
```php
...
    use YnievesDotNet\FourStream\Traits\FourStreamUserNode as Nodeable;
...    
    class User extends Model {
    	use Nodeable;
...
    }
```
This create one function accessible in User class for creation the one tocken ID for identification of your websocket session and your client. This is necessary when you need send message at one specific user or group of users.

This value is loading in your blade template and sending on the event connect(This example is using `ws` diretive for angular):
```html
<script>
	...
        ws.connect({
            url: 'ws://{!! $_SERVER['SERVER_NAME'] !!}:{!! config('fourstream.port') !!}'
        }).then(function () {
            var message = {};
            message.type = 'tocken';
            message.data = '{{ $auth_user->generateTocken() }}';
            message.tag = '@yield('fstag')';
            ws.send(angular.toJson(message));
        }
	...
</script>
```
In `@yield('fstag')` you can make from your view the tag for this conection or simply send this:
```html
<script>
	...
            message.tag = 'homepage';
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
            ->join('fsnodes', 'role_users.user_id', '=', 'fsnodes.user_id')
            ->select('fsnodes.user_id', 'fsnodes.node_id', 'roles.slug')
            ->where('roles.slug', '=', $role)
            ->get();
        foreach ($items as $item) {
            $msg['text'] = $message;
            if(!$source){
                $msg['title'] = "Sistema:";
            } else {
                $msg['title'] = $source . " dice:";
            }
            self::send(json_encode($msg), $item->node_id);
        }
        return;
    }
	...
}
```
Since v0.4 you can send message at tagged nodes, then you need add this lines at your messenger class:
```php
...
use YnievesDotNet\FourStream\Models\FourStreamTag as FSTag;
...
    public static function sendTaggedMessage($tag, $message, $source = null) {
        $tagged = FSTag::where('tag', $tag)->get();
        foreach ($tagged as $channel) {
            $node = $channel->fsnode;
            if(!$source){
                $msg['title'] = "<b>Sistema:</b>";
            } else {
                $msg['title'] = "<b>".$source . " dice:</b>";
            }
            $msg['text'] = $message;
            self::send('message', json_encode($msg), $node->node_id );
        }

    }
...
```