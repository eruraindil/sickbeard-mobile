<?php
namespace SickBeardMobile;

if(isset($sbm)) {
    require_once('global.php');
}

function getSettingsAsForm() {
    global $sbm;
    //form to input url and api num of sickbeard installation. On form submit, save the settings.json file and reload index
    echo("<form method='post'>
        <label for='url'>SickBeard URL</label>
        <input type='text' id='url' name='url' value='" . (isset($sbm) ? $sbm->getUrl() : '') . "' data-clear-btn='true'>
        
        <label for='url'>SickBeard API Key</label>
        <input type='text' id='key' name='key' value='" . (isset($sbm) ? $sbm->getKey() : '') . "' data-clear-btn='true'>
        
        <button type='submit'>OK</button>
    </form>");
}

function getFormSubmit() {
    if(isset($_POST['url']) && isset($_POST['key'])) {
        $data = array();
        $data["SB_URL"] = $_POST['url'];
        $data["SB_KEY"] = $_POST['key'];
        
        $json = json_encode($data);
        file_put_contents('settings.json',$json,LOCK_EX);
        
        if(file_exists('settings.json')) {
            header("Location: ./");
        } else {
            header("Location: error.php?2");
        }
    }
}

?>
