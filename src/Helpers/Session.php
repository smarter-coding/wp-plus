<?php

namespace SmarterCoding\WpPlus\Helpers;

class Session
{
    public function __construct()
    {
        if (!isset($_SESSION['flashed_new'])) {
            $_SESSION['flashed_new'] = [];
        }

        if (!isset($_SESSION['flashed_old'])) {
            $_SESSION['flashed_old'] = [];
        }
    }

    public function get($key)
    {
        return $_SESSION[$key] ?? null;
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function push($key, $value)
    {
        if (!isset($_SESSION[$key])) {
            $_SESSION[$key] = [];
        }

        $_SESSION[$key][] = $value;
    }

    public function merge($key, $values)
    {
        if (!isset($_SESSION[$key])) {
            $_SESSION[$key] = [];
        }

        $_SESSION[$key] = array_merge($_SESSION[$key], $values);
    }

    public function flash($key, $value)
    {
        $this->set($key, $value);
        $_SESSION['flashed_new'][] = $key;
    }

    public function clearFlashed()
    {
        foreach ($_SESSION['flashed_old'] as $key) {
            unset($_SESSION[$key]);
            unset($_SESSION['flashed_old'][$key]);
        }

        $_SESSION['flashed_old'] = $_SESSION['flashed_new'];
        $_SESSION['flashed_new'] = [];
    }
}
