#Mapping action use
When is defined an action in `routes.php` using this lines:
```php
$fs = app('fs.router');
$fs->registerAction('myAction', 'MyNameSpace\MyController@myMethod');
```
you can do that in your console:
```
php artisan make:controller TextController --plain
```
then in `routes.php` add this line:
```php
$fs->registerAction('text', 'App\Http\Controllers\TextController@sendText');
```
and your `app\Http\Controllers\TextController.php` look as:
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use YnievesDotNet\FourStream\Events\MessageReceived as Received;

class TextController extends Controller
{
    public function sendText(Received $event)
    {
        $nodes = $event->bucket->getSource()->getConnection()->getNodes(); 
    	$data = $event->bucket->getData();
    	$data = json_decode($data['message']);
    	if(isset($data->node_id) and $data->node_id != "") {
            foreach ($nodes as $node) {
                if($node->getId() == $data->node_id) {
                    $event->bucket->getSource()->send(json_encode($data), $node);
                }
            };
        } else {
            $event->bucket->getSource()->send(json_encode($data));
        }
    }
}

```
This example class send an one node specific the text received, but if this param is not received, send a message to de emiter node.

Now for try this functionality in your blade template you need add this lines.
```html
...
        <input type="text" id="input" placeholder="Message" />
        <pre id="output"></pre>
...
        <script>
            var host = 'ws:{!! $_SERVER['SERVER_NAME'] !!}:{!! config('fourstream.port') !!}';
            var socket = null;
            var input = document.getElementById('input');
            var output = document.getElementById('output');
            var print = function (message) {
                var samp = document.createElement('samp');
                samp.innerHTML = message + '\n';
                output.appendChild(samp);
                return;
            };
            input.addEventListener('keyup', function (evt) {
                if (13 === evt.keyCode) {
                    var msg = new Object();
                    msg.type = 'text';
                    msg.data = input.value;
                    if (!msg) {
                        return;
                    }
                    try {
                        socket.send(JSON.stringify(msg));
                        input.value = '';
                        input.focus();
                    } catch (e) {
                        console.log(e);
                    }
                    return;
                }
            });
            try {
                socket = new WebSocket(host);
                socket.onopen = function () {
                    print('connection is opened');
                    input.focus();
                    return;
                };
                socket.onmessage = function (msg) {
                    print(msg.data);
                    return;
                };
                socket.onclose = function () {
                    print('connection is closed');
                    return;
                };
            } catch (e) {
                console.log(e);
            }
        </script>
```
If you see the `MessageReceived` Handler Event note what is needed receive the param `type` for define the action to run. The second param is called `data`, and hi contain the message content needed to send.

Exist one reserved `type` sentence defined, and is *auth* and this action is for maping the nodes with the user autenticated, and with one additional parameters, `tag` for tagging the node, and this property is good if you want send message at one or all nodes connected in one specific page in your app. This is usefull when you have a Single Page Application, see the [Examples](examples/) directory for more info.

Any other params if you need send are optionals.