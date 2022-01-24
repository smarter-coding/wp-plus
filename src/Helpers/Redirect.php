<?php

namespace SmarterCoding\WpPlus\Helpers;

use AltoRouter;

class Redirect
{
    public function to($url)
    {
        header('Location: ' . $url);
        die;
    }

    public function route($name, $params = [])
    {
        $url = app()->singleton(AltoRouter::class)
            ->generate($name, $params);

        $this->to($url);
    }
}
