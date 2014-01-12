<?php
namespace SickBeardMobile;

require_once('global.php');

function getFile($CACHE_FILE, $criteria) {
    if(file_exists($CACHE_FILE) && (strtotime("-1 day") - filemtime($CACHE_FILE) < 0)) {
        $contents = file_get_contents($CACHE_FILE, 0, null, null);
    } else {
        $contents = contactSickBeard($criteria);
        if($contents != NULL) {
            file_put_contents($CACHE_FILE,$contents,LOCK_EX);
        }
    }
    return $contents;
}

function parseJsonFile($contents) {
    $json_output = json_decode($contents,true);
    if($json_output != NULL) {
        if($json_output['result'] == "denied") {
            header("Location: redirect?to=error?3");
        }
    }
    
    return $json_output;
}

function contactSickBeard($criteria) {
    global $sbm;
    
    $contents = file_get_contents($sbm->getApiUrl() . $criteria, 0, null, null);
    if($contents == NULL) {
        header("Location: redirect?to=error?1");
    }
    
    return $contents;
}

function getShows($sort = "name") {
    $CACHE_FILE = "cache/getShows_by$sort.json";
    $criteria = "shows&sort=$sort";
    
    $contents = getFile($CACHE_FILE,$criteria);
    $json_output = parseJsonFile($contents);
    
    if($sort == "name") {
        $sorted = uksort($json_output['data'], "SickBeardMobile\cmp");
    }
    
    return $json_output['data'];
}

function getShowById($id) {
    $CACHE_FILE = "cache/getShow_$id.json";
    $criteria = "show|show.seasons&tvdbid=$id";
    
    $contents = getFile($CACHE_FILE,$criteria);
    $json_output = parseJsonFile($contents);
    
    return $json_output['data'];
}

function getShowByShowName($name,$id) {
    $CACHE_FILE = "cache/getShow_$id.json";
    $criteria = "show&name=$name";
    
    $contents = getFile($CACHE_FILE,$criteria);
    $json_output = parseJsonFile($contents);
    
    return $json_output['data'];
}

function getShowPoster($id) {
    $CACHE_FILE = "cache/thumbs/". $id . ".jpg";
    if(!file_exists($CACHE_FILE)) {
        $contents = contactSickBeard("show.getposter&tvdbid=$id");
        if($contents != NULL) {
            $img = imagecreatefromjpeg("data:image/jpeg;base64," . base64_encode($contents));
            imagejpeg( $img, "cache/thumbs/". $id . ".jpg", 80 );
            //file_put_contents($CACHE_FILE, "data:image/jpeg;base64," . base64_encode($contents),LOCK_EX);
        }
    }
    
    if(file_exists($CACHE_FILE)) {
        return true;
    } else {
        return false;// "data:image/jpeg;base64," . base64_encode($contents);    
    }
}

function getShowThumb($id,$width=100,$height=147) {
    if(file_exists("cache/thumbs/". $id . "_$width" . "x$height" . ".jpg")) {
        return true;
    } else {
        $contents = contactSickBeard("show.getposter&tvdbid=$id");
        if($contents != NULL) {
            return Img_Resize($contents,$id,$width,$height);
        } else {
            return false;
        }
    }
}

function getHistory($limit=20) {
    $contents = contactSickBeard("history&limit=$limit");
    $json_output = parseJsonFile($contents);
    
    return $json_output['data'];
}

