<?php

spl_autoload_register(function ($class) {

    $filename = strtolower($class) .'.php';

    if(!file_exists('controllers/'. $filename)){

        echo '404 Not Found';
        return false;
    }

    require 'controllers/'. $filename;
});
