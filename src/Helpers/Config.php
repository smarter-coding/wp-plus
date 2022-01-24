<?php

namespace SmarterCoding\WpPlus\Helpers;

class Config
{
    private $data = [];

    public function get($key)
    {
        $keys = explode('.', $key);
        $data = $this->data;

        foreach ($keys as $key) {
            if (!isset($data[$key])) {
                return null;
            }

            $data = $data[$key];
        }

        return $data;
    }

    public function load($path)
    {
        foreach (glob($path . '/*') as $file) {
            $filename = substr(basename($file), 0, -4);
            $this->data[$filename] = include $file;
        }
    }
}
