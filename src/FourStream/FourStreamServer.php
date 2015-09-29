<?php
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2007-2015 YnievesDotNet <yoinier.hn@gmail.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
namespace YnievesDotNet\FourStream\FourStream;

use Hoa\Websocket\Server as WebSocket;
use Hoa\Socket\Server as Socket;
use Hoa\Core\Event\Bucket as Bucket;
use YnievesDotNet\FourStream\Models\FourStreamTocken as FSTocken;

/**
 * WebSocket server class.
 *
 * @package  YnievesDotNet\FourStream
 * @author   YnievesDotNet <yoinier.hn@gmail.com>
 */
class FourStreamServer {
    /**
     * Hoa WebSocket server.
     *
     * @var Hoa\Websocket\Server
     */
    protected $server;

    /**
     * Symfony Event Dispatcher
     *
     * @var Symfony\Component\EventDispatcher\EventDispatcher
     */
    protected $dispatcher;

    /**
     * FourStream Event Listener
     *
     * @var YnievesDotNet\FourStream\FourStream\FourStreamListener
     */
    protected $listener;

    /**
     * Prepares a new WebSocket server on a specified host & port.
     *
     * @param  string $tcpid
     *
     * @return YnievesDotNet\FourStream\FourStream\FourStreamServer
     */
    public function start($tcpid)
    {
        $oldNode = FSTocken::all();
        echo "Closing old nodes", "\n";
        foreach ($oldNode as $node) {
            $node->delete();
        }

        $this->server = new Websocket(
            new Socket($tcpid)
        );
        //TODO: Eliminate from here for other methods
        $this->server->on('open', function (Bucket $bucket) {
            //TODO: Customize Open Connection Logic
        });
        $this->server->on('message', function (Bucket $bucket) {
            $data = $bucket->getData();
            $node = $bucket->getSource()->getConnection()->getCurrentNode();
            if (substr($data["message"], 0, 4) === "tck|"){
                $tck = substr($data["message"], 4);
                $fstck = FSTocken::where('tocken', $tck)->first();
                $fstck->websocket_id = $node->getId();
                $fstck->save();
                echo "Node->", $node->getID(), " assigned at user ", $fstck->user_id, "\n";
                return;
            } else  {
                $msg = explode("|", $data["message"]);
                $nodes = $bucket->getSource()->getConnection()->getNodes();
                foreach ($nodes as $node) {
                    if($node->getId() == base64_decode($msg[1])) {
                        $bucket->getSource()->send(base64_decode($msg[0]),$node);
                    }
                };
            }
            return;
        });
        $this->server->on('close', function (Bucket $bucket) {
            $node = $bucket->getSource()->getConnection()->getCurrentNode();
            $fstck = FSTocken::where('websocket_id', $node->getId())->delete();
            return;
        });

        return $this;
    }

    /**
     * Starts the prepared server.
     *
     * @return YnievesDotNet\FourStream\FourStream\FourStreamServer
     */
    public function run()
    {
        $this->server->run();

        return $this;
    }
}
