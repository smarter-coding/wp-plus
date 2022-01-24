<?php

namespace SmarterCoding\WpPlus;

class App
{
    private static $instance = null;
    private $data = [];
    private $singletons = [];

    public static function getInstance(): App
    {
        if (self::$instance === null) {
            self::$instance = new App();
        }

        return self::$instance;
    }

    public function get($key)
    {
        if (!isset($this->data[$key])) {
            return null;
        }

        return $this->data[$key];
    }

    public function set($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function push($key, $value)
    {
        if (!isset($this->data[$key])) {
            $this->data[$key] = [];
        }

        $this->data[$key][] = $value;
    }

    public function merge($key, $values)
    {
        if (!isset($this->data[$key])) {
            $this->data[$key] = [];
        }

        $this->data[$key] = array_merge($this->data[$key], $values);
    }

    public function singleton($class): mixed
    {
        if (!isset($this->singletons[$class])) {
            $this->singletons[$class] = new $class();
        }

        return $this->singletons[$class];
    }
}
