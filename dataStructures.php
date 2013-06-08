<?php
namespace SickBeardMobile;

class app {

    private $key;
    private $url;

    function __construct($key,$url) {
        $this->key = $key;
        $this->url = $url;
    }

    public function getKey() {
        return $this->key;
    }
    public function getUrl() {
        return $this->url;
    }

    public function getApiUrl() {
        return $this->url . "//api/" . $this->key . "/?cmd=";
    }

    public function dump() {
        return "<pre>" . print_r($this,1) . "</pre>";
    }

}

?>