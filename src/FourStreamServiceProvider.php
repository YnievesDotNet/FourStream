<?php
namespace YnievesDotNet\FourStream;

use Illuminate\Support\ServiceProvider;

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
        //
    }
    
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(){
        //
    }
}