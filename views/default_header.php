<?php
$userData = $this->_userData;
$page = explode('/', $_SERVER['REQUEST_URI']);
array_shift($page);

$page = $page[0];
$active = " class='active'";
?>
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
        <!-- Font Awesome core CSS -->
        <link rel="stylesheet" type="text/css" href="<?php echo PLUGINS_PATH; ?>font-awesome/css/font-awesome.css" />


        <link rel="stylesheet" type="text/css" href="<?php echo BASE_PATH; ?>public/css/default_styles.css" />
        <script type="text/javascript" src="<?php echo BASE_PATH; ?>public/js/jquery.js"></script>
        <script type="text/javascript" src="<?php echo BASE_PATH; ?>public/js/custom.js"></script>

        <!-- Bootstrap core JavaScript -->
        <script type="text/javascript" src="<?php echo PLUGINS_PATH; ?>bootstrap/js/bootstrap.js"></script>

        <?php
        if (isset($this->js)) {

            foreach ($this->js as $js) {
                echo '<script type="text/javascript" src="' . BASE_PATH . 'views/' . $js . '"></script>';
            }
        }
        ?>

    </head>
    <body>

        <div class="navbar navbar-default navbar-static-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a  class="navbar-brand" href="<?php echo BASE_PATH; ?>" title="<?php echo SITE_TITLE; ?>">
                        <img src="<?php echo IMAGES_PATH; ?>header_logo.png"></img>
                    </a>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li <?php echo ($page == 'home') ? $active : NULL; ?>><a href="<?php echo BASE_PATH; ?>home">OVERVIEW<span class="nav-description hidden-sm"></br>where all it begins</span></a></li>
<!--                        <li><a href="<?php echo BASE_PATH; ?>plan">THE PLAN<span class="nav-description hidden-sm"></br>income opportunity</span></a></li>
                        <li><a href="#">RESELLER<span class="nav-description hidden-sm"></br>dealer & partner</span></a></li>
                        <li><a href="#">PRAISE<span class="nav-description hidden-sm"></br>member's kind words</span></a></li>-->
                        <li <?php echo ($page == 'contact') ? $active : NULL; ?>><a href="<?php echo BASE_PATH; ?>contact">CONTACT<span class="nav-description hidden-sm"></br>get in touch with us</span></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="header-link">
            <div class="container text-right">
                <ul>
                    <?php
                    if (empty($userData)) {
                        ?>
                        <li>
                            <a href="<?php echo BASE_PATH; ?>login">Member Login</a>
                        </li>
                        <?php
                    } else {
                        ?>
                        <li>
                            <span>Welcome <?php echo $userData['username']; ?>!</span>
                        </li>
                        <li>
                            <a href="<?php echo BASE_PATH; ?>dashboard">Dashboard</a>
                        </li>
                        <li>
                            <a href="<?php echo BASE_PATH; ?>dashboard/logout">Logout</a>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
        <div class="content">
            <div class="container">
                <div class="row">
                    <?php if (isset($this->breadcrumbs)) { ?>
                        <ol class="breadcrumb small">
                            <li><a href="<?php echo BASE_PATH; ?>"><span class="glyphicon glyphicon-home"></span></a></li>
                                    <?php echo $this->breadcrumbs; ?>
                        </ol>
                    <?php } ?>
                </div>
            </div>
