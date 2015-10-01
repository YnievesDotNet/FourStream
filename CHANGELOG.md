# Changelog

##### 0.3
- Added the function sendUserID($message, $id), for sending message at all nodes connected for une specific user.
- Documentation and API have been updated data.
- Changelog is added.

##### 0.2
- Example Directory is created, but not populate yet.
- Documentation is updated.
- API documentation is added.
- The messages can be sended at one specific node, or group of nodes.(Each `Node` its one instatiation of the websocket client, if one client are opened some browser tab, the number of nodes of this clients is `N` tabs).

##### 0.1
- The server is running and configuring with the enviroment of Laravel.
- The message is sended at all `Nodes` connected at the server, including the sender.