function getComing($limit=20) {
    $contents = contactSickBeard("future&type=missed|today|soon");
    $json_output = parseJsonFile($contents);

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
    
    if(isset($_POST['display'])) {
        $_SESSION['display'] = $_POST['display'];
    } elseif(isset($_SESSION['display'])) {
        $_POST['display'] = $_SESSION['display'];
    } else {
        $_POST['display'] = "Continuing";
    }
    
    ?>
    <div class="pull-right">
        <a href="forceUpdate" class="ui-btn ui-mini ui-btn-inline ui-icon-refresh ui-btn-icon-notext" title="Force Update" data-ajax="false">Force Update</a>
        <a href="updateXBMC" class="ui-btn ui-mini ui-btn-inline ui-btn-inline-last ui-btn-icon-notext ui-icon-action" data-iconpos="notext" title="Update XBMC" data-ajax="false">Update XBMC</a>
    </div>
    <div data-role="collapsible" data-inset="false" style="clear:right;">
        <h2>
            Options
        </h2>
        <form method="post">
            <ul data-role="listview" data-inset="true">
                <li>
                    <fieldset data-role="controlgroup" data-type="horizontal" data-mini="true">
                        <legend>Display:</legend>
                        <input type="radio" name="display" id="display-a" value="Continuing"<?=(((isset($_POST['display']) && $_POST['display'] == 'Continuing') || !isset($_POST['display'])) ? 'checked="checked"' : '')?>>
                        <label for="display-a">Continuing</label>
                        <input type="radio" name="display" id="display-b" value="Ended"<?=(isset($_POST['display']) && $_POST['display'] == 'Ended' ? 'checked="checked"' : '')?>>
                        <label for="display-b">Ended</label>
                        <input type="radio" name="display" id="display-c" value="Paused"<?=(isset($_POST['display']) && $_POST['display'] == 'Paused' ? 'checked="checked"' : '')?>>
                        <label for="display-c">Paused</label>
                        <input type="radio" name="display" id="display-d" value="All"<?=(isset($_POST['display']) && $_POST['display'] == 'All' ? 'checked="checked"' : '')?>>
                        <label for="display-d">All</label>
                    </fieldset>
                </li>
                <li>
                    <button type="submit" class="ui-btn">Submit</button>
                </li>
            </ul>
        </form>
    </div>
    <ul data-role="listview" data-filter="true" data-filter-placeholder="Search shows..." data-inset="false" style="clear:both;">
    <?php $shows = getShows("name");
    foreach($shows as $name=>$show) {
        $id = $show['tvdbid'];
        
        if(
            (isset($_POST['display']) && $_POST['display'] == $show['status']) ||
            (isset($_POST['display']) && $_POST['display'] == "Paused" && $show['paused'] == 1) ||
            (isset($_POST['display']) && $_POST['display'] == "All") ||
            (!isset($_POST['display']) && $show['status'] == "Continuing")
        ) {
            echo("<li id='show-list'><a href='./?id=$show[tvdbid]'>");
            if(getShowThumb($id,$SB_LIST_THUMB_W,$SB_LIST_THUMB_H)) {
                echo("<img src='cache/thumbs/". $id . "_$SB_LIST_THUMB_W" . "x$SB_LIST_THUMB_H" . ".jpg' style='width:" . $SB_LIST_THUMB_W . "px!important;height:". $SB_LIST_THUMB_H . "px!important;' />");
            }
            echo("<h2>" . $name . "</h2></a></li>");
        }
    }?>
    </ul>
    <?php
}

