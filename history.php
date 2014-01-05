<?php
namespace SickBeardMobile;

require_once('global.php');

$history = new page('history');
$history->getHeader();
getHistory(10);
$history->getFooter();

?>
