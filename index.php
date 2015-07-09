<?php

//Require application define configuration
require 'config.php';

//Autoloader class
function __autoload($class) {
    require "libs/$class.php";
}

$app = new bootstrap();
$app->_init();