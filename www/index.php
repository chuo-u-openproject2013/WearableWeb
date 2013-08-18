<?php
require_once 'lib/func.php';
require_once 'lib/owm_api.php';

if (isset($_POST['city']) && $_POST['city']!=''){
    
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ja" xml:lang="ja">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Content-Style-Type" content="text/css" />
    <meta http-equiv="Content-Script-Type" content="text/javascript" />
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="css/main.css" rel="stylesheet" type="text/css" />
    <script src="js/main.js.php" type="text/javascript"></script>
    <title>Wearable Web</title>
</head>
<body onload="Init();">
    <div class="container">
        <h1>本日の服装は…？</h1>
        <hr>
        <div class="row">
            <div class="span3">
                <form action="index.php" class="form-vertical" method="post">
                    <label>都道府県:</label>
                    <select id="pref" name="pref" onchange="onSelect(this);">
                        <option value="" selected></option>
                    </select>
                    <label>都市:</label>
                    <select id="city" name="city">
                        <option value=""></option>
                    </select>
                    <br />
                    <input class="btn btn-primary" type="submit" value="送信">
                </form>
            </div>
            <div class="span9">
                <h2>出力:</h2>
            </div>
        </div>
    </div>

    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
