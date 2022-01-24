<?php

namespace SmarterCoding\WpPlus\Commands;

class Seed extends Command
{
    public const NAME = 'seed';
    protected $signature = '{post_type} {number}';

    public function handle(): bool
    {
        $post_type = $this->arg('post_type');
        $number = $this->arg('number');

        $factories = app()->get('factories');

        if (!array_key_exists($post_type, $factories)) {
            return $this->error("There is no registered factory for post type: $post_type");
        }

        $factory = new $factories[$post_type]();
        $factory->make($number);

        $this->line("Created $number posts of type: $post_type", self::GREEN);

        return true;
    }
}
