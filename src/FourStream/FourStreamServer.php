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
use Hoa\Event\Bucket as Bucket;
use YnievesDotNet\FourStream\Events;
use Illuminate\Support\Facades\Event;
use YnievesDotNet\FourStream\Models\FourStreamNode as FSNode;

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
     * Prepares a new WebSocket server on a specified host & port.
     *
     * @param  string $tcpid
     *
     * @return YnievesDotNet\FourStream\FourStream\FourStreamServer
     */
    public function start($tcpid)
    {
        $oldNode = FSNode::all();
        echo "Closing old nodes", "\n";
        foreach ($oldNode as $node) {
            $node->delete();
        }

        $this->server = new Websocket(
            new Socket($tcpid)
        );
        $this->server->on('open', function (Bucket $bucket) {
            Event::fire(new Events\ConnectionOpen($bucket));
        });
        $this->server->on('message', function (Bucket $bucket) {
            Event::fire(new Events\MessageReceived($bucket));
        });
        $this->server->on('binary-message', function (Bucket $bucket) {
            Event::fire(new Events\BinaryMessageReceived($bucket));
        });
        $this->server->on('ping', function (Bucket $bucket) {
            Event::fire(new Events\PingReceived($bucket));
        });
        $this->server->on('error', function (Bucket $bucket) {
            Event::fire(new Events\ErrorGenerated($bucket));
        });
        $this->server->on('close', function (Bucket $bucket) {
            Event::fire(new Events\ConnectionClose($bucket));
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