function getShowAsPage($id) {
    global $SB_PAGE_THUMB_W;
    global $SB_PAGE_THUMB_H;
    global $SB_LIST_THUMB_W;
    global $SB_LIST_THUMB_H;
    
    $data = getShowById($id);
    
    $show = $data['show']['data'];
    $seasons = $data['show.seasons']['data'];
    /*if(getShowThumb($id,$SB_PAGE_THUMB_W,$SB_PAGE_THUMB_H)) {
         * <img src="<?php echo getShowPoster($id);?>" style="max-width:<?php echo $SB_PAGE_THUMB_W;?>px;max-height:<?php echo $SB_PAGE_THUMB_H;?>px;width:100%;height:auto;display:block;" class="popphoto" alt="<?php echo $show['show_name'];?>" />
         * 
        echo("<a href='#popup-$id' data-rel='popup' data-position-to='window' data-transition='fade'>");
        echo("<div data-role='popup' id='popup-$id' data-overlay-theme='b' data-theme='b' data-corners='false'>
        <a href='#' data-rel='back' class='ui-btn ui-corner-all ui-shadow ui-btn-a ui-icon-delete ui-btn-icon-notext ui-btn-right'>Close</a><img class='popphoto' src='" . getShowPoster($id) . "' style='max-height:512px;' alt='" . $show['show_name'] . "'>
        </div>");
    }*/
    
    $havePoster = getShowPoster($id); ?>
    <div data-role="popup" id="popup-<?php echo $id;?>" data-overlay-theme="b" data-theme="b" data-corners="false">
        <a href="#" data-rel="back" class="ui-btn ui-corner-all ui-shadow ui-btn-a ui-icon-delete ui-btn-icon-notext ui-btn-right">Close</a>
        <img class="popphoto" src="cache/thumbs/<?=$id;?>.jpg" style="max-height:512px;" alt="<?php echo $show['show_name'];?>" />
    </div>
    
    <div id="show-poster" class="pull-left">
        <?php if($havePoster) {
            echo('<a href="#popup-'. $id .'" data-rel="popup" data-position-to="window" data-transition="fade">');
        }
        if(getShowThumb($id,$SB_PAGE_THUMB_W,$SB_PAGE_THUMB_H)) {
            echo("<img src='cache/thumbs/". $id . "_$SB_PAGE_THUMB_W" . "x$SB_PAGE_THUMB_H" . ".jpg' style='width:" . $SB_PAGE_THUMB_W . "px!important;height:". $SB_PAGE_THUMB_H . "px!important;' />");
        }
        if($havePoster) {
            echo('</a>');
        }?>
    </div>
    <div id="show-details">
        <div class="pull-right">
            <a href="forceUpdate?id=<?php echo $id;?>" class="ui-btn ui-mini ui-btn-inline ui-icon-refresh ui-btn-icon-notext" title="Force Update" data-ajax="false">Force Update</a>
            <a href="updateXBMC?id=<?=$id;?>" class="ui-btn ui-mini ui-btn-inline ui-btn-inline-last ui-btn-icon-notext ui-icon-action" data-iconpos="notext" title="Update XBMC" data-ajax="false">Update XBMC</a>
        </div>
        <h2 class="ui-bar"><?php echo $show['show_name'];?></h2>
        <div id="show-header" class="ui-body">
            <div id="show-poster-small" class="pull-left">
                <?php if($havePoster) {
                    echo('<a href="#popup-'. $id .'" data-rel="popup" data-position-to="window" data-transition="fade">');
                }
                    if(getShowThumb($id,$SB_LIST_THUMB_W,$SB_LIST_THUMB_H)) {
                        echo("<img src='cache/thumbs/". $id . "_$SB_LIST_THUMB_W" . "x$SB_LIST_THUMB_H" . ".jpg' style='width:" . $SB_LIST_THUMB_W . "px!important;height:". $SB_LIST_THUMB_H . "px!important;' />");
                    }
                if($havePoster) {
                    echo("</a>");
                }?>
            </div>
            <table>
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
                        <th>paused</th>
                        <td><?php if($show['paused']) { echo "yes";} else { echo "no";}?></td>
                    </tr>
                    <tr>
                        <th>quality</th>
                        <td><?php echo $show['quality'];?></td>
                    </tr>
                    <tr>
                        <th>seasons</th>
                        <td><?php foreach(array_reverse($show['season_list'],true) as $seasonNum):?>
                            <a href="?id=<?=$id;?>#season-<?=$seasonNum;?>" data-ajax="false"><?=$seasonNum;?></a>
                        <?php endforeach;?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <ul data-role="listview" data-inset="true" data-divider-theme="b">
            <?php foreach(array_reverse($seasons,true) as $season=>$episodes):?>
            <li id="season-<?=$season;?>"data-role="list-divider">Season <?=$season;?></li>
            <?php foreach(array_reverse($episodes,true) as $episode=>$details):?>
            <?php if($details['status'] != "Unaired"):?>
            <li data-icon="false">
                <a href="#popup<?=$season.$episode?>" data-rel="popup" data-transition="pop"<?php
                    if($details['status'] == 'Downloaded') {
                        echo(' style="background-color:#E2FFD8!important;"');
                    } else if($details['status'] == 'Wanted') {
                        echo(' style="background-color:#FDEBF3!important;"');
                    } else if($details['status'] == 'Snatched') {
                        echo(' style="background-color:#F5F1E4!important;"');
                    }?>>
                    <strong><?=$episode;?>.</strong> <?=$details['name'];?>
                    <span class='ui-li-count'><?=$details['status'];?></span>
                </a>
            </li>
            <?php else:?>
            <li data-icon="false">
                <strong><?=$episode;?>.</strong> <?=$details['name'];?>
                <span class='ui-li-count'><?=$details['status'];?></span>
            </li>
            <?php endif;?>
            <div data-role="popup" id="popup<?=$season.$episode?>" data-theme="a">
                <ul data-role="listview" data-inset="true" style="min-width:210px;">
                    <li data-role="list-divider">Change status</li>
                    <li><a href="updateEpisode?id=<?=$id;?>&amp;s=<?=$season;?>&amp;e=<?=$episode;?>&amp;status=wanted" data-ajax="false">Wanted</a></li>
                    <li><a href="updateEpisode?id=<?=$id;?>&amp;s=<?=$season;?>&amp;e=<?=$episode;?>&amp;status=skipped" data-ajax="false">Skipped</a></li>
                    <li><a href="updateEpisode?id=<?=$id;?>&amp;s=<?=$season;?>&amp;e=<?=$episode;?>&amp;status=archived" data-ajax="false">Archived</a></li>
                    <li><a href="updateEpisode?id=<?=$id;?>&amp;s=<?=$season;?>&amp;e=<?=$episode;?>&amp;status=ignored" data-ajax="false">Ignored</a></li>
                </ul>
            </div>
            <?php endforeach;?>
            <?php endforeach;?>
        </ul>
    </div>
    <?php
}

function getComingShowsAsList($num) {
    echo('<ul data-role="listview" data-inset="true" data-divider-theme="b">');
    foreach(getComing($num) as $section => $contents) {
        if($contents != NULL) {
            echo('<li data-role="list-divider">');
                echo ucfirst($section);
                echo("<span class='ui-li-count'>" . count($contents) . "</span>");
            echo("</li>");
            foreach($contents as $item) {
                echo("<li>
                    <a href='./?id=" . $item['tvdbid'] . "'");
                if($section == 'today') {
                    echo(' style="background-color:#E2FFD8!important;"');
                } else if($section == 'missed') {
                    echo(' style="background-color:#FDEBF3!important;"');
                } else {
                    echo(' style="background-color:#F5F1E4!important;"');
                }
                echo(">" . 
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
        echo("<li><a href='./?id=$show[tvdbid]'" . ($show['status'] == 'Downloaded' ? ' style="background-color:#E2FFD8!important;"' : ' style="background-color:#FDEBF3!important;"') . ">");
        echo(date("Y-m-d @ h:i",strtotime($show['date'])) . " " .
            $show['show_name'] . " - " . $show['season'] . "x" . $show['episode'] . "</a></li>");
    }
    echo("</ul></div>");
}

?>
