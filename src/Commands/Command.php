<?php

namespace SmarterCoding\WpPlus\Commands;

abstract class Command
{
    protected const BLACK = "\033[1;30m";
    protected const RED = "\033[1;31m";
    protected const GREEN = "\033[1;32m";
    protected const YELLOW = "\033[1;33m";
    protected const BLUE = "\033[1;34m";
    protected const MAGENTA = "\033[1;35m";
    protected const CYAN = "\033[1;36m";
    protected const GRAY = "\033[1;37m";
    protected const WHITE = "\033[1;38m";
    private const RESET = "\033[0m";

    protected $signature = '';

    private $args;
    private $options;

    public abstract function handle(): bool;

    public function run(array $args, array $options)
    {
        try {

            // todo: messy, refactor this

            $expectedArgs = [];
            $expectedOptions = [];

            if ($this->signature) {
                $signature = explode(' ', $this->signature);

                foreach ($signature as $key) {
                    $key = substr($key, 1, -1);

                    if (substr($key, 0, 2) === '--') {
                        $expectedOptions[] = $key;
                    } else {
                        $expectedArgs[] = $key;
                    }
                }

                foreach ($expectedArgs as $index => $expectedArg) {
                    if (!isset($args[$index])) {
                        throw new \InvalidArgumentException("Missing argument: {$expectedArg}");
                    }

                    $this->args[$expectedArg] = $args[$index];
                }

                foreach ($expectedOptions as $expectedOption) {
                    $expectedOption = substr($expectedOption, 2);
                    $this->options[$expectedOption] = $options[$expectedOption] ?? false;
                }
            }

            $this->handle();

        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }

    protected function arg($key, $default = null)
    {
        return $this->args[$key] ?? $default;
    }

    protected function option($key, $default = null)
    {
        return $this->options[$key] ?? $default;
    }

    protected function output($string, $color = null)
    {
        if ($color) {
            echo $color;
        }

        echo $string;

        if ($color) {
            echo self::RESET;
        }
    }

    protected function line($string, $color = null)
    {
        $this->output("$string", $color);
        echo "\n";
    }

    protected function error($error): bool
    {
        $this->line($error, self::RED);
        return false;
    }
}
