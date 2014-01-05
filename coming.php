<?php
namespace SickBeardMobile;

require_once('global.php');

$coming = new page('coming');
$coming->getHeader();
getComingShows(10);
$coming->getFooter();

?>
