<?php
namespace SickBeardMobile;

require_once('dataStructures.php');

$setup = new page('setup');
$setup->getHeader();
echo "form to input url and api num of sickbeard installation. On form submit, save the settings.json file and reload index";
$setup->getFooter("no-menu");

?>
