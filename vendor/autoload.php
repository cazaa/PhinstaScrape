<?php

function __autoload($class) {
    $classPath = 'vendor/' . str_replace('\\', '/', $class) . '.php';

    require_once $classPath;
}