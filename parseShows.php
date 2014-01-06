<?php
namespace SickBeardMobile;

require_once('global.php');

function contactSickBeard($criteria) {
    global $sbm;
    
    $contents = file_get_contents($sbm->getApiUrl() . $criteria, 0, null, null);
    if($contents == NULL) {
        header("Location: error.php?1");
    }
    
    return $contents;
}

function getShows($sort = "name", $paused = NULL) {
    $contents = contactSickBeard("shows&sort=$sort" . (isset($paused) ? "&paused=$paused": ""));
    $json_output = json_decode($contents,true);
    return $json_output['data'];
}

function getShowById($id) {
    $contents = contactSickBeard("show&tvdbid=$id");
    $json_output = json_decode($contents,true);
    return $json_output['data'];
}

function getShowByShowName($name) {
    $contents = contactSickBeard("show&name=$name");
    $json_output = json_decode($contents,true);
    return $json_output['data'];
}

function getShowPoster($id, $width) {
    $contents = contactSickBeard("show.getposter&tvdbid=$id");
    return "data:image/jpeg;base64," . base64_encode($contents);    
}

function getShowThumb($id,$width=100,$height=147) {
    if(file_exists("thumbs/". $id . "_$w" . "x$h" . ".jpg")) {
        return true;
    } else {
        $contents = contactSickBeard("show.getposter&tvdbid=$id");
        return Img_Resize($contents,$id,$width,$height);
    }
}

function getHistory($limit=20) {
    $contents = contactSickBeard("history&limit=$limit");
    $json_output = json_decode($contents,true);
    return $json_output['data'];
}

function getComing($limit=20) {
    $contents = contactSickBeard("future&type=missed|today|soon");
    $json_output = json_decode($contents,true);

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

function getComingShowsAsList($num) {
    echo('<ul data-role="listview" data-inset="true" data-divider-theme="b">');
    foreach(getComing($num) as $section => $contents) {
        echo('<li data-role="list-divider">');
            echo ucfirst($section);
            echo("<span class='ui-li-count'>" . count($contents) . "</span>
        </li>");
        foreach($contents as $item) {
            echo("<li>
                <a href='?" . $item['tvdbid'] . "'>" . 
                    $item['airdate'] . " @ " . 
                    date("ga",strtotime($item['airs'])) . " " .
                    $item['show_name'] . " " . $item['season'] . "x" . $item['episode'] . " - <em>" . $item['ep_name'] . "</em>
                </a>
            </li>");
        }
    }
    echo('</ul>');
}

function getHistoryAsList($num) {
    echo('<div data-role="collapsible-set" data-inset="false">
    <ul data-role="listview" data-inset="false">');
    foreach(getHistory($num) as $show) {
        echo("<li><a href='?id=$show[tvdbid]'>");
        echo(date("ga",strtotime($show['date'])) . " " .
            $show['show_name'] . " " . $show['season'] . "x" . $show['episode'] . "</a></li>");
    }
    echo("</ul></div>");
}

?>
