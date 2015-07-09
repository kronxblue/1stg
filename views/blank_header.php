<?php ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>

        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="description" content="<?php echo DESCRIPTION; ?>" />
        <meta name="author" content="<?php echo AUTHOR; ?>" />
        <meta name="robots" content="index,follow" />
        <meta name="copyright" content="<?php echo SITE_COPYRIGHT; ?>" />
        <meta name="language" content="EN" />
        <meta name="creationdate" content="October 1 2014" />
        <meta name="distribution" content="Global" />
        <meta name="rating" content="General" />

        <title><?php echo SITE_TITLE; ?></title>

        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" type="text/css" href="<?php echo PLUGINS_PATH; ?>bootstrap/css/bootstrap.css" />
        <!-- Bootstrap Datepicker core CSS -->
        <link rel="stylesheet" type="text/css" href="<?php echo PLUGINS_PATH; ?>datepicker/css/datepicker.css" />
        <!-- Font Awesome core CSS -->
        <link rel="stylesheet" type="text/css" href="<?php echo PLUGINS_PATH; ?>font-awesome/css/font-awesome.css" />
        <!-- jqueryUI CSS -->
        <link rel="stylesheet" type="text/css" href="<?php echo PLUGINS_PATH; ?>jquery-ui/jquery-ui.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo PLUGINS_PATH; ?>jquery-ui/jquery-ui.structure.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo PLUGINS_PATH; ?>jquery-ui/jquery-ui.theme.css" />


        <link rel="stylesheet" type="text/css" href="<?php echo BASE_PATH; ?>public/css/backoffice_styles.css" />
        <script type="text/javascript" src="<?php echo BASE_PATH; ?>public/js/jquery.js"></script>
        <script type="text/javascript" src="<?php echo BASE_PATH; ?>public/js/custom.js"></script>
        <script type="text/javascript" src="<?php echo BASE_PATH; ?>public/js/backoffice.js"></script>

        <!-- Bootstrap core JavaScript -->
        <script type="text/javascript" src="<?php echo PLUGINS_PATH; ?>bootstrap/js/bootstrap.js"></script>
        <!-- Bootstrap Datepicker core JavaScript -->
        <script type="text/javascript" src="<?php echo PLUGINS_PATH; ?>datepicker/js/datepicker.js"></script>
        <!-- jqueryUI JavaScript -->
        <script type="text/javascript" src="<?php echo PLUGINS_PATH; ?>jquery-ui/jquery-ui.js"></script>

<?php
if (isset($this->js)) {

    foreach ($this->js as $js) {
        echo '<script type="text/javascript" src="' . BASE_PATH . 'views/' . $js . '"></script>';
    }
}
?>

    </head>
    <body>
        <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header col-xs-12">
                    <a  class="navbar-brand rfalse"  href="<?php echo BASE_PATH; ?>">
                        <img src="<?php echo IMAGES_PATH; ?>1stg-logo.png" />
                    </a>
                </div>
            </div>
        </div>

        <div class="content-wrap-blank">
            <div class="content">
                <div class="row">
                    <div class="col-xs-12">

