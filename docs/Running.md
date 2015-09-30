#Running the Server

- [Executing the Start Command](#running)

<a name="running"></a>
## Executing the Start Command
In this time you can run `php artisan fourstream:start` in your terminal to start the YnievesDotNet\FourStream Server.

Add this lines un your template:
```html
        <input type="text" id="input" placeholder="Message…" />
        <hr />
        <pre id="output"></pre>
```
and this javascript:
```javascript
	var host   = 'ws://127.0.0.1:8080';
	var socket = null;
	var input  = document.getElementById('input');
	var output = document.getElementById('output');
	var print  = function (message) {
	  var samp       = document.createElement('samp');
	  samp.innerHTML = message + '\n';
	  output.appendChild(samp);
	
	  return;
	};
	
	input.addEventListener('keyup', function (evt) {
	  if (13 === evt.keyCode) {
	      var msg = input.value;
	
	      if (!msg) {
	          return;
	      }
	
	      try {
	          socket.send(msg);
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
```
And the result is fine. This is a classic test. The advanced use is explained in [Examples](examples/) directory.