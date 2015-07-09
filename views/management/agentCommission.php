<?php
$agentData = $this->agentData;
$agent_id = $agentData['agent_id'];
$accType = $this->accType;

switch ($agentData['payment']) {
	case 0:
		$payment = "<span class='label label-warning'>Not Complete.</span>";
		break;
	case 1:
		$payment = "<span class='label label-info'>Waiting for verify.</span>";
		break;
	case 2:
		$payment = "<span class='label label-success'>Completed.</span>";
		break;

	default:
		$payment = "<span class='label label-danger'>Terminated.</span>";
		break;
}

$commissionsType = $this->commissionType;
$monthList = $this->monthList;

$getTotalCommission = $this->getTotalCommission;
$getTotalPayout = $this->getTotalPayout;
$getAvailPayout = $this->getAvailPayout;

$pdiListSum = $this->pdiList;
$gdiListSum = $this->gdiList;
$gaiListSum = $this->gaiList;
$paiListSum = $this->paiList;
$pbtListSum = $this->pbtList;
$gbtListSum = $this->gbtList;
$aprListSum = $this->aprList;

$header_color = "active";

$selectType = isset($_REQUEST["type"]) ? $_GET['type'] : NULL;
$selectMonth = isset($_REQUEST["month"]) ? $_GET['month'] : NULL;
?>
<div id="agentCommission" class="col-xs-12">
    <h2 class="page-header">
        Agent Commission
    </h2>
    <div class="col-sm-12">
        <div class="alert alert-info">
	    <div class="row">
                <div class="col-xs-12">
		    <div class="col-xs-12">
			<form id="frmSearch" name="frmSearch" class="form-horizontal">
			    <div class="form-group">
				<label for="s" class="col-sm-2 col-xs-12  control-label">Search :</label>
				<div class="col-sm-8 col-xs-12 ">
				    <input type="text" class="form-control" data-verify="1" data-url="<?php echo BASE_PATH; ?>mynetwork/getSponsorID" id="agent_id" name="agent_id" placeholder="Username / Agent ID" value="<?php echo $agent_id; ?>" redirect-url="<?php echo BASE_PATH; ?>management/agentCommission" />
				    <div class="agentList hidden"></div>
				</div>
				<div class="col-sm-2 col-xs-12">
				    <button type="submit" class="btn btn-primary btn-group-justified">Go!</button>
				</div>
			    </div>
			</form>
		    </div>
		</div>
	    </div>
        </div>
        <div class="col-xs-12">
	    <div class="panel panel-default">
		<div class="panel-body">
		    <div class="table-responsive">
			<table class="table table-bordered table-condensed">
			    <thead>
				<tr class="active">
				    <th class="text-center" width="150px">
					Agent ID
				    </th>
				    <th class="text-center">
					Fullname
				    </th>
				    <th class="text-center">
					Username
				    </th>
				    <th class="text-center">
					Acc. Type
				    </th>
				    <th class="text-center">
					Payment
				    </th>
				    <th class="text-center">
					Action
				    </th>
				</tr>
			    </thead>
			    <tbody>
				<tr class="text-center">
				    <td>
					<?php echo $agent_id; ?>
				    </td>
				    <td>
					<?php echo $agentData['fullname']; ?>
				    </td>
				    <td>
					<?php echo $agentData['username']; ?>
				    </td>
				    <td>
					<?php echo $accType['label']; ?>
				    </td>
				    <td>
					<?php echo $payment; ?>
				    </td>
				    <td>
					<a href="<?php echo BASE_PATH; ?>management/addCommission?agent_id=<?php echo $agent_id; ?>" class="btn btn-sm btn-primary unavailable-link"><i class="fa fa-plus-square fa-fw"></i> Add Commission</a>
				    </td>
				</tr>
			    </tbody>
			</table>
		    </div>
		</div>
	    </div>
	</div>
        <div class="col-xs-12">
            <h3>
                Summary
            </h3>
            <div class="table-responsive">
                <table class="table table-bordered table-condensed">
                    <thead>
                        <tr class="<?php echo $header_color; ?>">
                            <th rowspan="2" colspan="2"></th>
                            <th colspan="12" class="text-center">MONTH</th>
                        </tr>
                        <tr  class="<?php echo $header_color; ?>">
			    <?php
			    foreach ($monthList as $value) {
				    echo "<th class='text-center'>$value</th>";
			    }
			    ?>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th rowspan="7" class="text-center <?php echo $header_color; ?>" style="vertical-align: middle;">
                                COMM.
                                <br/>
                                TYPE
                            </th>
                            <td class="<?php echo $header_color; ?>">
				<?php
				foreach ($commissionsType as $key => $value) {
					$code = $value['code'];

					if ($code == "pdi") {
						echo $value['abbr'];
					}
				}
				?>
                            </td>
			    <?php
			    foreach ($pdiListSum as $value) {
				    echo "<td class='text-center'>RM" . number_format($value) . "</td>";
			    }
			    ?>
                        </tr>
                        <tr>
                            <td class="<?php echo $header_color; ?>">
				<?php
				foreach ($commissionsType as $key => $value) {
					$code = $value['code'];

					if ($code == "gdi") {
						echo $value['abbr'];
					}
				}
				?>
                            </td>
			    <?php
			    foreach ($gdiListSum as $value) {
				    echo "<td class='text-center'>RM" . number_format($value) . "</td>";
			    }
			    ?>
                        </tr>
                        <tr>
                            <td class="<?php echo $header_color; ?>">
				<?php
				foreach ($commissionsType as $key => $value) {
					$code = $value['code'];

					if ($code == "pai") {
						echo $value['abbr'];
					}
				}
				?>
                            </td>
			    <?php
			    foreach ($paiListSum as $value) {
				    echo "<td class='text-center'>RM" . number_format($value) . "</td>";
			    }
			    ?>
                        </tr>
                        <tr>
                            <td class="<?php echo $header_color; ?>">
				<?php
				foreach ($commissionsType as $key => $value) {
					$code = $value['code'];

					if ($code == "gai") {
						echo $value['abbr'];
					}
				}
				?>
                            </td>
			    <?php
			    foreach ($gaiListSum as $value) {
				    echo "<td class='text-center'>RM" . number_format($value) . "</td>";
			    }
			    ?>
                        </tr>
                        <tr>
                            <td class="<?php echo $header_color; ?>">
				<?php
				foreach ($commissionsType as $key => $value) {
					$code = $value['code'];

					if ($code == "pbt") {
						echo $value['abbr'];
					}
				}
				?>
                            </td>
			    <?php
			    foreach ($pbtListSum as $value) {
				    echo "<td class='text-center'>RM" . number_format($value) . "</td>";
			    }
			    ?>
                        </tr>
                        <tr>
                            <td class="<?php echo $header_color; ?>">
				<?php
				foreach ($commissionsType as $key => $value) {
					$code = $value['code'];

					if ($code == "gbt") {
						echo $value['abbr'];
					}
				}
				?>
                            </td>
			    <?php
			    foreach ($gbtListSum as $value) {
				    echo "<td class='text-center'>RM" . number_format($value) . "</td>";
			    }
			    ?>
                        </tr>
                        <tr>
                            <td class="<?php echo $header_color; ?>">
				<?php
				foreach ($commissionsType as $key => $value) {
					$code = $value['code'];

					if ($code == "apr") {
						echo $value['abbr'];
					}
				}
				?>
                            </td>
			    <?php
			    foreach ($aprListSum as $value) {
				    echo "<td class='text-center'>RM" . number_format($value) . "</td>";
			    }
			    ?>
                        </tr>
                        <tr class="<?php echo $header_color; ?>">
                            <th colspan="2" class="text-center">Total Commission</th>
			    <?php
			    ksort($monthList);
			    foreach ($monthList as $key => $value) {
				    $totalMonthlyComm = $pdiListSum[$key] + $gdiListSum[$key] + $gaiListSum[$key] + $paiListSum[$key] + $pbtListSum[$key] + $gbtListSum[$key] + $aprListSum[$key];
				    echo "<td class='text-center'>RM" . number_format($totalMonthlyComm) . "</td>";
			    }
			    ?>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-xs-12">
	    <h3>Commission List</h3>
	    <div class="row">
		<div class="col-xs-12">
		    <form class="form-inline">
			<div class="form-group col-xs-6">
			    <label for="ftype"><h4>Type :</h4></label>
			    <select id="ftype" name="ftype" class="form-control">
				<option value="all">All</option>
				<?php
				foreach ($commissionsType as $key => $value) {
					$code = $value['code'];
					if ($code == $selectType) {
						echo "<option selected='selected' value='" . $value['code'] . "'>" . $value['abbr'] . "</option>";
					} else {
						echo "<option value='" . $value['code'] . "'>" . $value['abbr'] . "</option>";
					}
				}
				?>
			    </select>
			</div>
			<div class="form-group col-xs-6">
			    <label for="fmonth"><h4>Month :</h4></label>
			    <select id="fmonth" name="fmonth" class="form-control">
				<option value="all">All</option>
				<?php
				foreach ($monthList as $key => $value) {
					if ($value == $selectMonth) {
						echo "<option selected='selected' value='$value'>$value</option>";
					} else {
						echo "<option value='$value'>$value</option>";
					}
				}
				?>
			    </select>
			</div>
		    </form>
		</div>
	    </div>
	    <br/>
	    <div class="alert alert-info">
		<div class="row text-center">
		    <div class="col-sm-4">
			<b>Total Earning : RM<?php echo number_format($getTotalCommission); ?></b>
		    </div>
		    <div class="col-sm-4">
			<b>Total Payout : RM<?php echo number_format($getTotalPayout); ?></b>
		    </div>
		    <div class="col-sm-4">
			<b>Available Payout : RM<?php echo number_format($getAvailPayout); ?></b>
		    </div>
		</div>
	    </div>
	    <input type="hidden" id="p" name="p" value="<?php echo isset($_REQUEST['p']) ? $_GET['p'] : 1; ?>" />
	    <input type="hidden" id="agent_id" name="agent_id" value="<?php echo $agent_id; ?>" />
	    <input type="hidden" id="url" name="url" value="<?php echo BASE_PATH; ?>management/agentCommission?agent_id=<?php echo $agent_id; ?>" />
	    <div id="commissionsList" data-url="<?php echo BASE_PATH; ?>management/commissionList" class="table-responsive">
		<div class="col-xs-12 text-center">
		    <i class="fa fa-spinner fa-spin fa-3x"></i>
		    <br/>
		    <br/>
		    <p>
			Generating commission list. Please wait...
		    </p>
		</div>
	    </div>
	</div>
    </div>
</div>
