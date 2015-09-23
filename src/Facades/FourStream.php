<?php
namespace YnievesDotNet\FourStream\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see YnievesDotNet\WebSocket\WebSocket
 */
class FourStream extends Facade
{
    
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return true }
    
}
