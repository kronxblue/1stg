<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <title>1STG : We advertise advertisement...</title>

        <!--JQUERY UI--> 
        <link href="<?php echo PLUGINS_PATH; ?>jquery-ui/jquery-ui.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="<?php echo BASE_PATH; ?>public/js/jquery.js"></script>
        <script type="text/javascript" src="<?php echo PLUGINS_PATH; ?>jquery-ui/jquery-ui.js"></script>

        <!--Bootstrap-->
        <link rel="stylesheet" type="text/css" href="<?php echo PLUGINS_PATH; ?>bootstrap/css/bootstrap-theme.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo PLUGINS_PATH; ?>bootstrap/css/bootstrap.css" />
        <script type="text/javascript" src="<?php echo PLUGINS_PATH; ?>bootstrap/js/bootstrap.js"></script>

        <!--Font Awesome-->
        <link rel="stylesheet" type="text/css" href="<?php echo PLUGINS_PATH; ?>font-awesome/css/font-awesome.css" />

        <link rel="stylesheet" type="text/css" href="<?php echo BASE_PATH; ?>public/css/index.css" />
        <script type="text/javascript" src="<?php echo BASE_PATH; ?>public/js/custom.js"></script>

        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="icon" href="/favicon.ico" type="image/x-icon" />

        <?php
        if (isset($this->js)) {

            foreach ($this->js as $js) {
                echo '<script type="text/javascript" src="' . BASE_PATH . 'views/' . $js . '"></script>';
            }
        }
        ?>
    </head>
    <body>
        <div class="wrapper-video">
            <video id="bg-video" loop="loop" autoplay="true" autobuffer preload="auto">
                <source src="<?php echo BASE_PATH; ?>public/bg-video.mp4" type="video/mp4" />
                <source src="<?php echo BASE_PATH; ?>public/bg-video.ogv" type="video/ogg" />
                <source src="<?php echo BASE_PATH; ?>public/bg-video.webm" type="video/webm" />
                Your browser does not support the <code>video</code> element.
            </video>
        </div>
        <div class="content-index">
            <div class="container-fluid">
                <div class="col-xs-12 text-center">
                    <a href="<?php echo BASE_PATH; ?>" class="logo-index">
                        <img src="public/images/1stg-logo.png" />
                    </a>
                </div>
            </div>
            <div class="container text-muted">
                <div class="text-center col-xs-12">
                    <strong>WELCOME TO<br/>1STG ENTREPRENEURSHIP PROGRAM</strong>
                </div>
            </div>
            <div class="country-index">
                <div class="container">
                    <div class="col-xs-12 text-center">
                        <a class="btn btn-primary btn-lg" href="<?php echo BASE_PATH; ?>home">
                            ENTER
                        </a>
                    </div>
                </div>
            </div>

            <div class="footer-index">
                <div class="container-fluid">
                    <div class="center-block text-center text-muted small">
                        <?php echo SITE_COPYRIGHT; ?>
                    </div>
                </div>
            </div>
        </div>
        <div id="loading-ov">
            <div class="ov-content">
                <div class="ov-body">
                    <span class="loading-text col-xs-12">
                        Loading...
                    </span>
                    <span class="loading-bar col-xs-12 text-center">
                        <div class="fa fa-spinner fa-spin fa-3x"></div>
                    </span>
                </div>
            </div>
        </div>

    </body>
</html>