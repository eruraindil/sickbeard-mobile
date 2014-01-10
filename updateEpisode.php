<?php
namespace SickBeardMobile;

require_once('global.php');

if(isset($_GET['id'])) {
    contactSickBeard("episode.setstatus&tvdbid=$_GET[id]&season=$_GET[s]&episode=$_GET[e]&status=$_GET[status]&force=1");
    header("Location: forceUpdate?id=$_GET[id]");
} else {
    header("Location: redirect?to=./");
}

?>
