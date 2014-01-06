<?php
namespace SickBeardMobile;

require_once('dataStructures.php');
require_once('parseSettings.php');

getFormSubmit();

$setup = new page('settings');
$setup->getHeader();
getSettingsAsForm();
$setup->getFooter("no-menu");

?>
