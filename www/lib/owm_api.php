<?php
/*
 * OpenWeatherMap API 2.5
 * http://openweathermap.org/API 
 * http://bugs.openweathermap.org/projects/api/wiki/API_2_5
 * 
 */

// API key (APPID) => http://openweathermap.org/appid
define('API_KEY', '');

define('BASE_URL', 'http://api.openweathermap.org/data/2.5/');


if( !defined('LIB_DIR')){
    define('LIB_DIR', '');
}

require_once(LIB_DIR.'func.php');


//-----------------------------------

function getCityidByName($name){
    $id_array = (array)json_decode(file_get_contents('../dat/city_id.json'));
    if(isset($id_array[$name])){
        return $id_array[$name];
    }else{
        return FALSE;
    }
}

function getForecast($cityid){
    $param = array();
    $param['id'] = $cityid;
    $request_url = BASE_URL.'forecast?'.owm_build_query($param);
    
    $data = get_contents($request_url);
    $data = json_decode($data);
    if(!is_null($data)){
        return (array)$data;
    }else{        
        return FALSE;
    }
}

function owm_build_query($param){
    if (API_KEY != ''){
        $param['APPID'] = API_KEY;
    }
    return http_build_query($param, '', '&');
}

?>

