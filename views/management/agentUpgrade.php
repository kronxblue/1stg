<?php
$userdata = $this->userdata;
$user_acc_type = $this->user_acc_type;

$acc_type_list = $this->acc_type_list;
$paymentMethodList = $this->paymentMethodList;
$bankList = $this->bankList;
?>
<div class="col-xs-12">
    <h2 class="page-header">
        Agent Upgrade
    </h2>
    <div class="container">
	<div class="col-sm-12">
	    <form role="form" action="<?php echo BASE_PATH; ?>management/agentUpgrade_exec" method="post" id="frmAgentUpgrade" name="frmAgentUpgrade">
		<div class="row">
		    <div class="col-sm-4">
			<div class="form-group">
			    <label for="agent_id">Agent ID</label>
			    <input type="text" class="form-control" readonly="readonly" id="agent_id" name="agent_id" value="<?php echo $userdata['agent_id']; ?>">
			</div>
		    </div>
		    <div class="col-sm-8">
			<div class="form-group">
			    <label for="fullname">Fullname</label>
			    <input type="text" class="form-control" readonly="readonly" id="fullname" name="fullname" value="<?php echo $userdata['fullname']; ?>">
			</div>
		    </div>
		</div>
		<div class="row">
		    <div class="col-sm-4">
			<div class="form-group">
			    <label for="username">Username</label>
			    <input type="text" class="form-control" readonly="readonly" id="username" name="username" value="<?php echo $userdata['username']; ?>">
			</div>
		    </div>
		    <div class="col-sm-4">
			<div class="form-group">
			    <label for="curr_acc_type">Account Type</label>
			    <input type="text" class="form-control" readonly="readonly" id="curr_acc_type" name="curr_acc_type" value="<?php echo $user_acc_type['label']; ?>">
			</div>
		    </div>
		    <div class="col-sm-4">
			<div class="form-group">
			    <label for="acc_price">Account Price</label>
			    <div class="input-group">
				<div class="input-group-addon">RM</div>
				<input type="text" class="form-control" readonly="readonly" id="acc_price" name="acc_price" value="<?php echo number_format($user_acc_type['price']); ?>">
			    </div>
			</div>
		    </div>
		</div>
		<hr>
		<div class="row">
		    <div class="col-sm-4">
			<div class="form-group">
			    <label for="acc_type">Upgrade To Account *</label>
			    <select class="form-control" id="acc_type" name="acc_type" data-url="<?php echo BASE_PATH; ?>management/getAccDetails">
				<option value="">Select account type</option>
				<?php
				foreach ($acc_type_list as $key => $value) {
					if ($value['public_view'] == 1) {
						$t = $value['label'];
						$p = $value['price'];
						$c = $value['code'];
						echo "<option value='$c'>$t - RM$p</option>";
					}
				}
				?>
			    </select>			    
			</div>
		    </div>
		    <div class="col-sm-4">
			<div class="form-group">
			    <label for="ads_pin_limit">Ads Slot</label>
			    <input type="text" class="form-control" readonly="readonly" id="ads_pin_limit" name="ads_pin_limit" value="">
			</div>
		    </div>
		    <div class="col-sm-4">
			<div class="form-group">
			    <label for="payment_price">Account Price</label>
			    <div class="input-group">
				<div class="input-group-addon">RM</div>
				<input type="text" class="form-control" readonly="readonly" id="payment_price" name="payment_price" value="">
			    </div>
			</div>
		    </div>
		</div>
		<hr>
		<div class="row">
		    <div class="col-sm-12">
			<div class="form-group">
			    <label for="payment_for">Payment For</label>
			    <input type="text" class="form-control" readonly="readonly" id="payment_for" name="payment_for" value="">
			</div>
		    </div>
		    <div class="col-sm-6">
			<div class="form-group">
			    <label for="payment_date">Upgrade Date *</label>
			    <input type="text" class="form-control" id="payment_date" name="payment_date" value="<?php echo date("Y-m-d"); ?>">
			    <input type="hidden" id="payment_time" name="payment_time" value="<?php echo date("H:i:s"); ?>">
			</div>
		    </div>
		    <div class="col-sm-6">
			<div class="form-group">
			    <label for="payment_type">Payment Type *</label>
			    <select class="form-control" id="payment_type" name="payment_type">
				<option value="">Select payment type.</option>
				<?php
				foreach ($paymentMethodList as $key => $value) {
					$method = $value['pay_method'];
					$code = $value['code'];
					echo "<option value='$code'>$method</option>";
				}
				?>
			    </select>
			</div>
		    </div>
		    <div class="col-sm-12">
			<div class="form-group">
			    <label for="from_acc">Payment Details *</label>
			    <input type="text" class="form-control" id="from_acc" name="from_acc" placeholder="Example - Transfer from CIMB 08040085556238." value="Direct payment to company account.">
			</div>
		    </div>
		    <div class="col-sm-6">
			<div class="form-group">
			    <label for="to_acc">Pay To Account *</label>
			    <select id="to_acc" name="to_acc" class="form-control">
				<option value="">Select account bank.</option>
				<?php
				foreach ($bankList as $value) {
					$bankName = $value['name'];
					$bankCode = $value['code'];
					$accNo = $value['acc_no'];
					if ($value['acc_no'] != NULL) {
						echo "<option value='$bankCode'>$bankName - $accNo</option>";
					}
				}
				?>
			    </select>
			</div>
		    </div>
		    <div class="col-sm-6">
			<div class="form-group">
			    <label for="ref">Reference No.</label>
			    <input type="text" class="form-control" id="ref" name="ref" placeholder="Example: Transaction No / Cheque No.">
			</div>
		    </div>
		    <div class="col-sm-12">
			<div class="form-group">
			    <label for="remarks">Remarks</label>
			    <textarea class="form-control" id="remarks" name="remarks"></textarea>
			</div>
		    </div>
		</div>
		<hr>
		<div class="alert small" role="alert" id="alert">
		    <button type="button" class="close">
			<span aria-hidden="true">&times;</span>
			<span class="sr-only">Close</span>
		    </button>
		    <div id="alert-body"></div>
		</div>
		<div class="row">
		    <div class="col-sm-12">
			<input type="hidden" id="date_submit" name="date_submit" value="<?php echo date("Y-m-d H:i:s"); ?>">
			<a href="<?php echo BASE_PATH; ?>management/agentList" id="btn_cancel" name="btn_cancel" class="btn btn-lg btn-danger pull-left">Cancel</a>
			<button type="submit" id="btn_submit" name="btn_submit" class="btn btn-lg btn-primary pull-right">Submit</button>
		    </div>
		</div>
	    </form>
	</div>
    </div>
</div>
