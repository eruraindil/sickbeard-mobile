<?php
namespace SickBeardMobile;

require_once('settings.php');
$sbm = new app($SB_KEY,$SB_URL);
require_once('parseShows.php');


//echo $sbm->dump();


function rprint($a) {
    echo "<pre>" . print_r($a,1) . "</pre>";
}
?>