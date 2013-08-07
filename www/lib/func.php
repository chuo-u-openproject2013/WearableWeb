<?php

function get_contents( $url ){
    if( function_exists( 'curl_init' ) ) {
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_HEADER, false );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_FAILONERROR, true);
        $result = curl_exec( $ch );
        curl_close( $ch );
    }else{
        $result = @file_get_contents( $url );
    }
    
    return $result;
}

/* 都道府県名の配列を返す */
function list_pref(){
    // City IDデータ読み込み
    $city_data = unserialize(file_get_contents(dirname(__FILE__).'/city_data.dat'));
    $pref = array_keys($city_data);
    return $pref;
}

?>
