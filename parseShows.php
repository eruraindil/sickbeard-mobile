<?php
namespace SickBeardMobile;

require_once('global.php');

function getFile($CACHE_FILE, $criteria) {
    if(file_exists($CACHE_FILE) && (filemtime($CACHE_FILE) < strtotime("-1 day"))) {
        $contents = file_get_contents($CACHE_FILE, 0, null, null);
    } else {
        $contents = contactSickBeard($criteria);
        if($contents != NULL) {
            file_put_contents($CACHE_FILE,$contents,LOCK_EX);
        }
    }
    return $contents;
}

function parseFile($contents) {
    $json_output = json_decode($contents,true);
    if($json_output != NULL) {
        if($json_output['result'] == "denied") {
            header("Location: error?3");
        }
    }
    
    return $json_output;
}

function contactSickBeard($criteria) {
    global $sbm;
    
    $contents = file_get_contents($sbm->getApiUrl() . $criteria, 0, null, null);
    if($contents == NULL) {
        header("Location: error?1");
    }
    
    return $contents;
}

function getShows($sort = "name", $paused = NULL) {
    $CACHE_FILE = "cache/getShows.json";
    $criteria = "shows&sort=$sort" . (isset($paused) ? "&paused=$paused": "");
    
    $contents = getFile($CACHE_FILE,$criteria);
    $json_output = parseFile($contents);
    
    return $json_output['data'];
}

function getShowById($id) {
    $CACHE_FILE = "cache/getShow_$id.json";
    $criteria = "show|show.seasons&tvdbid=$id";
    
    $contents = getFile($CACHE_FILE,$criteria);
    $json_output = parseFile($contents);
    
    return $json_output['data'];
}

function getShowByShowName($name,$id) {
    $CACHE_FILE = "cache/getShow_$id.json";
    $criteria = "show&name=$name";
    
    $contents = getFile($CACHE_FILE,$criteria);
    $json_output = parseFile($contents);
    
    return $json_output['data'];
}

function getShowPoster($id) {
    $contents = contactSickBeard("show.getposter&tvdbid=$id");
    return "data:image/jpeg;base64," . base64_encode($contents);    
}

function getShowThumb($id,$width=100,$height=147) {
    if(file_exists("cache/thumbs/". $id . "_$width" . "x$height" . ".jpg")) {
        return true;
    } else {
        $contents = contactSickBeard("show.getposter&tvdbid=$id");
        return Img_Resize($contents,$id,$width,$height);
    }
}

function getHistory($limit=20) {
    $contents = contactSickBeard("history&limit=$limit");
    $json_output = parseFile($contents);
    
    return $json_output['data'];
}

