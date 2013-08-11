<?php
require_once 'lib/func.php';

if (isset($_POST['city']) && $_POST['city']!=''){
    
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="Content-Style-Type" content="text/css">
	<meta http-equiv="Content-Script-Type" content="text/javascript">
        <link href="main.css" rel="stylesheet" type="text/css">
        <script src="main.js.php" type="text/javascript"></script>
        <title>Wearable Web</title>
    </head>
    <body>
	<h1>本日の服装は…？</h1>
        <form action="index.php" name="CitySelectForm" method="post">
                    <label>都道府県:</label>
                    <select name="pref" onchange="Select(this)">
                        <option value="" selected></option>
                    </select>
                    <label>都市:</label>
                    <select name="city">
                        <option value=""></option>
                    </select>
                    <input type="submit" value="送信">
        </form>
        

    </body>
</html>
