<?php
namespace SickBeardMobile;

class app {

    private $key;
    private $url;
    private $path;

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
        return $this->url . "/api/" . $this->key . "/?cmd=";
    }

    public function dump() {
        return "<pre>" . print_r($this,1) . "</pre>";
    }

}

class page {
    private $name;

    function __construct($name) {
        $this->name = $name;
    }

    public function getHeader($offline = NULL) {
        include('includes/header.php');
    }

    public function getFooter($offline = NULL) {
        include('includes/footer.php');
    }
}

?>
