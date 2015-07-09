<?php

class breadcrumb {

    private $_breadcrumb = array();
    private $separator = '  /  ';

    function __construct() {
        
    }

    function add($name, $href = '') {

        if (!$name) {
            return;
        } else {
            $this->_breadcrumb[] = array('title' => $name, 'href' => $href);
        }
    }

    function get() {

        if ($this->_breadcrumb) {
            
            $breadcrumbArr = array_keys($this->_breadcrumb);
            
            $output = '';

            foreach ($this->_breadcrumb as $key => $crumb) {

                if (end($breadcrumbArr) == $key) {
                    $output .= '<li class="active">' . $crumb['title'] . '</li>';
                } else {
                    $output .= '<li><a href="' . BASE_PATH . $crumb['href'] . '">' . $crumb['title'] . '</a></li>';
                }
            }

            return $output;
        } else {
            return;
        }
    }

}
