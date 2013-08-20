<?php

if ( !defined('DAT_DIR')){
    define('DAT_DIR', '/../dat/');
}

?>
<?php /*IDE highlight hack*/ if(0) { ?><script><?php } ?>
    
var PrefCity = <?php include(DAT_DIR.'pref_city.json') ?>; 

function Init(){
    var PrefSelect = document.getElementById('pref');
    PrefSelect.length = CntHashLength(PrefCity)+1;
    var i = 1;
    for (var pref in PrefCity){
            PrefSelect.options[i].text = pref;
            PrefSelect.options[i].value = pref;
            i++;
    }
}

window.addEventListener( 'load', Init, false );

function CntHashLength(ary){
    var cnt = 0;
    for(var key in ary){
        cnt++;
    }
    return(cnt);
}

function onSelect(Obj){
    var sel_pref = Obj[Obj.selectedIndex].text;
    var CitySelect = document.getElementById('city');
    CitySelect.length = PrefCity[sel_pref].length;
    for (var i = 0; i < PrefCity[sel_pref].length; i++){
            CitySelect.options[i].text = PrefCity[sel_pref][i];
            CitySelect.options[i].value = PrefCity[sel_pref][i];
    }
}

<?php /*IDE highlight hack*/ if(0) { ?></script><?php } ?>