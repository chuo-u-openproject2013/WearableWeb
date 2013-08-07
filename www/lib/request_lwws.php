<?php
//
// Livedoor Weather Web Service
// http://weather.livedoor.com/weather_hacks/webservice
//
//
require_once 'func.php';

function request_lwws($city_id){
    // City IDデータ読み込み
    $city_data = unserialize(file_get_contents(dirname(__FILE__).'/city_data.dat'));

    // リクエストベースURL
    $base_url = 'http://weather.livedoor.com/forecast/webservice/json/v1' ;

    //正しいデータかチェック
    if( preg_match("/^[0-9]+$/", $city_id) ){
        $base_url .= '?city='.sprintf("%06d", $city_id);
    }else{
        return;
    }

    $response = get_contents($base_url);
    return json_decode( $response , true);
}

?>