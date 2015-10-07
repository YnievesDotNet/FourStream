# Changelog

##### 0.4
- The `Nodes` can be tagged. Is good for sending messaje at one node for one speific user or some users. For example, the nodes conected at one specific page can be tagged as `dashboard`, and with this functionality is possible send one message at all client connected at this page.
- Edited the model to assoc at the true entity type.
- Has been defined some parameters for send to the server from the client. And the message reply has been defined the payload too. See [Examples](example/), [Docs](doc/) and [API](api/) for more info.
- [Docs](doc/) and [API](api/) has been updated.

##### 0.3
- Added the function sendUserID($message, $id), for sending message at all nodes connected for one specific user.
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