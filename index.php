<?php
namespace SickBeardMobile;

require_once('parseShows.php');

?>


<!DOCTYPE html>
<!--[if IEMobile 7 ]>    <html class="no-js iem7"> <![endif]-->
<!--[if (gt IEMobile 7)|!(IEMobile)]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
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
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/jquery.mobile-1.3.1.min.css" />
        <link rel="stylesheet" href="themes/sickbeard-mobile.min.css" />
        <link rel="stylesheet" href="css/jquery.mobile.structure-1.3.1.min.css" />

        <script src="js/vendor/modernizr-2.6.2.min.js"></script>
        <script src="js/vendor/jquery-2.0.2.min.js"></script>
        <script src="js/vendor/jquery.mobile-1.3.1.min.js"></script>
    </head>
    <body>
        <div data-role="page" id="home">
            <div data-role="header" data-id="header" data-position="fixed">
                <a href="#" data-icon="plus" data-iconpos="notext" title="Add Show">Add Show</a>
                <h1>SickBeard Mobile</h1>
                <a href="#" data-icon="gear" data-iconpos="notext" title="Settings">Settings</a>
            </div><!-- /header -->
            <div data-role="content">
                <div data-role="collapsible-set" data-inset="false">
                <ul data-role="listview" data-inset="false">
                <?php foreach(getShows() as $id=>$show):?>
                    <li><a href="#<?php echo $id;?>">
                        <img src="<?php echo getShowPoster($id,"100px");?>" style="width:100px; height:147px;" />
                        <h2><?php echo $show['show_name'];?></h2></a>
                    </li>
                <?php endforeach;?>
                </ul>
                </div>
                <?php //rprint(getShows());?>
            </div><!-- /content -->
            <div data-role="footer" data-id="foo1" data-position="fixed" data-theme="b">
                <div data-role="navbar">
                    <ul>
                        <li><a href="#coming" data-icon="star">Coming</a></li>
                        <li><a href="#history" data-icon="info">History</a></li> <!--  class="ui-btn-active" -->
                        <li><a href="#log" data-icon="alert">Log</a></li>
                    </ul>
                </div><!-- /navbar -->
            </div><!-- /footer -->
        </div><!-- /page -->
        <div data-role="page" id="show">
            <div data-role="header" data-id="header" data-position="fixed">
                <a href="#" data-icon="back" data-iconpos="notext" data-rel="back" title="Go Home">Home</a>
                <h1>SickBeard Mobile</h1>
                <a href="#" data-icon="gear" data-iconpos="notext" title="Settings">Settings</a>
            </div><!-- /header -->
            <div data-role="content">
            </div>
            <div data-role="footer" data-id="foo1" data-position="fixed" data-theme="b">
                <div data-role="navbar">
                    <ul>
                        <li><a href="#coming" data-icon="star">Coming</a></li>
                        <li><a href="#history" data-icon="info">History</a></li> <!--  class="ui-btn-active" -->
                        <li><a href="#log" data-icon="alert">Log</a></li>
                    </ul>
                </div><!-- /navbar -->
            </div><!-- /footer -->
        </div>

        <div data-role="page" id="coming">
            <div data-role="header" data-id="header" data-position="fixed">
                <a href="#" data-icon="back" data-iconpos="notext" data-rel="back" title="Go Home">Home</a>
                <h1>SickBeard Mobile</h1>
                <a href="#" data-icon="gear" data-iconpos="notext" title="Settings">Settings</a>
            </div><!-- /header -->
            <div data-role="content">
                <ul data-role="listview" data-inset="true" data-divider-theme="b">
                <?php foreach(getComing(10) as $section => $contents):?>
                    <li data-role="list-divider">
                        <?php echo ucfirst($section);?>
                        <span class="ui-li-count"><?php echo count($contents);?></span>
                    </li>
                    <?php foreach($contents as $item):?>
                        <li>
                            <a href="#<?php echo $item['tvdbid'];?>">
                                <?php echo $item['airdate'] . " @ " . date("ga",strtotime($item['airs']));?>
                                <?php echo $item['show_name'];?>
                                <?php echo $item['season'];?>x<?php echo $item['episode'];?> - 
                                <em><?php echo $item['ep_name'];?></em>
                            </a>
                        </li>
                    <?php endforeach;
                endforeach;?>
                </ul>
            </div>
            <div data-role="footer" data-id="foo1" data-position="fixed" data-theme="b">
                <div data-role="navbar">
                    <ul>
                        <li><a href="#coming" data-icon="star" class="ui-btn-active">Coming</a></li>
                        <li><a href="#history" data-icon="info">History</a></li>
                        <li><a href="#log" data-icon="alert">Log</a></li>
                    </ul>
                </div><!-- /navbar -->
            </div><!-- /footer -->
        </div>

        <div data-role="page" id="history">
            <div data-role="header" data-id="header" data-position="fixed">
                <a href="#" data-icon="back" data-iconpos="notext" data-rel="back" title="Go Home">Home</a>
                <h1>SickBeard Mobile</h1>
                <a href="#" data-icon="gear" data-iconpos="notext" title="Settings">Settings</a>
            </div><!-- /header -->
            <div data-role="content">
<table data-role="table" id="movie-table" data-mode="reflow" class="ui-responsive table-stroke">
  <thead>
    <tr>
      <th data-priority="2">Date</th>
      <th data-priority="persist">Show</th>
      <th data-priority="1">Episode</th>
      <th data-priority="3">Status</th>
    </tr>
  </thead>
  <tbody>
                <?php foreach(getHistory(10) as $dl):?>
    <tr>
      <th><?php echo date("Y-m-d H:i",strtotime($dl['date']));?></th>
      <td><?php echo $dl['show_name'];?></td>
      <td><?php echo $dl['season'];?>x<?php echo $dl['episode'];?></td>
      <td><?php echo $dl['status'];?></td>
    </tr>
                <?php endforeach;?>
</table>
            </div>
            <div data-role="footer" data-id="foo1" data-position="fixed" data-theme="b">
                <div data-role="navbar">
                    <ul>
                        <li><a href="#coming" data-icon="star">Coming</a></li>
                        <li><a href="#history" data-icon="info" class="ui-btn-active">History</a></li>
                        <li><a href="#log" data-icon="alert">Log</a></li>
                    </ul>
                </div><!-- /navbar -->
            </div><!-- /footer -->
        </div>
        
        <script src="js/helper.js"></script>
        <script src="js/main.js"></script>

        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
            var _gaq=[["_setAccount","UA-XXXXX-X"],["_trackPageview"]];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.async=1;
            g.src='//www.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,"script"));
        </script>
    </body>
</html>