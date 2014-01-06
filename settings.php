<?php
namespace SickBeardMobile;

require_once('global.php');

getFormSubmit();

$settings = new page('settings');
$settings->getHeader();
getSettingsAsForm();
$settings->getFooter();

?>
