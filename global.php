<?php
namespace SickBeardMobile;

if(!is_setup()) { //SBM is not set up, enter some basic info!
    header("Location: setup");
}
$json = file_get_contents('settings.json', 0, null, null);
$setup = json_decode($json,true);

/* GLOBAL VARIABLES */

$SB_LIST_THUMB_W = 100;
$SB_LIST_THUMB_H = 147;

$SB_PAGE_THUMB_W = 300;
$SB_PAGE_THUMB_H = 441;

require_once('dataStructures.php');
$sbm = new app($setup['SB_KEY'],$setup['SB_URL']);
require_once('parseShows.php');
require_once('parseSettings.php');

/* HELPER FUNCTIONS */

function rprint($a) {
    echo "<pre>" . print_r($a,1) . "</pre>";
}

// via https://stackoverflow.com/a/20821250
function Img_Resize($img,$id,$rs_width,$rs_height) {
    $img = imagecreatefromjpeg("data:image/jpeg;base64," . base64_encode($img));
    $width = 680;
    $height = 1000;

    $img_base = imagecreatetruecolor($rs_width, $rs_height);
    imagecopyresized($img_base, $img, 0, 0, 0, 0, $rs_width, $rs_height, $width, $height);

    /*imagejpeg($img_base, "thumbs/$id.jpg", 80 );
    imagedestroy( $img_base );
    
    return "thumbs/$id.jpg";
    */

    return imagejpeg( $img_base, "cache/thumbs/". $id . "_$rs_width" . "x$rs_height" . ".jpg", 80 );
}

function is_setup() {
    if(file_exists('settings.json')) {
        return true;
    } else {
        return false;
    }
}
?>
