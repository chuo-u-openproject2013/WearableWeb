<?php
header("Content-type: application/x-javascript");

if ( !defined('DAT_DIR')){
    define('DAT_DIR', '../dat/');
}

?>
<?php /*IDE highlight hack*/ if(0) { ?><script><?php } ?>
    
var PrefCity = <?php include(DAT_DIR.'pref_city_id.json') ?>; 

window.addEventListener( 'load', Init, false );
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

function CntHashLength(ary){
    var cnt = 0;
    for(var key in ary){
        cnt++;
    }
    return(cnt);
}


document.getElementById('pref').addEventListener( 'change', onSelect, false);
function onSelect(){
    var sel_pref = this[this.selectedIndex].text;
    var CitySelect = document.getElementById('city');
    CitySelect.length = CntHashLength(PrefCity[sel_pref]);
    var i = 0;
    for(var city in PrefCity[sel_pref]){
        CitySelect.options[i].text = city;
        CitySelect.options[i].value = PrefCity[sel_pref][city];
        i++;
    }
}

//-----------------------------------


(function($){
    var submitBtn = $("#submit");

    submitBtn.click( function(){
        var cityid = $("#city option:selected").val();
        
        if(cityid ==''){
            alert("未選択です");
            return;
        }
        
        jqXHR = $.getJSON("ajax.php", {"action": "weather", "cityid":cityid });
    
        jqXHR.done( function(data, status, xhr){
            $('#description').html('<h2>'+$("#pref option:selected").text()+$("#city option:selected").text()+'</h2>');
            $("#debug").html("<pre>"+xhr.responseText+"</pre>");
        });

        jqXHR.fail( function(){
            $("#right").prepend('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a>データの読み込みに失敗。時間を空けて再試行してください。</div>');
        });

        jqXHR.always( function(){
            $("#location_form").children().removeAttr("disabled");
        });
    
        $("#location_form").children().attr("disabled", "true");
    });
    
})(jQuery);


<?php /*IDE highlight hack*/ if(0) { ?></script><?php } ?>