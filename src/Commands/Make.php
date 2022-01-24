<?php

namespace SmarterCoding\WpPlus\Commands;

use SmarterCoding\FileGenerator\Generator;

class Make extends Command
{
    public const NAME = 'make';
    protected $signature = '{type} {name}';

    public function handle(): bool
    {
        $type = ucfirst($this->arg('type'));
        $method = "make{$type}";

        return $this->$method();
    }

    private function makeMigration()
    {
        $name = $this->arg('name');
        $filename = date('Y_m_d_His') . "_{$name}.php";

        $generator = new Generator(__DIR__ . '/../Templates/generators/migration.gen');
        $generator->generate(get_template_directory() . '/migrations/' . $filename, [
            'name' => $name
        ]);

        return true;
    }

    public function makeCommand()
    {
        $name = $this->arg('name');
        $filename = upper_camel_case($name) . '.php';

        $autoload = json_decode(
            file_get_contents(get_template_directory() . '/composer.json'), true
        )['autoload']['psr-4'];

        $namespace = array_key_first($autoload);
        $src = $autoload[$namespace];

        $generator = new Generator(__DIR__ . '/../Templates/generators/command.gen');
        $generator->generate(get_template_directory() . "/{$src}Commands/{$filename}", [
            'namespace' => $namespace,
            'name' => $name
        ]);

        return true;
    }
}
