<?php
$header_color = "active";

$s = isset($_REQUEST['s']) ? $_GET['s'] : null;
$p = isset($_REQUEST["p"]) ? $_GET['p'] : 1;
?>
<div class="col-xs-12">
    <h2 class="page-header">
        Agent List
    </h2>
    <div class="col-sm-12">	
        <div class="row">
	    <div class="col-xs-12">
		<form class="form-horizontal" name="frmAgentList" id="frmAgentList" data-url="<?php echo BASE_PATH; ?>management/agentList">
		    <div class="form-group">
			<label for="s" class="col-sm-2 col-xs-12 control-label">Search :</label>
			<div class="col-sm-8 col-xs-9">
			    <input type="text" class="form-control" id="s" name="s" placeholder="Username / Agent ID" value="<?php echo $s; ?>">
			</div>
			<div class="col-sm-2 col-xs-3">
			    <button type="submit" class="btn btn-primary">Search</button>
			</div>
		    </div>
		</form>
	    </div>
	</div>
        <div class="row">
	    <div class="col-xs-12">
		<input type="hidden" id="p" name="p" value="<?php echo $p; ?>" />
		<div id="agentList" class="table-responsive" data-url="<?php echo BASE_PATH; ?>management/ajaxAgentList">
		</div>
	    </div>
        </div>
    </div>
</div>
