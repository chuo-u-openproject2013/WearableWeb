<?php
    $city_data = unserialize(file_get_contents('app/city_data.dat'));

    //都道府県=>都市名=>cityidを格納したJavaScriptの配列を出力
    echo 'var CityAry = {';
    foreach ($city_data as $pref=>$cityary){
        echo "\"$pref\":{";
        foreach ($cityary as $city => $id) {
            echo "\"$city\":\"$id\",";
        }
        echo '},'."\n";
    }
    echo '};';
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
