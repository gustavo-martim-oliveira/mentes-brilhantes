<?php
/**
 * 
 * Import classes
 * 
 */

spl_autoload_register(function ($class) { 

    $class = __DIR__ . '/' .  $class . '.php';

    if (file_exists($class)) {
        require_once $class;
    } 
});


require_once(__DIR__.'/Routes/api.php');