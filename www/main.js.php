<?php
    /*
    $city_data = unserialize(file_get_contents('lib/city_data.dat'));
    $id_data   = json_decode(file_get_contents('dat/city_id.json'));
    
    
    echo "{";
    foreach ($city_data as $pref=>$cityary){
        echo "\"$pref\":{";
        foreach ($cityary as $city => $id) {
            if(array_key_exists($city, $id_data)){
                echo "\"$city\",";
            }
        }
        echo "},\n";
    }
    echo "}";
    */
?>



function CntHashLength(ary){
    var cnt = 0;
    for(var key in ary){
        cnt++;
    }
    return(cnt);
}

function Select(Obj){
    var sel_index = Obj.selectedIndex;
    var sel_pref = Obj[sel_index].text;
    var CitySelect = document.CityForm.city
    CitySelect.length = CntHashLength(CityAry[sel_pref]);
    var i = 0;
    for (var city in CityAry[sel_pref]){
            CitySelect.options[i].text = city;
            CitySelect.options[i].value = CityAry[sel_pref][city];
            i++;
    }
}
