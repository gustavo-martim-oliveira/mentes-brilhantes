<?php 

spl_autoload_register(function ($class) { 
    $class = __DIR__ . '/' .  $class . '.php';

    if (file_exists($class)) {
        require_once $class;
    } 
});