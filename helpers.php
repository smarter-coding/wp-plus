<?php

use SmarterCoding\WpPlus\App;
use SmarterCoding\WpPlus\Helpers\Config;
use SmarterCoding\WpPlus\Helpers\Response;
use SmarterCoding\WpPlus\Helpers\Redirect;
use SmarterCoding\WpPlus\Helpers\Session;
use SmarterCoding\WpPlus\Helpers\Trans;
use Illuminate\Support\MessageBag;

function dd($dump)
{
    var_dump($dump);
    die();
}

function app(): App
{
    return App::getInstance();
}

function config(): Config
{
    return app()->singleton(Config::class);
}

function response(): Response
{
    return new Response();
}

function redirect(): Redirect
{
    return new Redirect();
}

function session(): Session
{
    return app()->singleton(Session::class);
}

function trans(): Trans
{
    return app()->singleton(Trans::class);
}

function errors(): MessageBag
{
    return session()->get('errors') ?? new MessageBag();
}
