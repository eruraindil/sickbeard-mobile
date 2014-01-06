<?php
namespace SickBeardMobile;

require_once('global.php');

$addshow = new page('addshow');
$addshow->getHeader();
getHistory(10);
$addshow->getFooter();

?>
