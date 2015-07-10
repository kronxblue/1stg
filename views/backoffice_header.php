<?php
$availableComm = $this->_availableCommission;
$userData = $this->_userData;
$userAccType = $this->_userAccType;
$profileImage = $this->_userProfileImages;

//BADGE
$accPaymentBadge = $this->_accPaymentBadge;
$withdrawalBadge = $this->_withdrawalBadge;
//$messageBadge = $this->_messageBadge;

$page = explode('/', $_SERVER['REQUEST_URI']);
array_shift($page);

$page = $page[0];
$active = "active";
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
        <!-- Bootstrap Datepicker core CSS -->
        <link rel="stylesheet" type="text/css" href="<?php echo PLUGINS_PATH; ?>datepicker/css/datepicker.css" />
        <!-- Font Awesome core CSS -->
        <link rel="stylesheet" type="text/css" href="<?php echo PLUGINS_PATH; ?>font-awesome/css/font-awesome.css" />
        <!-- jqueryUI CSS -->
        <link rel="stylesheet" type="text/css" href="<?php echo PLUGINS_PATH; ?>jquery-ui/jquery-ui.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo PLUGINS_PATH; ?>jquery-ui/jquery-ui.structure.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo PLUGINS_PATH; ?>jquery-ui/jquery-ui.theme.css" />
	<!-- Morphext -->
	<link rel="stylesheet" type="text/css" href="<?php echo PLUGINS_PATH; ?>morphext/morphext.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo PLUGINS_PATH; ?>morphext/animate.css" />


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
	<!-- Morphext -->
        <script type="text/javascript" src="<?php echo PLUGINS_PATH; ?>morphext/morphext.js"></script>

        <?php
        if (isset($this->js)) {

            foreach ($this->js as $js) {
                echo '<script type="text/javascript" src="' . BASE_PATH . 'views/' . $js . '"></script>';
            }
        }
        ?>

    </head>
    <body class="flex-sidebar">
        <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header col-xs-12">
                    <a  class="navbar-brand"  href="<?php echo BASE_PATH; ?>">
                        <img src="<?php echo IMAGES_PATH; ?>1stg-logo.png" />
                    </a>
                    <!--NAVIGATION-->
                    <!--                    <ul class="nav navbar-nav nav-pills pull-left">
                                            <li class="active"><a href="#">Dashboard</a></li>
                                        </ul>-->
                    <div class="navbar-menu clearfix">
                        <ul class="nav navbar-nav nav-pills pull-right">
                            <!--NOTIFICATION-->
                            <!--                            <li class="dropdown">
                                                            <a class="dropdown-toggle" data-toggle="dropdown" title="Notifications" href="#"><i class="fa fa-exclamation-circle fa-lg fa-fw"></i><span class="badge">2</span></a>
                                                            <div class="dropdown-menu area dropdown-menu-right" role="menu">
                                                                <div class="row">
                                                                    <div class="col-xs-12">
                                                                        <span class="dropdown-header col-xs-12">Notifications</span>
                                                                        <div class="dropdown-body col-xs-12">
                                                                            <p class="text-center">You have no new notifications.</p>
                                                                        </div>
                                                                        <span class="dropdown-footer col-xs-12 text-center shadow"><a href="<?php echo BASE_PATH; ?>notifications">See All</a></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>-->
                            <!--MESSAGE-->
