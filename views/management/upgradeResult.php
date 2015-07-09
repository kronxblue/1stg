<?php
$userdata = $this->userdata;
$acc_type = $this->acc_type;
$result = $this->result;
?>
<div id="upgradeResult" class="col-xs-12">
    <h2 class="page-header">
        Account Upgrade Result
    </h2>
    <div class="container">
	<div class="col-sm-12">
	    <form class="form-horizontal" role="form" action="<?php echo BASE_PATH; ?>management/agentUpgrade_exec" method="post" id="frmAgentUpgrade" name="frmAgentUpgrade">
		<div class="row">
		    <div class="col-sm-12">
			<div class="form-group">
			    <label class="col-sm-3 control-label">Agent ID :</label>
			    <div class="col-sm-9">
				<p class="form-control-static"><?php echo $userdata['agent_id']; ?></p>
			    </div>
			</div>
		    </div>
		    <div class="col-sm-12">
			<div class="form-group">
			    <label class="col-sm-3 control-label">Username :</label>
			    <div class="col-sm-9">
				<p class="form-control-static"><?php echo $userdata['username']; ?></p>
			    </div>
			</div>
		    </div>
		    <div class="col-sm-12">
			<div class="form-group">
			    <label class="col-sm-3 control-label">Fullname :</label>
			    <div class="col-sm-9">
				<p class="form-control-static"><?php echo $userdata['fullname']; ?></p>
			    </div>
			</div>
		    </div>
		</div>
		<div class="row">
		    <div class="col-sm-12">
			<div class="panel panel-default">
			    <div class="panel-heading">Result Summary</div>
			    <div class="panel-body">
				<div class="form-group">
				    <label class="col-sm-6 control-label">Update Payment :</label>
				    <div class="col-sm-6">
					<p class="form-control-static <?php echo ($result['payment'] == "1") ? "text-green" : "text-danger"; ?>"><b><?php echo ($result['payment'] == "1") ? "Successfull" : "Failed"; ?></b></p>
				    </div>
				</div>
				<div class="form-group">
				    <label class="col-sm-6 control-label">Upgrade Status :</label>
				    <div class="col-sm-6">
					<p class="form-control-static <?php echo ($result['upgrade'] == "1") ? "text-green" : "text-danger"; ?>"><b><?php echo ($result['upgrade'] == "1") ? "Successfull" : "Failed"; ?></b></p>
				    </div>
				</div>
				<div class="form-group">
				    <label class="col-sm-6 control-label">PDI Commission :</label>
				    <div class="col-sm-6">
					<p class="form-control-static <?php echo ($result['pdi'] == "1") ? "text-green" : "text-danger"; ?>"><b><?php echo ($result['pdi'] == "1") ? "Successfull" : "Failed"; ?></b></p>
				    </div>
				</div>
				<div class="form-group">
				    <label class="col-sm-6 control-label">GDI Commission :</label>
				    <div class="col-sm-6">
					<p class="form-control-static <?php echo ($result['gdi'] == "1") ? "text-green" : "text-danger"; ?>"><b><?php echo ($result['gdi'] == "1") ? "Successfull" : "Failed"; ?></b></p>
				    </div>
				</div>
				<div class="form-group">
				    <label class="col-sm-6 control-label">GAI Commission :</label>
				    <div class="col-sm-6">
					<p class="form-control-static <?php echo ($result['gai'] == "1") ? "text-green" : "text-danger"; ?>"><b><?php echo ($result['gai'] == "1") ? "Successfull" : "Failed"; ?></b></p>
				    </div>
				</div>
			    </div>
			</div>
		    </div>
		</div>
		<div class="row">
		    <div class="col-sm-12">
<a href="<?php echo BASE_PATH; ?>management/agentList" id="btn_cancel" name="btn_cancel" class="btn btn-lg btn-primary">Back to Agent List</a>
		    </div>
		</div>
	    </form>
	</div>
    </div>
</div>
