<?php

class bootstrap {

    private $_url = NULL;
    private $_controller = NULL;

    public function _init() {
        // for use in development
        error_reporting(E_ALL);

        $siteStatus = $this->_site_status();

        switch ($siteStatus['param']) {
            case 0:
                //MAINTAINANCE
                break;
            case 1:
                //LIVE
                $this->_run();
                break;
            case 2:
                //UPDATE
                break;
            default:
                //DEFAULT
                $this->_error();
        }
    }

    /**
     * Check Site Status
     * 
     * @return Int
     */
    private function _site_status() {
        $db = new database(DBTYPE, DBHOST, DBNAME, DBUSER, DBPASS);
        $data = $db->select("site_settings", "*", "name = 'site_status'", "fetch");

        return $data;
    }

    /**
     * Construct the Bootstrap
     * 
     * @return boolean|string
     */
    private function _run() {

        $this->_getURL();


        if (empty($this->_url[0])) {
            $this->_loadDefaultController();
            return false;
        } else {
            $this->_loadExistingController();
            
        }
    }

    /**
     * Fetch $_GET['url']
     */
    private function _getURL() {
        $url = isset($_GET['url']) ? $_GET['url'] : NULL;
        $url = rtrim($url, '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $this->_url = explode('/', $url);
    }

    /**
     * Load if no $_GET['url'] parameter passed
     */
    private function _loadDefaultController() {
        require CONTROLLERS_PATH . 'index.php';
        $this->_controller = new index();
        $this->_controller->loadModel('index');
        $this->_controller->index();
    }

    /**
     * Load if there is $_GET['url'] parameter passed
     * 
     * @return boolean|string
     */
    private function _loadExistingController() {
        $file = CONTROLLERS_PATH . $this->_url[0] . '.php';

        if (file_exists($file)) {
            require $file;
            $this->_controller = new $this->_url[0]();
            $this->_controller->loadModel($this->_url[0]);
            $this->_callControllerMethod();
        } else {
            $this->_error();
            return FALSE;
        }
    }

    /**
     * If a method is passed in the $_GET['url']
     */
    private function _callControllerMethod() {

//        http://domainname/controller/method/(param1)/(param2)/(param3)
//        url[0] = Controller
//        url[1] = Method
//        url[2] = Param1 (Optional)
//        url[3] = Param2 (Optional)
//        url[4] = Param3 (Optional)

        $length = count($this->_url);

        if ($length > 1) {
            if (!method_exists($this->_controller, $this->_url[1])) {
                $this->_error();
                return FALSE;
            }
        }

        switch ($length) {
            case 5:
//                          Controller->Method(Param1,Param2,Param3)
                $this->_controller->{$this->_url[1]}($this->_url[2], $this->_url[3], $this->_url[4]);
                break;
            case 4:
//                          Controller->Method(Param1, Param2)
                $this->_controller->{$this->_url[1]}($this->_url[2], $this->_url[3]);
                break;
            case 3:
//                          Controller->Method(Param1)
                $this->_controller->{$this->_url[1]}($this->_url[2]);
                break;
            case 2:
//                          Controller->Method
                $this->_controller->{$this->_url[1]}();
                break;
            default:
//                          Controller->index()
                $this->_controller->index();
                break;
        }
    }

    /**
     * Display an error page if nothing exist
     * 
     * @return boolean
     */
    private function _error() {
        require CONTROLLERS_PATH . 'error.php';
        $this->_controller = new error();
        $this->_controller->index();
        return FALSE;
    }

}
