<?php
namespace SickBeardMobile;

require_once('global.php');

$setup = new page('error');
if(isset($_GET['1'])) {
    $setup->getHeader("offline");
} else {
    $setup->getHeader();
}
if(isset($_GET['1'])) {
    echo("Cannot communicate with <a href='" . $sbm->getURL() . "'>" . $sbm->getURL() . "</a>. Is the network down?");
}
if(isset($_GET['2'])) {
    echo("Cannot save file settings.json. Is the file writeable by the webserver?");
}
if(isset($_GET['1'])) {
    $setup->getFooter("offline");
} else {
    $setup->getFooter();
}
?>
