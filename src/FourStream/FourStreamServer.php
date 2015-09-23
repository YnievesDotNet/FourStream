<?php
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2014 Anton Samuelsson
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
        $this->server = new Websocket(
            new Socket($tcpid)
        );
        $this->server->on('open', function (Bucket $bucket) {
            echo 'connection opened', "\n";
            return;
        });
        $this->server->on('message', function (Bucket $bucket ) {
            $data = $bucket->getData();
            $bucket->getSource()->broadcast($data['message']);
            $bucket->getSource()->send($data['message']);
            return;
        });
        $this->server->on('close', function (Bucket $bucket) {
            echo 'connection closed', "\n";
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
