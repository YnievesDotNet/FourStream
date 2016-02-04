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
namespace YnievesDotNet\FourStream\Command;

use Log;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use YnievesDotNet\FourStream\FourStream\FourStreamServer;

/**
 * System artisan command class.
 *
 * @package  YnievesDotNet\FourStream
 * @author   YnievesDotNet <yoinier.hn@gmail.com>
 */
class FourStreamStartCommand extends Command {
    /**
     * Default WebSocket port.
     *
     * @var integer
     */
    const DEFAULT_WEBSOCKET_PORT = 8080;
    
    /**
     * Default WebSocket host.
     *
     * @var integer
     */
    const DEFAULT_WEBSOCKET_HOST = '127.0.0.1';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'fourstream:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Starts FourStream WebSocket server and runs event-driven applications with Laravel.';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function fire()
    {
        $port = config('fourstream.port');
        $host = config('fourstream.host');
        try {
            $tcpid = "tcp://$host:$port";
            $server = new FourStreamServer();
            $server->start($tcpid);
            $this->info("WebSocket server started on: tcp://{$host}:{$port}");
            $server->run();
        } catch (Exception $e) {
            Log::error('Something went wrong:', $e);
            $this->error('Unable to establish a WebSocket server. Review the log for more information.');
        }
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array(
            array(
                'port', null, InputOption::VALUE_OPTIONAL,
                "The port that the WebSocket server will run on (default: {self::DEFAULT_WEBSOCKET_PORT})",
                 self::DEFAULT_WEBSOCKET_PORT
            ),
            array(
                'host', null, InputOption::VALUE_OPTIONAL,
                "The host that the WebSocket server will run on (default: {self::DEFAULT_WEBSOCKET_HOST})",
                 self::DEFAULT_WEBSOCKET_HOST
            ),
        );
    }

}
