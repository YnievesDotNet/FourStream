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

use Illuminate\Support\ServiceProvider;
use YnievesDotNet\FourStream\Command\FourStreamStartCommand;

/**
 * Service provider to instantiate the service.
 *
 * @package  YnievesDotNet\FourStream
 * @author   YnievesDotNet <yoinier.hn@gmail.com>
 */
class FourStreamServiceProvider extends ServiceProvider {
    
    /**
     * Internal service prefix.
     *
     * @var string
     */
    const SERVICE_PREFIX = 'net.ynieves.fourstream';

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var boolean
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     */
    public function boot(){
        //
    }
    
    /**
     * Register the service provider.
     */
    public function register(){
        $this->app['command.fourstream:start'] = $this->app->share(function($app)
        {
            return new FourStreamStartCommand();
        });

        $this->commands('command.fourstream:start');
    }
    
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(){
        return array('command.fourstream:start');
    }
}