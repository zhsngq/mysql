<?php
require_once 'load.php';

$source = (new Table(SOURCE))->res;

$target= (new Table(TARGET))->res;

$diff = array_diff_key($source,$target);
foreach ($source as $key => &$value) {
    if (!isset($target[$key])) {
        $diff[$key] = 'add $key';
        continue;
    }
    $value->diff( $target[$key] );
}

sd($source);
