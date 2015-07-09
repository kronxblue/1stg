<?php

class view {
    
    public $_userData = NULL;
    public $_userAccType = NULL;
    public $_userProfileImages = NULL;
            
    function __construct() {
        
    }

    public function render($name, $layout = 'default', $rander = true) {

        if ($rander) {
            require 'views/' . $layout . '_header.php';
            require 'views/' . $name . '.php';
            require 'views/' . $layout . '_footer.php';
        } else {
            require 'views/' . $name . '.php';
        }
    }

}
