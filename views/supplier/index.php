<?php
$has_alert = $this->alert;
$alert_text = $this->alert_text;
$monthList = $this->monthList;

$header_color = "active";

?>
<div id="supplier" class="col-xs-12">
    <h2 class="page-header">
        Supplier List <a class="btn btn-primary btn-sm pull-right" href="<?php echo BASE_PATH; ?>supplier/addNew">Add New Supplier</a>
    </h2>
    <?php
    if ($has_alert) {
	    ?>
	    <div class="alert small alert-<?php echo $has_alert; ?>" role="alert">
		<button type="button" class="close">
		    <span aria-hidden="true">&times;</span>
		    <span class="sr-only">Close</span>
		</button>
		<?php echo $alert_text; ?>
	    </div>
	    <?php
    }
    ?>
<!--    <div class="col-xs-12">
        <h3>
            Summary
        </h3>
        <div class="table-responsive">
            <table class="table table-bordered table-condensed">
                <thead>
                    <tr class="<?php echo $header_color; ?>">
                        <th rowspan="2" colspan="1"></th>
                        <th colspan="13" class="text-center">MONTH</th>
                    </tr>
                    <tr  class="<?php echo $header_color; ?>">
			<?php
			foreach ($monthList as $value) {
				echo "<th class='text-center'>$value</th>";
			}
			?>
                        <th class="text-center" width="100">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-center">
                        <th class="active text-center">
                            New Supplier
                        </th>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>-->
    <div class="col-xs-12">
        <div id="searchSupplier" class="row">
            <div class="col-sm-4">
                <div class="input-group input-group-sm">
                    <span class="input-group-addon"><i class="fa fa-search fa-fw"></i></span>
                    <input type="text" id="s" name="s" data-url="<?php echo BASE_PATH; ?>supplier/free?s=" class="form-control" placeholder="Search company name" value="<?php echo isset($_REQUEST['s']) ? $_GET['s'] : NULL; ?>">
                    <span class="input-group-btn">
			<?php
			echo isset($_REQUEST['s']) ? "<a id='btnClear' class='btn btn-danger' href='" . BASE_PATH . "supplier'>Clear search <i class='fa fa-times fa-fw'></i></a>" : NULL;
			?>
                        <button id="btnSearch" class="btn btn-default" type="button" data-url="<?php echo BASE_PATH; ?>supplier?s=">Go!</button>

                    </span>
		    <input type="hidden" id="p" name="p" value="<?php echo isset($_REQUEST['p']) ? $_GET['p'] : "1"; ?>">
                </div>
            </div>
        </div>
        <br/>
        <div id="supplierList" class="table-responsive" data-url="<?php echo BASE_PATH; ?>supplier/ajaxSupplierList">
            <div class="col-xs-12 text-center">
                <i class="fa fa-spinner fa-spin fa-3x"></i>
                <br/>
                <br/>
                <p>
                    Generating supplier list. Please wait...
                </p>
            </div>
        </div>
    </div>
</div>
