<?php
require_once 'lib/request_lwws.php';
require_once 'lib/func.php';

if (isset($_POST['city']) && $_POST['city']!=''){
    $lwws_ary = request_lwws($_POST['city']);
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
        <form action="index.php" name="CityForm" method="post">
                    <label>都道府県:</label>
                    <select name="pref" onchange="Select(this)">
                        <option value="" selected></option>
                        <?php
                        $pref = list_pref();
                        foreach ($pref as $val){
                            echo '<option value="'.$val.'">'.$val.'</option>'."\n";
                        }
                        ?>
                    </select>
                    <label>都市:</label>
                    <select name="city">
                        <option value=""></option>
                    </select>
                    <input type="submit" value="送信">
        </form>
        
        <?php if(isset($lwws_ary)){ ?>
        <h2>天気予報</h2>
        <?php
            echo '<h3>'.$lwws_ary['location']['prefecture'].' - '.$lwws_ary['location']['city'].'</h3>';
            echo '<table border="1" cellpadding="2">';
            echo '<tr> <td></td><td>日付</td><td>予報</td><td>最低/最高気温</td><td>画像</td></tr>';
            foreach($lwws_ary['forecasts'] as $forecasts=>$idx){
                echo '<tr><td>'.$idx['dateLabel'].'</td>';
                echo '<td>'.$idx['date'].'</td>';
                echo '<td>'.$idx['telop'].'</td>';
                echo '<td>'.$idx['temperature']['min']['celsius'].'/'.$idx['temperature']['max']['celsius'].'</td>';
                echo '<td><img src="'.$idx['image']['url'].'" ></td></tr>';
            }
            echo '</table>';
         ?>
         <p>Powered by <a href="http://weather.livedoor.com/weather_hacks/webservice">livedoor 天気情報</a></p>
        
         <h2>Debug</h2>
         <pre>
         <?php print_r($lwws_ary); ?>
         </pre>
         
         <h2>快適な服装！</h2>
         <p style="font-size: 1.5em;color: red;">工事中！！！！</p>
         <?php } ?>

    </body>
</html>
