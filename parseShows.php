<?php
namespace SickBeardMobile;

require_once('global.php');

function getShows($sort = "id", $paused = NULL) {

    global $sbm;

    $shows = "shows&sort=$sort" . (isset($paused) ? "&paused=$paused": "");
    $json = file_get_contents($sbm->getApiUrl() . $shows, 0, null, null);
    $json_output = json_decode($json,true);
    return $json_output;
}

function getShowById($id) {
    
}

function getShowByShowName($name) {
    
}

?>