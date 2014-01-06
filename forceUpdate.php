<?php
namespace SickBeardMobile;

require_once('global.php');

if(isset($_GET['id'])) {
    unlink("cache/getShow_$_GET[id].json");
    header("Location: redirect?to=" . $sbm->getPath() . "?id=$_GET[id]");
} else {
    unlink("cache/getShows.json");
    header("Location: redirect?to=" . $sbm->getPath());
}
?>
