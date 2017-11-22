<?php
require_once '../vendor/autoload.php';
require_once 'config.php';
function _vendor_autoload($class) {
  $parts = explode('\\', $class);
  $parts[] = str_replace('_', DIRECTORY_SEPARATOR, array_pop($parts));
  $path = implode(DIRECTORY_SEPARATOR, $parts);
  $file = stream_resolve_include_path($path.'.php');
  if($file !== false)
    require_once $file;
}
spl_autoload_register('_vendor_autoload');


use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager;

$capsule = new Manager();
define('CAPSULE',serialize($capsule));
