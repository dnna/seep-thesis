#!/usr/bin/php
<?php
include("classes/DataHandler.php");
include("config.php");
@include($config['DataHandler'].".php");

// Variables $javaPath, $jarPath, $jarConfigPath, $logPath and $expertSystemFilesPath are set in config.php

//date_default_timezone_set('Europe/Athens');

$lotData = DataHandler::get()->getLotteries('last');
if($lotData[0]['lotExecuted'] === '0') {
    if(DataHandler::get()->lotteryInProgress()) {
        echo 'There is a lottery currently in progress. Quitting.';
    }
    
    echo system($javaPath.' -Xss5m -jar '.$jarPath.' -configPath '.$jarConfigPath.' -expertSystemFilesPath '.$expertSystemFilesPath.' -lotid '.$lotData[0]['lotID'].' > '.$logPath.' 2>&1');
} else {
    //echo "Nothing to do.\n";
}
?>
