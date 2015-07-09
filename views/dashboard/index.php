<?php
$userdata = $this->_userData;

$availablePin = $userdata['available_pin'];

$totalPinSold = $this->totalPinSold;

$totalEarning = $this->totalEarning;
$totalAgentSponsor = $this->totalAgentSponsor;

$reminder = $this->reminder;

$gps_amount = "RM 2,400";
?>
<div id="dashboard" class="col-xs-12">
    <h2 class="page-header">
        Dashboard
    </h2>
    <div class="col-xs-12">
        <?php
        if (!empty($reminder)) {
            ?>
            <div class="row">
                <div class="col-xs-12">
                    <div class="alert alert-warning">
                        Notice:
                        <?php
                        $i = 1;
                        foreach ($reminder as $value) {
                            ?>
                            <div><?php echo $i . ". " . $value; ?></div>
                            <?php
                            $i++;
                        }
                        ?>

                    </div>
                </div>
            </div>
            <?php
        }
        ?>
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Referral Link
                        </h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-condensed">
                            <thead>
                                <tr class="active">
                                    <th class="text-center">Link 1</th>
                                    <th class="text-center">Link 2</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-center">
                                    <td><?php echo BASE_PATH . "r/s/" . $userdata['agent_id']; ?></td>
                                    <td><?php echo BASE_PATH . "r/s/" . $userdata['username']; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div id="qlink" class="panel panel-info panel-collapse">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Quick Links
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="ql-btn col-xs-4 col-md-4">
                            <a class="btn btn-default col-xs-12" target="_blank" href="http://webmail.whatyouwant.my/">
                                <span class="col-xs-12">
                                    <i class="fa fa-envelope fa-fw fa-2x"></i>
                                </span>
                                <span class="col-xs-12">
                                    Email
                                </span>
                            </a>
                        </div>
                        <div class="ql-btn col-xs-4 col-md-4">
                            <a class="btn btn-default col-xs-12" href="<?php echo BASE_PATH; ?>mynetwork">
                                <span class="col-xs-12">
                                    <i class="fa fa-globe fa-fw fa-2x"></i>
                                </span>
                                <span class="col-xs-12">
                                    My Network
                                </span>
                            </a>
                        </div>
                        <div class="ql-btn col-xs-4 col-md-4">
                            <a class="btn btn-default col-xs-12" href="<?php echo BASE_PATH; ?>mynetwork/geneology">
                                <span class="col-xs-12">
                                    <i class="fa fa-sitemap fa-fw fa-2x"></i>
                                </span>
                                <span class="col-xs-12">
                                    Geneology
                                </span>
                            </a>
                        </div>
                        <div class="ql-btn col-xs-4 col-md-4">
                            <a class="btn btn-default col-xs-12" href="<?php echo BASE_PATH; ?>supplier">
                                <span class="col-xs-12">
                                    <i class="fa fa-truck fa-fw fa-2x"></i>
                                </span>
                                <span class="col-xs-12">
                                    Supplier
                                </span>
                            </a>
                            </a>
                        </div>
                        <div class="ql-btn col-xs-4 col-md-4">
                            <a class="btn btn-default col-xs-12" href="<?php echo BASE_PATH; ?>comm">
                                <span class="col-xs-12">
                                    <i class="fa fa-money fa-fw fa-2x"></i>
                                </span>
                                <span class="col-xs-12">
                                    Commission
                                </span>
                            </a>
                            </a>
                        </div>
                        <div class="ql-btn col-xs-4 col-md-4">
                            <a class="btn btn-default col-xs-12" href="<?php echo BASE_PATH; ?>comm/withdrawal">
                                <span class="col-xs-12">
                                    <i class="fa fa-tasks fa-fw fa-2x"></i>
                                </span>
                                <span class="col-xs-12">
                                    Withdrawal
                                </span>
                            </a>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
	    <div id="gps" class="col-md-6">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h2 id="fx-gps-title">
                            Global Pool Bonus
                        </h2>
                    </div>
                    <div class="panel-body">
                        <h1 id="fx-gps-value"><?php echo $gps_amount; ?></h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Latest News
                        </h3>
                    </div>
                    <div class="panel-body">
                        No latest news available.
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            My Achievement Report
                        </h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-condensed">
                            <tbody>
                                <tr>
                                    <td width="200" class="text-right">Total Commission :</td>
                                    <td class="text-center"><a href="<?php echo BASE_PATH; ?>comm">RM<?php echo number_format($totalEarning); ?></a></td>
                                </tr>
                                <tr>
                                    <td width="200" class="text-right">Total Agents Sponsored :</td>
                                    <td class="text-center"><?php echo $totalAgentSponsor; ?></td>
                                </tr>
                                <tr>
                                    <td width="200" class="text-right">Total Free Supplier :</td>
                                    <td class="text-center">0</td>
                                </tr>
                                <tr>
                                    <td width="200" class="text-right">Total Advertisement :</td>
                                    <td class="text-center">0</td>
                                </tr>
                                <tr>
                                    <td width="200" class="text-right">Reseller Ads Pin Balance :</td>
                                    <td class="text-center"><?php echo $availablePin; ?></td>
                                </tr>
                                <tr>
                                    <td width="200" class="text-right">Reseller Ads Pin Sold :</td>
                                    <td class="text-center"><a href="<?php echo BASE_PATH; ?>comm?type=apr&month=all"><?php echo $totalPinSold; ?> (RM <?php echo $totalPinSold*1200; ?>)</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Latest Advertisement
                        </h3>
                    </div>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <div class="media text-center">
                                No record available.
                            </div>
                        </li>
                        <!--                        <li class="list-group-item">
                                                    <div class="media">
                                                        <a class="pull-left" href="#">
                                                            <img class="media-object" src="<?php echo IMAGES_PATH; ?>user-default.png" style="max-width: 50px; max-height: 50px">
                                                        </a>
                                                        <div class="media-body">
                                                            <small class="pull-right text-muted">by: aloongjerr</small>
                                                            <div><b>TK Inspiration Holding (M) Sdn Bhd</b></div>
                                                            <div class="text-muted small">TK-Facial Secured Door Access and Attandance System.</div>
                        
                                                        </div>
                                                    </div>
                                                </li>-->
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Top 5 Agents Referrer <small><?php echo date("M Y"); ?></small>
                        </h3>
                    </div>
                    <div id="topSponsor" data-url="<?php echo BASE_PATH; ?>dashboard/topSponsor" class="table-responsive">
                        <table class="table table-bordered table-condensed">
                            <thead>
                                <tr class="active">
                                    <th class="text-center" width="50">#</th>
                                    <th class="text-center">Username</th>
                                    <th class="text-center" width="100">Total</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr class="text-center">
                                    <td colspan="3">
                                        <div class="col-xs-12 text-center">
                                            <br/>
                                            <i class="fa fa-spinner fa-spin fa-3x"></i>
                                            <br/>
                                            <br/>
                                        </div>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Top 5 Supplier Referrer <small><?php echo date("M Y"); ?></small>
                        </h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-condensed">
                            <thead>
                                <tr class="active">
                                    <th class="text-center" width="50">#</th>
                                    <th class="text-center">Username</th>
                                    <th class="text-center" width="100">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-center">
                                    <td colspan="3">No record available.</td>
                                </tr>
<!--                                <tr class="text-center">
                                    <td>1</td>
                                    <td>aloongjerr</td>
                                    <td>12</td>
                                </tr>-->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
