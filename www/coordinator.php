<?php

$title['title'] = '本日の服装は…？';
$title['description'] = '地域の気象予報からあなたに最適な服装を提案します。';


//-----------------------------------


if (isset($_POST['city']) && $_POST['city']!=''){
    
}


//-----------------------------------

$body['left'] = <<< EOM
<form action="index.php" class="form-vertical" method="post">
    <label>都道府県:</label>
    <select id="pref" name="pref" onchange="onSelect(this);">
        <option value="" selected>&lt;選択してください&gt;</option>
    </select>
    <label>都市:</label>
    <select id="city" name="city">
        <option value=""></option>
    </select>
    <br />
    <input class="btn btn-primary" type="submit" value="送信">
</form>
EOM;

$body['right'] = <<< EOM

EOM;

?>
