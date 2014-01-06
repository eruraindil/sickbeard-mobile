<?php
namespace SickBeardMobile;

if(isset($sbm)) {
    require_once('global.php');
}

function getSettingsAsForm() {
    global $sbm;
    //form to input url and api num of sickbeard installation. On form submit, save the settings.json file and reload index
    echo("<form method='post' data-ajax='false'>
        <label for='url'>SickBeard URL</label>
        <input type='text' id='url' name='url' placeholder='http://example.com' value='" . (isset($sbm) ? $sbm->getUrl() : '') . "' data-clear-btn='true'>
        
        <label for='url'>SickBeard API Key</label>
        <input type='text' id='key' name='key' placeholder='00000000000000000000000000000000' value='" . (isset($sbm) ? $sbm->getKey() : '') . "' data-clear-btn='true'>
        
        <button type='submit'>OK</button>
        <a href='./' class='ui-btn'>Cancel</a>
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
            header("Location: redirect?to=./");
        } else {
            header("Location: redirect?to=error?2");
        }
    }
}

?>
