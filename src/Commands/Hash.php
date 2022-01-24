<?php

namespace SmarterCoding\WpPlus\Commands;

class Hash extends Command
{
    public const NAME = 'hash';
    protected $signature = '{password}';

    public function handle(): bool
    {
        $password = $this->arg('password');

        $this->line(wp_hash_password($password));

        return true;
    }
}
