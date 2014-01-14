<?php
namespace SickBeardMobile;

require_once('global.php');

if(isset($_GET['id'])) {
    global $SB_PAGE_THUMB_W;
    global $SB_PAGE_THUMB_H;
    global $SB_LIST_THUMB_W;
    global $SB_LIST_THUMB_H;
    
    unlink("cache/getShow_$_GET[id].json");
    unlink("cache/thumbs/$_GET[id]_$SB_LIST_THUMB_W" . "x$SB_LIST_THUMB_H.jpg");
    unlink("cache/thumbs/$_GET[id]_$SB_PAGE_THUMB_W" . "x$SB_PAGE_THUMB_H.jpg");
    unlink("cache/thumbs/$_GET[id].jpg");
    
    header("Location: redirect?to=./?id=$_GET[id]");
} else {
    unlink("cache/getShows_byname.json");
    unlink("cache/getShows_byid.json");
    header("Location: redirect?to=./");
}
?>
