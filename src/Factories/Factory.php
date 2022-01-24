<?php

namespace SmarterCoding\WpPlus\Factories;

use Faker\Factory as FakerFactory;
use SmarterCoding\WpPlus\Services\Faker;
use WP_Error;

abstract class Factory
{
    protected $faker;

    public function __construct()
    {
        $this->faker = FakerFactory::create();
        $this->faker->addProvider(new Faker($this->faker));
    }

    public abstract function get(): array;

    public function make($number)
    {
        for ($i = 1; $i <= $number; $i++) {
            $data = $this->get();

            $result = wp_insert_post($data, true);

            if ($result instanceof WP_Error) {
                throw new \Exception($result);
            }
        }

        return true;
    }
}
