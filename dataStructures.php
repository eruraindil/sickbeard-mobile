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

    public function getHeader() {
        echo('<div data-role="page" id="' . $this->name . '">
            <div data-role="header" data-id="header" data-position="fixed">' . PHP_EOL);
        if($this->name == "home") {
echo('                <a data-iconpos="notext" href="#addshow" data-icon="plus" title="Add Show">Add Show</a>' . PHP_EOL);
        } else {
echo('                <a data-iconpos="notext" href="#home" data-icon="home" title="Go Home">Go Home</a>' . PHP_EOL);
        }
echo('                <h1>SickBeard Mobile</h1>
                <a href="#settings" data-iconpos="notext" data-icon="gear" title="Settings">Settings</a>
            </div><!-- /header -->
            <div data-role="content">' . PHP_EOL);
    }

    public function getFooter() {
echo('            </div><!-- /content -->
                <div data-role="footer" data-id="foo1" data-position="fixed" data-theme="b">
                    <div data-role="navbar">
                        <ul>' . PHP_EOL);
echo('                             <li><a href="#coming" data-icon="star"' . ($this->name == "coming" ? ' class="ui-btn-active"' : '') . '>Coming</a></li>' . PHP_EOL);
echo('                             <li><a href="#history" data-icon="info"' . ($this->name == "history" ? ' class="ui-btn-active"' : '') . '>History</a></li>' . PHP_EOL);
echo('                             <li><a href="#log" data-icon="alert"' . ($this->name == "log" ? ' class="ui-btn-active"' : '') . '>Log</a></li>' . PHP_EOL);
echo('                        </ul>
                </div><!-- /navbar -->
            </div><!-- /footer -->
        </div><!-- /page -->' . PHP_EOL);
    }
}

?>
