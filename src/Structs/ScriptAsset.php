<?php

namespace SmarterCoding\WpPlus\Structs;

class ScriptAsset extends Asset
{
    private $footer;

    public function footer($footer): ScriptAsset
    {
        $this->footer = $footer;

        return $this;
    }

    public function enqueue()
    {
        return wp_enqueue_script(
            $this->getName(),
            get_template_directory_uri() . '/public/' . $this->path,
            $this->dependencies,
            $this->getVersion(),
            $this->footer
        );
    }

    public function register()
    {
        return wp_register_script(
            $this->getName(),
            get_template_directory_uri() . '/public/' . $this->path,
            $this->dependencies,
            $this->getVersion(),
            $this->footer
        );
    }
}