<!--                            <li class="dropdown">
                                <a id="messages" class="dropdown-toggle" data-toggle="dropdown" title="Messages" href="<?php echo BASE_PATH; ?>messages/getMessagesList"><i class="fa fa-comments fa-lg fa-fw"></i><span class="badge"><?php echo $messageBadge; ?></span></a>
                                <div class="dropdown-menu area dropdown-menu-right" role="menu">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <span class="dropdown-header col-xs-12">Messages</span>
                                            <span class="dropdown-loading small col-xs-12 hidden">Checking new messages...<i class="fa fa-spinner fa-spin fa-fw fa-lg"></i></span>
                                            <div class="dropdown-body col-xs-12">
                                                <div class="col-xs-12" >
                                                    <a class="row bg-warning" href="#">
                                                        <div class="row">
                                                            <div class="col-xs-2">
                                                                <img class="img-thumbnail pull-left" src="<?php echo IMAGES_PATH; ?>user-default.png" />
                                                            </div>
                                                            <div class="col-xs-10">
                                                                <div class="message-title">aloongjerr</div>
                                                                <div class="message-desc">Thanx!</div>
                                                                <div class="message-date small">Oct 27</div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>

                                            </div>
                                            <span class="dropdown-footer col-xs-12 text-center shadow"><a href="<?php echo BASE_PATH; ?>messages">See All</a></span>
                                        </div>
                                    </div>
                                </div>
                            </li>-->
                            <!--PROFILE-->
                            <li class="dropdown">
                                <a  class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    <!--                                    <div class="profile">-->
                                                                            <!--<span class="user-details">-->
                                    <i class="fa fa-sliders fa-lg fa-fw"></i>
                                    <b class="fa fa-caret-down"></b>
                                    <!--</span>-->

                                    <!--</div>-->

                                </a>
                                <div class="dropdown-menu menu dropdown-menu-right" role="menu">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <!--<span class="dropdown-header col-xs-12">Messages</span>-->
                                            <div class="dropdown-body col-xs-12">
