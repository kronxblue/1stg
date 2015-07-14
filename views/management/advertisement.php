<?php
$data = $this->data;

$header_color = "active";
?>
<div id="advertisement" class="col-xs-12">
    <h2 class="page-header">
        Advertisement <a class="btn btn-primary btn-sm pull-right" href="<?php echo BASE_PATH; ?>management/supplier">View Supplier List</a>
    </h2>
    <div class="col-xs-12">
        <h3>
	    <?php
	    print_r($data['title']);
	    ?>
        </h3>
	<input type="hidden" id="p" name="p" value="<?php echo isset($_REQUEST['p']) ? $_GET['p'] : "1"; ?>">
	<div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel">
	    <div class="modal-dialog" role="document">
		<div class="modal-content">
		    <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="ModalLabel"><span id="ads_name">Phyto Science</span> by <span id="comp_name" class="small">Trandix Corp</span></h4>
		    </div>
		    <div id="modal-body" class="modal-body">
			<div class="col-md-6">
			    <b>Day Left:</b> <span id="day_left">-</span>
			</div>
			<div class="col-md-6">
			    <b>Duration:</b> <span id="duration">-</span>
			</div>
			<div class="col-md-6">
			    <b>Payment:</b><br/>
			    <span id="payment">-</span>
			</div>
			<div class="col-md-6">
			    <b>Commission:</b><br/>
			    <span id="commission">-</span>
			</div>
			<div class="col-md-6">
			    <b>Link:</b><br/>
			    <span id="link">-</span>
			</div>
			<div class="col-md-6">
			    <b>FB Hash Tag:</b><br/>
			    <span id="hashtag">-</span>
			</div>
			<div class="col-md-12">
			    <b>Ads:</b><br/>
			    <span id="adsImg">-</span>
			</div>
			<div class="clearfix"></div>
		    </div>
		    <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		    </div>
		</div>
	    </div>
	</div>
	<div id="searchAds" class="row">
            <div class="col-sm-4">
                <div class="input-group input-group-sm">
                    <span class="input-group-addon"><i class="fa fa-search fa-fw"></i></span>
                    <input type="text" id="s" name="s" class="form-control" placeholder="Search advertisement name / supplier ID" value="<?php echo isset($_REQUEST['s']) ? $_GET['s'] : NULL; ?>">
                    <span class="input-group-btn">
			<?php
			echo isset($_REQUEST['s']) ? "<a id='btnClear' class='btn btn-danger' href='" . BASE_PATH . "management/advertisement'>Clear search <i class='fa fa-times fa-fw'></i></a>" : NULL;
			?>
                        <button id="btnSearch" class="btn btn-default" type="button" data-url="<?php echo BASE_PATH; ?>management/advertisement?s=">Go!</button>

                    </span>
		    <input type="hidden" id="p" name="p" value="<?php echo isset($_REQUEST['p']) ? $_GET['p'] : "1"; ?>">
                </div>
            </div>
        </div>
        <br/>
        <div id="adsList" class="table-responsive"  data-spec="<?php echo $supplier_data; ?>">
	    <?php
	    echo $data['list'];
	    ?>
        </div>
	<?php if (isset($_REQUEST['sid'])) { ?>
		<a class="btn btn-primary btn-sm" href="<?php echo BASE_PATH; ?>advertisement"><i class="fa fa-fw fa-list-alt"></i> View all advertisement</a>
	<?php } ?>
    </div>

</div>
