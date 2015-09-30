# Sending Messages
Here explained some tips for sending messages.

For send messages, only need add your Helper Class in the class do you need use the send message.
```php
<?php
namespace xxxxxx

use App\MessageSender;
...
```
To send broadcast message:
```php
MessageSender::broadcast($message);
```
To send at specific group of client, the you use this method:
```php
MessageSender::sendRoleSlug($message, $role);
```
And the admin role, try this:
```php
MessageSender::sendAdmins($message);
```
Guiding by the example, do you generate all the group what do you need.