<!--                                                <a href="#" class="divider rfalse"></a>
                                                <a class='unavailable-link' href="#"><i class="fa fa-camera"></i>Upload Your Photo</a>
                                                <a href="#" class="divider rfalse"></a>-->
                                                <!--<a class='unavailable-link' href="#"><i class="fa fa-cog"></i>Settings</a>-->
                                                <a href="<?php echo BASE_PATH; ?>dashboard/logout"><i class="fa fa-power-off"></i>Logout</a>
                                            </div>
                                            <!--<span class="dropdown-footer col-xs-12 text-center shadow"><a href="<?php echo BASE_PATH; ?>notification">See All</a></span>-->
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-wrap">
            <a href="#" class="sidemenu-toggle">
                <span class="pull-left">Show/Hide</span><span class="pull-right">Menu &nbsp;&nbsp;<span class="fa fa-navicon fa-lg sidemenu-toggle-icon"></span></span>
            </a>
            <!--SIDEMENU-->
            <div class="sidemenu">
                <div class="profile-details small">
                    <table class="table table-condensed">
                        <tbody>
                            <tr>
                                <td class="profile-pic" width="50px">
                                    <img class="img-thumbnail img-responsive" src="<?php echo $profileImage; ?>" />
                                </td>
                                <td>
                                    <?php echo ucfirst($userData['username']); ?>
                                    <br/>
                                    <?php echo $userAccType; ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="text-center"><b><u>Agent ID</u></b></div>
                                    <div class="text-center text-primary"><?php echo $userData['agent_id']; ?></div>
                                    <div class="text-center"><b><u>Available Payout</u></b></div>
                                    <div class="text-center text-primary">RM<?php echo number_format($availableComm); ?></div>
                                </td>

                            </tr>
                        </tbody>
                    </table>
                </div>
                <ul class="navigation small">
                    <?php
                    $admin = ($userData['acc_type'] == 'admin') ? TRUE : FALSE;

                    if ($admin) {
                        ?>
                        <li class="has-submenu">
                            <a class="submenu-toggle <?php echo ($page == 'management') ? $active : NULL; ?>" href="#" data-parent="management">
                                <i class="fa fa-briefcase fa-fw"></i> Management
                                <b class="fa fa-chevron-down pull-right"></b>
                            </a>

                            <ul class="submenu">
                                <li>
                                    <a href="<?php echo BASE_PATH; ?>management/payment"><i class="fa fa-briefcase fa-fw"></i> Acc. Payment <span class="badge"><?php echo $accPaymentBadge; ?></span></a>
                                </li>
                                <li>
                                    <a href="<?php echo BASE_PATH; ?>management/withdrawal"><i class="fa fa-briefcase fa-fw"></i> Withdrawal <span class="badge"><?php echo $withdrawalBadge; ?></span></a>
                                </li>
                                <li>
                                    <a href="<?php echo BASE_PATH; ?>management/agentList"><i class="fa fa-briefcase fa-fw"></i> Agent List</a>
                                </li>
                                <li>
                                    <a href="<?php echo BASE_PATH; ?>management/agentCommission"><i class="fa fa-briefcase fa-fw"></i> Agent Commission</a>
                                </li>
                                <li>
                                    <a href="<?php echo BASE_PATH; ?>management/supplier"><i class="fa fa-briefcase fa-fw"></i> Supplier List</a>
                                </li>
                            </ul>
                        </li>
                    <?php } ?>
                    <li>
                        <a class="<?php echo ($page == 'dashboard') ? $active : NULL; ?>" href="<?php echo BASE_PATH; ?>dashboard"><i class="fa fa-home fa-fw"></i> Dashboard</a>
                    </li>
                    <li class="has-submenu">
                        <a class="submenu-toggle <?php echo ($page == 'mynetwork') ? $active : NULL; ?>" href="#" data-parent="mynetwork">
                            <i class="fa fa-globe fa-fw"></i> My Network
                            <b class="fa fa-chevron-down pull-right"></b>
                        </a>

                        <ul class="submenu">
                            <li>
                                <a href="<?php echo BASE_PATH; ?>mynetwork"><i class="fa fa-users fa-fw"></i> Summary</a>
                            </li>
                            <li>
                                <a href="<?php echo BASE_PATH; ?>mynetwork/geneology"><i class="fa fa-sitemap fa-fw"></i> Geneology</a>
                            </li>
                        </ul>
                    </li>
                    <li class="has-submenu">
                        <a class="submenu-toggle <?php echo ($page == 'supplier') ? $active : NULL; ?>" href="#" data-parent="supplier">
                            <i class="fa fa-truck fa-fw"></i> Supplier
                            <b class="fa fa-chevron-down pull-right"></b>
                        </a>
                        <ul class="submenu">
                            <li>
                                <a href="<?php echo BASE_PATH; ?>supplier"><i class="fa fa-ticket fa-fw"></i> Supplier List</a>
                            </li>
                            <li>
                                <a href="<?php echo BASE_PATH ?>advertisement"><i class="fa fa-certificate fa-fw"></i> Advertisement</a>
                            </li>
                        </ul>
                    </li>
                    <li class="has-submenu">
                        <a class="submenu-toggle <?php echo ($page == 'comm') ? $active : NULL; ?>" href="#" data-parent="comm">
                            <i class="fa fa-money fa-fw"></i> Commission
                            <b class="fa fa-chevron-down pull-right"></b>
                        </a>
                        <ul class="submenu">
                            <li>
                                <a href="<?php echo BASE_PATH; ?>comm"><i class="fa fa-bar-chart-o fa-fw"></i> Summary</a>
                            </li>
                            <li>
                                <a href="<?php echo BASE_PATH; ?>comm/withdrawal"><i class="fa fa-tasks fa-fw"></i> Withdrawal</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a class="unavailable-link" href="#"><i class="fa fa-calendar fa-fw"></i> Activity</a>
                    </li>
                    <li>
                        <a target="_blank" href="http://webmail.whatyouwant.my/"><i class="fa fa-envelope fa-fw"></i> Email</a>
                    </li>
                    <li>
                        <a href="<?php echo BASE_PATH; ?>tools"><i class="fa fa-cubes fa-fw"></i> Tools</a>
                    </li>
                </ul>
            </div>
            <ol class="breadcrumb">
                <li><a href="<?php echo BASE_PATH; ?>dashboard"><span class="glyphicon glyphicon-home"></span></a></li>
                <?php
                if (isset($this->breadcrumbs)) {
                    echo $this->breadcrumbs;
                }
                ?>
            </ol>
            <div class="content">
                <div class="row">
                    <div class="col-xs-12">

