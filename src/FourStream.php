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

namespace YnievesDotNet\FourStream;

use Hoa\Websocket\Client as WsClient;
use Hoa\Socket\Client as SClient;
use YnievesDotNet\FourStream\Models\FourStreamNode as FSNode;

/**
 * Class FourStream
 * @package YnievesDotNet\FourStream
 */
class FourStream {
    /**
     * @param $type
     * @param $data
     * @param $id
     */
    public function sendUserID($type, $data, $id) {
        $nodes = FSNode::where("user_id", $id)->get();
        foreach ($nodes as $node) {
            self::send($type, $data, $node->node_id);
        }
    }

    /**
     * @param $type
     * @param $data
     * @param $node_id
     */
    public function send($type, $data, $node_id = null) {
        $msg = array(
            'type' => $type,
            'data' => $data,
            'node_id' => $node_id
        );
		$host = config('fourstream.host');
        $port = config('fourstream.port');
        $tcpid = "tcp://$host:$port";
        $client = new WsClient(
            new SClient($tcpid)
        );
        $client->connect();
        $client->send(json_encode($msg));
        $client->close();
    }
}