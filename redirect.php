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
