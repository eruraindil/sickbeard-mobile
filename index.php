<?php
namespace SickBeardMobile;

require_once('global.php');

if(isset($_GET['id'])) {
    sleep(2);
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
