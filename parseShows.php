<?php
namespace SickBeardMobile;

require_once('dataStructures.php');

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

function getShowsAsList() {
    echo('<div data-role="collapsible-set" data-inset="false">
    <ul data-role="listview" data-inset="false">');
    foreach(getShows() as $id=>$show) {
        echo("<li><a href='#$id'>");
            echo("<img src='" . getShowPoster($id,"100px") . "' style='width:100px; height:147px;' />");
            echo("<h2>" . $show['show_name'] . "</h2></a>
        </li>");
    }
    echo("</ul>
    </div>");

    //rprint(getShows());
}

function getComingShows($num) {
    echo('<ul data-role="listview" data-inset="true" data-divider-theme="b">');
    foreach(getComing($num) as $section => $contents) {
        echo('<li data-role="list-divider">');
            echo ucfirst($section);
            echo("<span class='ui-li-count'>" . count($contents) . "</span>
        </li>");
        foreach($contents as $item) {
            echo("<li>
                <a href='#" . $item['tvdbid'] . "'>" . 
                    $item['airdate'] . " @ " . 
                    date("ga",strtotime($item['airs'])) . " " .
                    $item['show_name'] . " " . $item['season'] . "x" . $item['episode'] . " - <em>" . $item['ep_name'] . "</em>
                </a>
            </li>");
        }
    }
    echo('</ul>');
}

?>