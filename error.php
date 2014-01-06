<?php
namespace SickBeardMobile;

require_once('global.php');

$setup = new page('error');
$setup->getHeader();
if(isset($_GET['1'])) {
    echo("Cannot communicate with <a href='" . $sbm->getURL() . "'>" . $sbm->getURL() . "</a>.");
}
$setup->getFooter("no-menu");

?>
