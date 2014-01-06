<?php
$dst = ( isset( $_GET[ "to" ] )
    ? $_GET[ "to" ]
    : ( isset( $_POST[ "to" ] )
        ? $_POST[ "to" ]
        : false ) );
if ( $dst ):?>
		
<!DOCTYPE html>
<html>
    <header>
        <meta charset="utf-8">
        <title>SickBeard Mobile</title>
        <meta name="description" content="">
        <meta name="HandheldFriendly" content="True">
        <meta name="MobileOptimized" content="320">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="cleartype" content="on">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="img/touch/apple-touch-icon-144x144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/touch/apple-touch-icon-114x114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/touch/apple-touch-icon-72x72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="img/touch/apple-touch-icon-57x57-precomposed.png">
        <link rel="shortcut icon" href="img/touch/apple-touch-icon.png">
        <!-- Tile icon for Win8 (144x144 + tile color) -->
        <meta name="msapplication-TileImage" content="img/touch/apple-touch-icon-144x144-precomposed.png">
        <meta name="msapplication-TileColor" content="#222222">
        
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="themes/sickbeard-mobile.min.css" />
        <link rel="stylesheet" href="themes/jquery.mobile.icons.min.css" />
        <link rel="stylesheet" href="css/jquery.mobile.structure-1.4.0.min.css" />

        <script src="js/vendor/modernizr-2.6.2.min.js"></script>
        <script src="js/vendor/jquery-2.0.3.min.js"></script>
        <script src="js/vendor/jquery.mobile-1.4.0.min.js"></script>
        
        <script>
            $(document).ready(function() {
                $.mobile.loading("show");
                window.location.replace("<?php echo $dst;?>");
            });
        </script>
    </header>
    <body></body>
</html>

<?php endif;?>
