<!DOCTYPE html>
<!--[if IEMobile 7 ]>    <html class="no-js iem7"> <![endif]--> 
<!--[if (gt IEMobile 7)|!(IEMobile)]><!--> <html class="no-js"> <!--<![endif]--> 
    <head>
        <meta charset="utf-8">
        <title>SickBeard Mobile - <?php echo $this->name; ?></title>
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
        <!-- For iOS web apps. Delete if not needed. https://github.com/h5bp/mobile-boilerplate/issues/94 -->
        <!--
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="apple-mobile-web-app-title" content="">
        -->
        <!-- This script prevents links from opening in Mobile Safari. https://gist.github.com/1042026 -->
        <!--
        <script>(function(a,b,c){if(c in b&&b[c]){var d,e=a.location,f=/^(a|html)$/i;a.addEventListener("click",function(a){d=a.target;while(!f.test(d.nodeName))d=d.parentNode;"href"in d&&(d.href.indexOf("http")||~d.href.indexOf(e.host))&&(a.preventDefault(),e.href=d.href)},!1)}})(document,window.navigator,"standalone")</script>
        -->

        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="themes/sickbeard-mobile.min.css" />
        <link rel="stylesheet" href="themes/jquery.mobile.icons.min.css" />
        <link rel="stylesheet" href="css/jquery.mobile.structure-1.4.0.min.css" />
        <link rel="stylesheet" href="css/sickbeard-mobile.css" />

        <script src="js/vendor/modernizr-2.6.2.min.js"></script>
        <script src="js/vendor/jquery-2.0.3.min.js"></script>
        <script src="js/vendor/jquery.mobile-1.4.0.min.js"></script>
    </head>
    <body>
        <div data-role="page" id="<?php echo $this->name; ?>">
            <div data-role="header" data-position="fixed">
                <?php if($this->name == "home"):?>
                <a href="addshow" data-icon="plus" data-iconpos="notext" title="Add Show" data-prefetch="true">Add Show</a>
                <?php else:?>
                <a href="./" data-icon="home" data-iconpos="notext" title="Go Home" data-prefetch="true">Home</a>
                <?php endif;?>
                <h1>SickBeard Mobile</h1>
                <a href="settings" data-icon="gear"<?php echo($this->name == "settings" ? ' class="ui-btn-active"' : '');?> data-iconpos="notext" title="Settings" data-prefetch="true">Settings</a>
            </div><!-- /header -->
            <div role="main" class="ui-content">
