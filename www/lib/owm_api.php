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
if( !defined('DAT_DIR')){
    define('DAT_DIR', '../dat/');
}

require_once LIB_DIR.'func.php';

//-----------------------------------

function getCityidByName($name){
    $id_array = (array)json_decode(file_get_contents(DAT_DIR.'city_id.json'));
    if(isset($id_array[$name])){
        return $id_array[$name];
    }else{
        return FALSE;
    }
}

// $mode = 'forecast' : Getting forecast data every 3 hours
//       = 'daily'    : Getting daily forecast weather data
//                      $cnt = [1-14] : Number of days
//       = 'weather'  : Getting current weather data
function getWeather($cityid, $mode, $cnt = null){
    $param = array();
    $param['id'] = $cityid;
    if(!is_null($cnt)){
        $param['cnt'] = $cnt;
    }
    
    $request_url = BASE_URL.$mode.'?'.owm_build_query($param);
    
    $data = get_contents($request_url);
    if($data !== FALSE){
        return $data;
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