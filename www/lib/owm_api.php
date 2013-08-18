<?php
/*
 * OpenWeatherMap API
 * http://openweathermap.org/API 
 */
require_once dirname(__FILE__).'/func.php';

define('BASE_URL', 'http://api.openweathermap.org/data/2.5/');

function getCityidByName($name){
    $id_array = (array)json_decode(file_get_contents('../dat/city_id.json'));
    if(isset($id_array[$name])){
        return $id_array[$name];
    }else{
        return 0;
    }
}

function getForecast($cityid){
    $data = get_contents($url);
    
    $request_url = BASE_URL.'forecast?id='.$cityid;
}

?>

