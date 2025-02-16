<?php
function autoloader($class): void
{
  $path = __DIR__ . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';

  if (is_file($path)) {
    require_once $path;
  }
}

spl_autoload_register('autoloader');

