<?php
namespace SickBeardMobile;

require_once('settings.php');
require_once('dataStructures.php');
$sbm = new app($SB_KEY,$SB_URL);
require_once('parseShows.php');


//echo $sbm->dump();


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
    imagejpeg( $img_base, "thumbs/". $id . "_$rs_width" . "x$rs_height" . ".jpg", 80 );
}
?>
