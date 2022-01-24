<?php

namespace SmarterCoding\WpPlus\Helpers;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;

class Trans
{
    private $filesystem;
    private $loader;

    public function __construct()
    {
        $this->filesystem = new Filesystem();
        $this->loader = new FileLoader($this->filesystem, __DIR__ . '/../../lang');
    }

    public function translator(): Translator
    {
        return new Translator($this->loader, 'en');
    }

    public function load($path, $namespace)
    {
        $this->loader->addNamespace($namespace, $path);

        foreach (glob($path . '/en/*.php') as $file) {
            $group = substr(basename($file), 0, -4);
            $this->loader->load('en', $group, $namespace);
        }
    }

    public function get($key, $replace = [])
    {
        return $this->translator()
            ->get($key, $replace, 'en');
    }
}
