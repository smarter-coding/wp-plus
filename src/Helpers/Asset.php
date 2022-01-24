<?php

namespace SmarterCoding\WpPlus\Helpers;

use SmarterCoding\WpPlus\Structs\ScriptAsset;
use SmarterCoding\WpPlus\Structs\StyleAsset;

class Asset
{
    public static function css($path): StyleAsset
    {
        return new StyleAsset($path);
    }

    public static function js($path): ScriptAsset
    {
        return new ScriptAsset($path);
    }

    public static function enqueue($asset)
    {
        if (strpos($asset, '.css')) {
            wp_enqueue_style($asset);
        }

        if (strpos($asset, '.js')) {
            wp_enqueue_script($asset);
        }
    }
}
