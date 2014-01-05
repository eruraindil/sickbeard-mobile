<?php
namespace SickBeardMobile;

require_once('global.php');

if(isset($_GET['show'])) {
    $show = new page('show');
    $show->getHeader();
    getShowAsPage($_GET['show']);
    $show->getFooter();
} else {
    $home = new page('home');
    $home->getHeader();
    getShowsAsList();
    $home->getFooter();
}

?>
