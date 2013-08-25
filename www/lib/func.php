<?php

if( !defined('LIB_DIR')){
    define('LIB_DIR', '');
}
if( !defined('DAT_DIR')){
    define('DAT_DIR', '../dat/');
}

//-----------------------------------

function get_contents($url){
    if(function_exists('curl_init')) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $result = curl_exec($ch);
        curl_close($ch);
    }else{
        $result = @file_get_contents($url);
    }
    
    return $result;
}


function obj2ary($obj)
{
    if (!is_object($obj) && !is_array($obj) ){
        return $obj;
    }
    
    $ary = (array)$obj;
    foreach($ary as &$ch){
        $ch = obj2ary($ch);
    }
    return $ary;
}


?>
