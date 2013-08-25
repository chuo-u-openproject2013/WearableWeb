<?php

$title['title'] = '本日の服装は…？';
$title['description'] = '地域の気象予報からあなたに最適な服装を提案します。';


//-----------------------------------


if (isset($_POST['city']) && $_POST['city']!=''){
    
}


//-----------------------------------

$body['left'] = <<< EOM
<form class="form-vertical" id="location_form" method="post">
    <label>都道府県:</label>
    <select class="span3" id="pref">
        <option value="" selected>&lt;選択してください&gt;</option>
    </select>
    <label>都市:</label>
    <select class="span3" id="city">
        <option value=""></option>
    </select>
    <br />
    <input class="btn btn-primary" id="submit" type="button" value="送信">
</form>
EOM;

$body['right'] = <<< EOM
<div id="description"></div>
<div id="chart"></div>
<div id="debug"></div>
EOM;


$scripts = <<< EOM
<script src="js/highcharts.js" type="text/javascript"></script>
<script src="js/main.js.php" type="text/javascript"></script>    
EOM;

?>
