<?php
namespace SickBeardMobile;

require_once('global.php');

$history = new page('history');
$history->getHeader();
getHistoryAsList(20);
$history->getFooter();

?>
