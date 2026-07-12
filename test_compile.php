<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$compiler = app('view')->getCompiler();
$compiled = $compiler->compileString(file_get_contents('resources/views/master-data.blade.php'));
file_put_contents('compiled_real.php', $compiled);
echo "Done\n";
