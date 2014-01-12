<?php
namespace SickBeardMobile;
session_start();
require_once('global.php');

if(isset($_GET['id'])) {
    $show = new page('show');
    $show->getHeader();
    getShowAsPage($_GET['id']);
    $show->getFooter();
} else {
    $home = new page('home');
    $home->getHeader();
    getShowsAsList();
    $home->getFooter();
}

?>
