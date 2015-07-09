<?php
$agentData = $this->agentData;
$commType = $this->commType;
?>
<div id="addCommission" class="col-xs-12">
    <h2 class="page-header">
        Add Agent Commission <a href="<?php echo BASE_PATH; ?>management/agentCommission?agent_id=<?php echo $agentData['agent_id']; ?>" class="btn btn-primary pull-right"><i class="fa fa-chevron-left fa-fw"></i> Back</a>
    </h2>
    <div class="row">
	<div class="col-sm-12">
	    <form name="frmAddCommission" id="frmAddCommission" class="form" action="<?php echo BASE_PATH; ?>management/ajaxAddCommission">
		<div class="form-group">
		    <div class="row">
			<div class="col-sm-6">
			    <label for="s" class="control-label">Fullname :</label>
			    <p class="form-control-static"><?php echo $agentData['fullname']; ?></p>
			</div>
			<div class="col-sm-6">
			    <label for="s" class="control-label">Username :</label>
			    <p class="form-control-static"><?php echo $agentData['username']; ?></p>
			</div>
		    </div>
		    <div class="row">
			<div class="col-sm-6">
			    <label for="s" class="control-label">Agent ID :</label>
			    <p class="form-control-static"><?php echo $agentData['agent_id']; ?></p>
			</div>
			<div class="col-sm-6">
			    <label for="s" class="control-label">Ads Pin ID :</label>
			    <p class="form-control-static"><?php echo $agentData['ads_pin']; ?></p>
			</div>
		    </div>
		    <br/>
		    <div class="panel panel-default">
			<div class="row">
			    <div class="panel-body">
				<div class="row">
				    <div class="col-sm-12">
					<div class="col-sm-6">
					    <label for="commission_type" class="control-label">Commission Type :</label>
					    <select id="commission_type" name="commission_type" class="form-control" data-url="<?php echo BASE_PATH; ?>management/getSubject">
						<option>Select type</option>
						<?php
						foreach ($commType as $key => $value) {
							$code = $value['code'];
							$abbr = $value['abbr'];
							echo "<option value='$code'>$abbr</option>";
						}
						?>
					    </select>
					</div>
					<div class="col-sm-6">
					    <div class="form-group">
						<label for="from" class="control-label">From :</label>
						<input class="form-control" readonly="readonly" type="text" id="from" name="from" data-verify="0" data-type="0" data-url="<?php echo BASE_PATH; ?>management/getAgentID" username="" />
						<div class="agentList hidden"></div>
					    </div>
					</div>
				    </div>
				</div>
				<br/>
				<div class="row">
				    <div class="col-sm-12">
					<div class="col-sm-6">
					    <label for="subject" class="control-label">Subject :</label>
					    <input type="hidden" id="subject" name="subject" />
					    <p class="form-control-static subject"></p>
					</div>
					<div class="col-sm-6">
					    <label for="amount" class="control-label">Amount :</label>
					    <div class="input-group">
						<div class="input-group-addon">RM</div>
						<input type="text" class="form-control" id="amount" name="amount" placeholder="Enter commission amount" />
					    </div>

					</div>
				    </div>
				</div>
				<br/>
				<div class="row">
				    <div class="col-sm-12">
					<div class="col-sm-6">
					    <label for="date" class="control-label">Date :</label>
					    <div class="input-group">
						<input class="form-control" readonly="readonly" type="text" id="date" name="date" />
						<span class="input-group-btn">
						    <button id="btnDate" name="btnDate" class="btn btn-default" type="button"><i class="fa fa-calendar fa-fw"></i> Pick</button>
						</span>
					    </div>
					</div>
					<div class="col-sm-6">
					    <label for="dateRelease" class="control-label">Date Release :</label>
					    <div class="input-group">
						<input class="form-control" readonly="readonly" type="text" id="dateRelease" name="dateRelease" />
						<span class="input-group-btn">
						    <button id="btnDateRelease" name="btnDateRelease" class="btn btn-default" type="button"><i class="fa fa-calendar fa-fw"></i> Pick</button>
						</span>
					    </div>
					</div>
				    </div>
				</div>
			    </div>
			</div>
		    </div>
		</div>
	    </form>
	</div>
    </div>
</div>
