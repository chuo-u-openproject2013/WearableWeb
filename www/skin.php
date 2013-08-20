<!DOCTYPE html>
<html lang="ja">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Content-Style-Type" content="text/css" />
    <meta http-equiv="Content-Script-Type" content="text/javascript" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />
    <link href="css/main.css" rel="stylesheet" type="text/css" />
    <title><?php echo $title['title']; ?> - Wearable Web</title>
</head>
<body>
    <div class="navbar">
    <div class="navbar-inner">
        <a class="brand pull-right">Wearable Web</a>
        <ul class="nav">
            <li class="active"><a href="./">Home</a></li>
        </ul>
    </div>
    </div>
    
    <div class="container content">
        
        <div class="hero-unit">
        <h1><?php echo $title['title']; ?></h1>
        <p><?php echo $title['description']; ?></p>
        </div>
        
        <hr>
            
        <div class="row">
            <div class="span3">
                <?php echo $body['left']; ?>
            </div>
            <div class="span8 offset1">
                <?php echo $body['right']; ?>
            </div>
        </div>
        
    </div>

    
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js.php" type="text/javascript"></script>
</body>
</html>

