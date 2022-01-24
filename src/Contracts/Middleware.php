<?php

namespace SmarterCoding\WpPlus\Contracts;

use SmarterCoding\WpPlus\Structs\Request;

interface Middleware
{
    public function run(Request $request);
}
