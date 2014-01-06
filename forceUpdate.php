<?php

if(isset($_GET['id'])) {
    unlink("cache/getShow_$_GET[id].json");
    header("Location: ./?id=$_GET[id]");
} else {
    unlink("cache/getShows.json");
    header("Location: ./");
}
?>
