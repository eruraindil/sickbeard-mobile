<?php
namespace SickBeardMobile;

require_once('dataStructures.php');
require_once('settings.php');

$sbm = new app($SB_KEY,$SB_URL);

//echo $sbm->dump();


function rprint($a) {
    echo "<pre>" . print_r($a,1) . "</pre>";
}
?>