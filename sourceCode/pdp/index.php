<?php
function __seepAutoload($class_name) {
    if(strpos($class_name, 'Exception')) {
        if(file_exists('exceptions/' . $class_name . '.php')) {
            require_once('exceptions/' . $class_name . '.php');
        }
    } else {
        if(file_exists('classes/' . $class_name . '.php')) {
            require_once('classes/' . $class_name . '.php');
        }
    }
}
spl_autoload_register("__seepAutoload");

function exception_handler($exception) {
    $errorPage = new ErrorPage($exception);
    $errorPage->run();
}

set_exception_handler("exception_handler");

function error_handler($errno, $errstr, $errfile, $errline) {
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
}

//set_error_handler("error_handler", E_ALL | E_STRICT); // Some bugs with that, need to fix at some point

include("config.php");
@include($config['DataHandler'].".php");

date_default_timezone_set('Europe/Athens');
require_once('modules/IModule.php');

$pagecomposer = new PageComposer();
$pagecomposer->compose();
?>