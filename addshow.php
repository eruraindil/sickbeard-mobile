<?php
namespace SickBeardMobile;

require_once('global.php');

getAddShowIdSubmit();

$addshow = new page('addshow');
$addshow->getHeader();
getAddShowForm();
getAddShowFormSubmit();
$addshow->getFooter();

?>
