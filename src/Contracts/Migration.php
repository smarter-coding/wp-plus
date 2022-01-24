<?php

namespace SmarterCoding\WpPlus\Contracts;

use Illuminate\Database\Schema\Builder as Schema;

interface Migration
{
    public function run(Schema $schema);
}
