<?php
namespace SickBeardMobile;

require_once('dataStructures.php');
require_once('global.php');

function getShows($sort = "id", $paused = NULL) {
    global $sbm;

    $criteria = "shows&sort=$sort" . (isset($paused) ? "&paused=$paused": "");
    $json = file_get_contents($sbm->getApiUrl() . $criteria, 0, null, null);
    $json_output = json_decode($json,true);
    return $json_output['data'];
}

function getShowById($id) {
    global $sbm;
    
    $criteria = "show&tvdbid=$id";
    $json = file_get_contents($sbm->getApiUrl() . $criteria, 0, null, null);
    $json_output = json_decode($json,true);
    return $json_output['data'];
}

function getShowByShowName($name) {
    
}

function getShowPoster($id, $width) {
    global $sbm;

    $criteria = "show.getposter&tvdbid=$id";
    $contents = file_get_contents($sbm->getApiUrl() . $criteria, 0, null, null);
    return "data:image/jpeg;base64," . base64_encode($contents);    
}

function getShowThumb($id,$width=100,$height=147) {
    global $sbm;

    if(file_exists("thumbs/". $id . "_$w" . "x$h" . ".jpg")) {
        return true;
    } else {
        $criteria = "show.getposter&tvdbid=$id";
        $contents = file_get_contents($sbm->getApiUrl() . $criteria, 0, null, null);
        return Img_Resize($contents,$id,$width,$height);
    }
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
    foreach(getShows("name",0) as $name=>$show) {
        if($show['status'] != "Ended") {
            echo("<li><a href='?id=$show[tvdbid]'>");
            if(getShowThumb($show['tvdbid'],$SB_LIST_THUMB_W,$SB_LIST_THUMB_H)) {
                echo("<img src='thumbs/". $show['tvdbid'] . "_$SB_LIST_THUMB_W" . "x$SB_LIST_THUMB_H" . ".jpg' style='width:" . $SB_LIST_THUMB_W . "px;height:". $SB_LIST_THUMB_H . "px;' />");
            }
            echo("<h2>" . $show['show_name'] . "</h2></a></li>");
        }
    }
    echo("</ul></div>");
}

function getShowAsPage($id) {
    $show = getShowById($id);
    if(getShowThumb($id,$SB_PAGE_THUMB_W,$SB_PAGE_THUMB_H)) {
        echo("<img src='thumbs/". $id . "_$SB_PAGE_THUMB_W" . "x$SB_PAGE_THUMB_H" . ".jpg' style='width:" . $SB_PAGE_THUMB_W . "px;height:". $SB_PAGE_THUMB_H . "px;' />");
    }
    
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
