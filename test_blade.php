<?php
require __DIR__ . '/vendor/autoload.php';

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Compilers\BladeCompiler;

$container = new Container();
$filesystem = new Filesystem();
$blade = new BladeCompiler($filesystem, __DIR__ . '/storage/framework/views');

$content = file_get_contents(__DIR__ . '/resources/views/dashboard.blade.php');
$compiled = $blade->compileString($content);

file_put_contents(__DIR__ . '/storage/framework/views/test_compiled.php', $compiled);

echo "Compiled to storage/framework/views/test_compiled.php\n";

system('php -l ' . __DIR__ . '/storage/framework/views/test_compiled.php');
