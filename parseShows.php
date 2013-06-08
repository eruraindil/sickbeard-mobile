<?php
namespace SickBeardMobile;

require_once('global.php');

function getShows($sort = "id", $paused = NULL) {

    global $sbm;

    $criteria = "shows&sort=$sort" . (isset($paused) ? "&paused=$paused": "");
    $json = file_get_contents($sbm->getApiUrl() . $criteria, 0, null, null);
    $json_output = json_decode($json,true);
    return $json_output['data'];
}

function getShowById($id) {

}

function getShowByShowName($name) {
    
}

function getShowPoster($id, $width = NULL) {
    global $sbm;

    $criteria = "show.getposter&tvdbid=$id";
    $contents = file_get_contents($sbm->getApiUrl() . $criteria, 0, null, null);
    //$contents = file_get_contents($file);
    return "data:image/png;base64," . base64_encode($contents);
    //return $json;
    //$json_output = json_decode($json,true);
    //return $json_output['data'];
}

function getHistory($limit=20) {
    global $sbm;

    $criteria = "history&limit=$limit";
    $json = file_get_contents($sbm->getApiUrl() . $criteria, 0, null, null);
    $json_output = json_decode($json,true);
    return $json_output['data'];
}

function getComing($limit=20) {
    global $sbm;

    $criteria = "future&type=missed|today|soon";
    $json = file_get_contents($sbm->getApiUrl() . $criteria, 0, null, null);
    $json_output = json_decode($json,true);

    $missed = $json_output['data']['missed'];
    $today = $json_output['data']['today'];
    $soon = $json_output['data']['soon'];

    $output = array();

    $output['missed'] = $missed;
    $output['today'] = $today;
    $output['soon'] = $soon;

    return $output;
}

?>