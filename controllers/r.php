<?php

class r extends controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        redirect::to(BASE_PATH, TRUE);
    }

    function s($sponsor = NULL) {
        if ($sponsor == NULL) {
            redirect::to(BASE_PATH, TRUE);
        } else {
            $this->model->s($sponsor);
        }
    }

}
