<?php
$supplier_data = $this->supplier_data;

$header_color = "active";
?>
<div id="advertisement" class="col-xs-12">
    <h2 class="page-header">
        Advertisement <a class="btn btn-primary btn-sm pull-right" href="<?php echo BASE_PATH; ?>supplier">View Supplier List</a>
    </h2>
    <div class="col-xs-12">
        <h3>
	    <?php if ($supplier_data == FALSE) { ?>
		    Summary
		    <?php
	    } else {
		    print_r($supplier_data['comp_name']);
	    }
	    ?>
        </h3>
	<input type="hidden" id="p" name="p" value="<?php echo isset($_REQUEST['p']) ? $_GET['p'] : "1"; ?>">
	<div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel">
	    <div class="modal-dialog" role="document">
		<div class="modal-content">
		    <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="ModalLabel">Phyto Science <span class="small">by Trandix Corp</span></h4>
		    </div>
		    <div class="modal-body">
			<div class="col-md-6">
			    <b>Day Left:</b> 133 days
			</div>
			<div class="col-md-6">
			    <b>Duration:</b> 12 month
			</div>
			<div class="col-md-6">
			    <b>Payment:</b><br/>
			    RM 1,200
			</div>
			<div class="col-md-6">
			    <b>Commission:</b><br/>
			    RM 600
			</div>
			<div class="col-md-6">
			    <b>Link:</b><br/>
			    #
			</div>
			<div class="col-md-6">
			    <b>Hash Tag:</b><br/>
			    #adsWYW
			</div>
			<div class="col-md-12">
			    <b>Ads:</b><br/>
			    <img src="<?php echo BASE_PATH; ?>public/images/ads/86/img_lg.jpg" width="100%"/>
			</div>
			<div class="clearfix"></div>
		    </div>
		    <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		    </div>
		</div>
	    </div>
	</div>
        <div id="adsList" class="table-responsive" data-url="<?php echo BASE_PATH; ?>advertisement/ajaxAdsList" data-spec="<?php echo $supplier_data; ?>">
            <table class="table table-bordered table-condensed">
                <thead>
                    <tr>
                        <th class="text-center" width="50px">#</th>
                        <th class="text-center" width="150px">Ads ID</th>
                        <th class="text-center" width="150px">Ads Pin</th>
                        <th class="text-center" >Supplier Name</th>
                        <th class="text-center" >Ads Name</th>
                        <th class="text-center" width="150px">Document Date</th>
                        <th class="text-center" width="150px">Receive Date</th>
                        <th class="text-center" width="150px">Status</th>
                        <th class="text-center" width="150px">Start Date</th>
                        <th class="text-center" width="150px">Expiry Date</th>
                        <th class="text-center" width="300px"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-center">
                        <td>1</td>
                        <td>902983728</td>
                        <td>N/A</td>
                        <td><a href="advertisement?sid=1109299050">Trandix Corp</a></td>
                        <td>Phyto Science</td>
                        <td>30 May 2015</td>
                        <td>31 May 2015</td>
                        <td>Designing</td>
                        <td>21 May 2015</td>
                        <td>21 May 2016</td>
                        <td id="details">
			    <!--<a class="btn btn-link btn-details-toggle" href="#">Details</a>-->
			    <button type="button" class="btn btn-primary btn-sm btn-details-toggles" data-toggle="modal" data-target="#detailsModal">
				Details
			    </button>
			</td>
                    </tr>
                </tbody>
            </table>


        </div>
	<?php if (isset($_REQUEST['sid'])) { ?>
		<a class="btn btn-primary btn-sm" href="<?php echo BASE_PATH; ?>advertisement"><i class="fa fa-fw fa-list-alt"></i> View all advertisement</a>
	<?php } ?>
    </div>

</div>
