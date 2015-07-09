<?php

class form {

    private $_currentItem = NULL;
    private $_postData = array();
    private $_val = array();
    private $_error = array();

    public function __construct() {
        $this->_val = new val();
    }

    public function post($field) {
        $this->_postData[$field] = $_POST[$field];
        $this->_currentItem = $field;

        return $this;
    }

    public function fetch($fieldName = FALSE) {

        if ($fieldName) {
            if (isset($this->_postData[$fieldName])) {
                return $this->_postData[$fieldName];
            } else {
                return FALSE;
            }
        } else {
            return $this->_postData;
        }
    }

    public function val($name, $type, $arg = NULL, $arg2 = NULL) {

        if ($arg == NULL && $arg2 == NULL) {
            $error = $this->_val->{$type}($name, $this->_postData[$this->_currentItem]);
        } elseif ($arg != NULL && $arg2 == NULL) {
            $error = $this->_val->{$type}($name, $this->_postData[$this->_currentItem], $arg);
        } elseif ($arg != NULL && $arg2 != NULL) {
            $error = $this->_val->{$type}($name, $this->_postData[$this->_currentItem], $arg, $arg2);
        }

        if ($error) {
            $this->_error[$this->_currentItem] = $error;
        }

        return $this;
    }

    public function submit() {
        if (empty($this->_error)) {
            return TRUE;
        } else {

            $e = "";
            foreach ($this->_error as $value) {
                $e .= "<div>$value</div>";
            }
            throw new Exception($e);
        }
    }

}
