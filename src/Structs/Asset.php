<?php

namespace SmarterCoding\WpPlus\Structs;

class Asset
{
    protected $path;
    protected $name;
    protected $dependencies;
    protected $version;

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function name($name): Asset
    {
        $this->name = $name;

        return $this;
    }

    protected function getName(): string
    {
        if ($this->name) {
            return $this->name;
        }

        return $this->path;
    }

    public function dependencies(array $dependencies): Asset
    {
        $this->dependencies = $dependencies;

        return $this;
    }

    public function version($version): Asset
    {
        $this->version = $version;

        return $this;
    }

    protected function getVersion()
    {
        if ($this->version) {
            return $this->version;
        }

        return filemtime(get_template_directory() . '/public/' . $this->path);
    }
}
