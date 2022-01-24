<?php

namespace SmarterCoding\WpPlus\Structs;

class StyleAsset extends Asset
{
    private $media;

    public function media($media): StyleAsset
    {
        $this->media = $media;

        return $this;
    }

    public function enqueue()
    {
        return wp_enqueue_style(
            $this->getName(),
            get_template_directory_uri() . '/public/' . $this->path,
            $this->dependencies,
            $this->getVersion(),
            $this->media
        );
    }

    public function register()
    {
        return wp_register_style(
            $this->getName(),
            get_template_directory_uri() . '/public/' . $this->path,
            $this->dependencies,
            $this->getVersion(),
            $this->media
        );
    }
}
