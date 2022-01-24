<?php

namespace SmarterCoding\WpPlus;

use SmarterCoding\WpPlus\Commands\Hash;
use SmarterCoding\WpPlus\Commands\Make;
use SmarterCoding\WpPlus\Commands\Migrate;
use SmarterCoding\WpPlus\Commands\Seed;

class AppServiceProvider extends ServiceProvider
{
    protected $commands = [
        Hash::class,
        Make::class,
        Migrate::class,
        Seed::class
    ];

    public function boot()
    {
        parent::boot();

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        session()->clearFlashed();
    }
}
