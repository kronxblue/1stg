<?php

class val {

    public function __construct() {
        
    }

    public function minlength($name, $data, $arg = NULL) {

        if ($data == NULL) {
            return "<strong>$name</strong> cannot be empty.";
        } elseif (strlen($data) < $arg) {
            return "<strong>$name</strong> not meet requirement (Minimum $arg character).";
        }
    }

    public function maxlength($name, $data, $arg) {

        if (strlen($data) > $arg) {
            return "<strong>$name</strong> not meet requirement (Maximum $arg character).";
        }
    }

    public function digit($name, $data) {
        if ($data != NULL) {
            if (!ctype_digit($data)) {
                return "<strong>$name</strong> not meet requirement (only integer).";
            }
        } else {
            return $this->minlength($name, $data);
        }
    }

    public function match($name, $data, $matchdata) {
        if ($data != NULL) {
            if ($data != $matchdata) {
                return "<b>$name</b> not match.";
            }
        } else {
            return $this->minlength($name, '');
        }
    }

    public function email($name, $data) {
        if ($data != NULL) {
            if (!filter_var($data, FILTER_VALIDATE_EMAIL)) {
                return "<b>$data</b> not valid email address.";
            }
        } else {
            return $this->minlength($name, '');
        }
    }

    public function nospace($name, $data) {
        if ($data != NULL) {
            if (preg_match('/\s/', $data)) {
                return "<b>$name</b> cannot contain any space.";
            }
        } else {
            return $this->minlength($name, '');
        }
    }

    public function __call($name, $arguments) {
        throw new Exception("$name does not exist inside of : " . __CLASS__);
    }

}
