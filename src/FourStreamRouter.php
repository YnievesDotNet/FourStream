<?php
/**
 * Created by PhpStorm.
 * User: Ynieves
 * Date: 30-ene-16
 * Time: 10:25 a.m.
 */

namespace YnievesDotNet\FourStream;


class FourStreamRouter
{
    /**
     * Array container for all actions registered
     *
     * @var array
     */
    public $actions = [];

    /**
     * Mapping the declared action to a ControllerController@action
     *
     * @param $action
     * @param $controller
     */
    public function registerAction($action, $controller)
    {
        $this->actions[$action] = $controller;
    }

    /**
     * Dispatching the action to a ControllerController@action
     *
     * @param $action
     * @return mixed
     */
    public function dispatch($action)
    {
        $split = explode('@', $this->actions[$action]);
        $controller = $split[0];
        $method = $split[1];
        $class = app($controller);
        return $class->{$method};
    }

}