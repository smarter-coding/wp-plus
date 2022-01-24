<?php

namespace SmarterCoding\WpPlus\Helpers;

use AltoRouter;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use SmarterCoding\WpPlus\Structs\Request;
use ReflectionParameter;

class Router
{
    public static $middleware = [];

    private static function router(): AltoRouter
    {
        return app()->singleton(AltoRouter::class);
    }

    public static function init()
    {
        if ($route = self::router()->match()) {
            $requestType = (new ReflectionParameter($route['target'], 'request'))
                ->getType()
                ->getName();

            /** @var Request $request */
            $request = $requestType::createFromGlobals();
            $request->setRouteParameters($route['params']);
            $request->validate();

            $meta = $route['meta'];

            if (isset($meta['middleware'])) {
                foreach ($meta['middleware'] as $middleware) {
                    if (isset(app()->get('middleware')[$middleware])) {
                        $classes = app()->get('middleware')[$middleware];

                        foreach ($classes as $class) {
                            $instance = new $class();
                            $instance->run($request);
                        }
                    } else {
                        throw new \Exception("Middleware '$middleware' not registered");
                    }
                }
            }

            $response = call_user_func($route['target'], $request);
            $response->send();
        }
    }

    public static function middleware($middleware, $callable)
    {
        if (is_array($middleware)) {
            self::$middleware = $middleware;
        } else {
            self::$middleware = [$middleware];
        }

        call_user_func($callable);

        self::$middleware = null;
    }

    public static function get($route, $callable, $name = null)
    {
        self::router()->map('GET', $route, $callable, [
            'middleware' => self::$middleware
        ], $name);
    }

    public static function post($route, $callable, $name = null)
    {
        self::router()->map('POST', $route, $callable, [
            'middleware' => self::$middleware
        ], $name);
    }
}
