<?php
namespace SickBeardMobile;

require_once('global.php');

getSettingsFormSubmit();

$settings = new page('settings');
$settings->getHeader();
getSettingsAsForm();
$settings->getFooter();

?>
