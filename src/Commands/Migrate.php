<?php

namespace SmarterCoding\WpPlus\Commands;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint as Table;
use SmarterCoding\WpPlus\Contracts\Migration;

class Migrate extends Command
{
    public const NAME = 'migrate';

    private $schema;

    public function handle(): bool
    {
        $this->schema = Capsule::schema();

        if (!$this->schema->hasTable('migrations')) {
            $this->schema->create('migrations', function (Table $table) {
                $table->increments('id');
                $table->string('migration');
            });
        }

        $paths = app()->get('migrations');

        // todo: ensure migrations are run in order of timestamp

        foreach ($paths as $path) {
            foreach (glob($path . '/*') as $migration_path) {
                $this->migrate($migration_path);
            }
        }

        return true;
    }

    private function migrate($path)
    {
        require_once($path);

        preg_match('/([^\/]*)\.php/', $path, $matches);
        $name = $matches[1];
        $class = substr($name, 18);

        $migrations = Capsule::table('migrations');

        if (!$migrations->where('migration', $name)->exists()) {
            $this->line("Migrating: $name");

            /** @var Migration $migration */
            $migration = new $class();
            $migration->run($this->schema);

            Capsule::table('migrations')->insert([
                'migration' => $name
            ]);

            $this->line("Migrated: $name");
        }
    }
}
