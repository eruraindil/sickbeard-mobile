            </div><!-- /content -->
            <div data-role="footer" data-id="foo1" data-position="fixed" data-theme="b">
                <div data-role="navbar">
                    <ul>
                         <li><a href="coming" data-icon="star"<?php ($this->name == "coming" ? ' class="ui-btn-active"' : '')?>>Coming</a></li>
                         <li><a href="history" data-icon="info"<?php ($this->name == "history" ? ' class="ui-btn-active"' : '')?>>History</a></li>
                         <li><a href="log" data-icon="alert"<?php ($this->name == "log" ? ' class="ui-btn-active"' : '')?>>Log</a></li>
                    </ul>
                </div><!-- /navbar -->
            </div><!-- /footer -->
        </div><!-- /page -->
        
        <script src="js/helper.js"></script>
        <script src="js/main.js"></script>
        
        <!-- Google Analytics: change UA-XXXXX-X to be your site\'s ID. -->
        <script>
            var _gaq=[["_setAccount","UA-XXXXX-X"],["_trackPageview"]];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.async=1;
            g.src='//www.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,"script"));
        </script>
    </body>
</html>