function getComing($limit=20) {
    $contents = contactSickBeard("future&type=missed|today|soon");
    $json_output = parseFile($contents);

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
    global $SB_LIST_THUMB_W;
    global $SB_LIST_THUMB_H;
    
    echo('<div data-role="collapsible-set" data-inset="false">
    <ul data-role="listview" data-filter="true" data-filter-placeholder="Search shows..." data-inset="false">');
    
    $shows = getShows("name",0);
    foreach($shows as $name=>$show) {
        $id = $show['tvdbid'];
        //if($show['status'] != "Ended") {
            echo("<li><a href='./?id=$show[tvdbid]'>");
            if(getShowThumb($id,$SB_LIST_THUMB_W,$SB_LIST_THUMB_H)) {
                echo("<img src='cache/thumbs/". $id . "_$SB_LIST_THUMB_W" . "x$SB_LIST_THUMB_H" . ".jpg' style='width:" . $SB_LIST_THUMB_W . "px!important;height:". $SB_LIST_THUMB_H . "px!important;' />");
            }
            echo("<h2>" . $name . "</h2></a></li>");
        //}
    }
    echo("</ul></div>");

}

function getShowAsPage($id) {
    global $SB_PAGE_THUMB_W;
    global $SB_PAGE_THUMB_H;
    
    $data = getShowById($id);
    
    $show = $data['show']['data'];
    $seasons = $data['show.seasons']['data'];
    /*if(getShowThumb($id,$SB_PAGE_THUMB_W,$SB_PAGE_THUMB_H)) {
        echo("<a href='#popup-$id' data-rel='popup' data-position-to='window' data-transition='fade'><img src='cache/thumbs/". $id . "_$SB_PAGE_THUMB_W" . "x$SB_PAGE_THUMB_H" . ".jpg' style='width:" . $SB_PAGE_THUMB_W . "px;height:". $SB_PAGE_THUMB_H . "px;' class='popphoto' alt='" . $show['show_name'] . "' />");
        echo("<div data-role='popup' id='popup-$id' data-overlay-theme='b' data-theme='b' data-corners='false'>
        <a href='#' data-rel='back' class='ui-btn ui-corner-all ui-shadow ui-btn-a ui-icon-delete ui-btn-icon-notext ui-btn-right'>Close</a><img class='popphoto' src='" . getShowPoster($id) . "' style='max-height:512px;' alt='" . $show['show_name'] . "'>
        </div>");
    }*/?>
    <div class="ui-grid-a">
        <div class="ui-block-a" style="text-align:center;">
            <a href="#popup-<?php echo $id;?>" data-rel="popup" data-position-to="window" data-transition="fade">
                <img src="<?php echo getShowPoster($id);?>" style="max-width:<?php echo $SB_PAGE_THUMB_W;?>px;max-height:<?php echo $SB_PAGE_THUMB_H;?>px;width:100%;height:auto;display:block;" class="popphoto" alt="<?php echo $show['show_name'];?>" />
            </a>
            <div data-role="popup" id="popup-<?php echo $id;?>" data-overlay-theme="b" data-theme="b" data-corners="false">
                <a href="#" data-rel="back" class="ui-btn ui-corner-all ui-shadow ui-btn-a ui-icon-delete ui-btn-icon-notext ui-btn-right">Close</a>
                <img class="popphoto" src="<?php echo getShowPoster($id);?>" style="max-height:512px;" alt="<?php echo $show['show_name'];?>" />
            </div>
        </div><!-- /ui-block-a -->
        <div class="ui-block-b">
            <a href="forceUpdate?id=<?php echo $id;?>" class="ui-btn ui-btn-inline ui-shadow ui-corner-all ui-btn-icon-left ui-icon-refresh">Force Refresh</a>
            <h2><?php echo $show['show_name'];?></h2>
            <table data-role='table'>
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>airs</th>
                        <td><?php echo $show['airs'];?> on <?php echo $show['network']?></td>
                    </tr>
                    <tr>
                        <th>status</th>
                        <td><?php echo $show['status'];?></td>
                    </tr>
                    <tr>
                        <th>quality</th>
                        <td><?php echo $show['quality'];?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <?php
}

function getComingShowsAsList($num) {
    echo('<ul data-role="listview" data-inset="true" data-divider-theme="b">');
    foreach(getComing($num) as $section => $contents) {
        if($contents != NULL) {
            echo('<li data-role="list-divider">');
                echo ucfirst($section);
                echo("<span class='ui-li-count'>" . count($contents) . "</span>
            </li>");
            foreach($contents as $item) {
                echo("<li>
                    <a href='./?id=" . $item['tvdbid'] . "'>" . 
                        $item['airdate'] . " - " .
                        $item['show_name'] . " " . $item['season'] . "x" . $item['episode'] . " - <em>" . $item['ep_name'] . "</em>
                    </a>
                </li>");
            }
        }
    }
    echo('</ul>');
}

function getHistoryAsList($num) {
    echo('<div data-role="collapsible-set" data-inset="false">
    <ul data-role="listview" data-inset="false">');
    foreach(getHistory($num) as $show) {
        echo("<li><a href='./?id=$show[tvdbid]'>");
        echo(date("Y-m-d @ h:i",strtotime($show['date'])) . " " .
            $show['show_name'] . " - " . $show['season'] . "x" . $show['episode'] . "</a></li>");
    }
    echo("</ul></div>");
}

?>
