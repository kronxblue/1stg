<?php

class controller {

    public $view;
    public $breadcrumb;
    public $_userData = NULL;
    public $_userAccType = NULL;
    public $_userProfileImages = NULL;
    public $_availableCommission = NULL;
    
//    BADGE
    public $_accPaymentBadge = NULL;
    public $_withdrawalBadge = NULL;
//    public $_messageBadge = NULL;

    function __construct() {
        session::init();

        $this->breadcrumb = new breadcrumb();
        $this->view = new view();

        $this->_userProfileImages = IMAGES_PATH . "user-default.png";

        if (session::exist(AGENT_SESSION_NAME) and session::exist(AGENT_LOGIN_SESSION)) {
            $agent_id = session::get(AGENT_SESSION_NAME);

            $userData = new user;

//            USERDATA
            $this->_userData = $userData->getUserData('agent_id', $agent_id);

            $user = $this->_userData;

//            USER ACC. TYPE
            $userAccType = user::getAccType($user['acc_type']);
            $this->_userAccType = $userAccType['label'];

//            PROFILE IMAGE
            $profileImageExist = user::checkExist("user_images", "agent_id = '$agent_id' AND profile = '1'");
            if ($profileImageExist) {
                $image = user::getUserImages($agent_id, TRUE);
                $this->_userProfileImages = IMAGES_PATH . "users/" . $image['filename'];
            }

//            AVAILABLE COMMISSION
            $this->_availableCommission = user::getAvailableComm($agent_id);
            
//            BADGE
            $countAccPaymentBadge = user::countBadge("user_payment", "status = '0'");
            $this->_accPaymentBadge = ($countAccPaymentBadge > 0) ? $countAccPaymentBadge : "";
            $countWithdrawalBadge = user::countBadge("user_withdrawal", "status = '0' OR status = '1'");
            $this->_withdrawalBadge = ($countWithdrawalBadge > 0) ? $countWithdrawalBadge : "";
//            $countMessageBadge = user::countBadge("user_messages", "agent_id = '$agent_id' AND status = '0'");
//            $this->_messageBadge = ($countMessageBadge > 0) ? $countMessageBadge : "";
        }

        $this->view->_userData = $this->_userData;
        $this->view->_userAccType = $this->_userAccType;
        $this->view->_userProfileImages = $this->_userProfileImages;
        $this->view->_availableCommission = $this->_availableCommission;
        
//        BADGE
        $this->view->_accPaymentBadge = $this->_accPaymentBadge;
        $this->view->_withdrawalBadge = $this->_withdrawalBadge;
//        $this->view->_messageBadge = $this->_messageBadge;
    }

    public function loadModel($name) {
        $file = 'models/' . $name . '_model.php';

        if (file_exists($file)) {
            require $file;
            $modelName = $name . '_model';
            $this->model = new $modelName();
        }
    }

}
