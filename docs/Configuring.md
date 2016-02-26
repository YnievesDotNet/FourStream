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

For authenticate one node you can simply send this:
```html
<script>
	...
	    var msg = new Object();
        msg.type = 'auth';
        msg.data = '{{ $auth_user->generateTocken() }}';
        msg.tag = '@yield('fstag')';
        try {
            socket.send(JSON.stringify(msg));
        } catch (e) {
            console.log(e);
        }
	...
</script>
```
note what `$auth_user` is the instance at the user autenticated, and `'@yield('fstag')';` send one tag for tagging the current node.