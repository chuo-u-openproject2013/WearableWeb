<?php
if( !defined('LIB_DIR')){
    define('LIB_DIR', 'lib/');
}

require_once LIB_DIR.'owm_api.php';

header("Content-Type: application/json; charset=utf-8");

switch ($_GET['action']){
    case 'weather':
        $data = getWeather($_GET['cityid'], 'forecast');
        if($data !== FALSE)
            echo $data;
        else
            header("HTTP/1.1 404 Not Found");
        break;
}
?>