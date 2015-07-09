<?php


$accTypeList = $this->accTypeList;
$userdata = $this->_userData;
$newUplineData = $this->newUplineData;
$upline_id = $newUplineData['lv1'];

$countryList = $this->countryList;
$statesList = $this->statesList;
$statesArr = $statesList[0]['states'];
$statesDecode = json_decode($statesArr);
$states = get_object_vars($statesDecode);

array_shift($newUplineData);
?>
<div id="addagent" class="col-xs-12">
    <h2 class="page-header">
        Add New Agent
    </h2>
    <div class="col-xs-12">
        <form role="form" action="<?php echo BASE_PATH; ?>mynetwork/addagent_exec" method="post" id="frmAddAgent" name="frmAddAgent">
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="acc_type">Account Type *</label>
                        <select id="acc_type" name="acc_type" class="form-control">
                            <option value="">Select agent's account type.</option>
			    <?php
			    foreach ($accTypeList as $value) {
				    $price = $value['price'];
				    $label = $value['label'];
				    $code = $value['code'];
				    $public_view = $value['public_view'];

				    if ($public_view == '1') {
					    echo "<option value='$code'>$label - RM" . number_format($price) . "</option>";
				    }
			    }
			    ?>
                        </select>
                    </div>
                </div>
            </div>
	    <div class="row">
		<div id="sponsorArea" class="col-sm-4">
		    <div class="form-group">
			<label for="sponsor_id">Sponsor ID *</label>
			<input type="text" class="form-control" data-verify="1" data-url="<?php echo BASE_PATH; ?>mynetwork/getSponsorID" id="sponsor_id" name="sponsor_id" placeholder="Sponsor ID or Username" value="<?php echo $userdata['agent_id']; ?>" />
			<div class="agentList hidden"></div>
		    </div>
		</div>
		<div class="col-sm-4">
		    <div class="form-group">
			<label for="lv1">Upline ID *</label>
			<input type="text" readonly="readonly" class="form-control" id="lv1" name="lv1" placeholder="Upline ID" value="<?php echo $upline_id; ?>" />
		    </div>
		</div>
	    </div>
	    <div class="row">
		<div class="col-sm-4">
		    <div class="form-group">
			<label for="salutation">Salutation *</label>
			<select class="form-control" id="salutation" name="salutation">
			    <option value="">-- Select --</option>
			    <option value="MR." >Mr.</option>
			    <option value="MISS." >Miss</option>
			    <option value="MRS." >Mrs.</option>
			    <option value="MS." >Ms.</option>
			    <option value="DR." >Dr.</option>
			</select>
		    </div>
		</div>
		<div class="col-sm-8">
		    <div class="form-group">
			<label for="fullname">Fullname *</label>
			<input type="text" class="form-control" id="fullname" name="fullname" placeholder="Enter agent's fullname" />
			<span class="small text-muted help-block">* Fullname must be same as in agent's Identification Card (IC).</span>
		    </div>
		</div>
	    </div>
	    <div class="row">
		<div class="col-sm-6">
		    <div class="form-group">
			<label for="ic_no">IC Number *</label>
			<input type="text" class="form-control" id="ic_no" name="ic_no" placeholder="Enter agent's IC number. (without 'space' or '-')">
		    </div>
		</div>
		<div class="col-sm-6">
		    <div class="row">
			<div class="form-group">
			    <label for="dob" class="col-xs-12">Date Of Birth *</label>
			    <div class="col-xs-4">
				<select class="form-control" id="dob_m" name="dob_m">
				    <option value="-1">Month</option>
				    <?php
				    for ($m = 1; $m <= 12; $m++) {
					    $month = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
					    $month_v = date('m', mktime(0, 0, 0, $m, 1, date('Y')));
					    echo "<option value='$month_v' >$month</option>";
				    }
				    ?>
				</select>
			    </div>
			    <div class="col-xs-4">
				<select class="form-control" id="dob_d" name="dob_d">
				    <option value="-1">Day</option>
				    <?php
				    for ($d = 1; $d <= 31; $d++) {
					    echo "<option value='$d' >$d</option>";
				    }
				    ?>
				</select>
			    </div>
			    <div class="col-xs-4">
				<select class="form-control" id="dob_y" name="dob_y">
				    <option value="-1">Year</option>
				    <?php
				    $yearNow = date('Y') - 17;
				    $yearList = $yearNow - 50;
				    $yearArr = range($yearList, $yearNow);
				    rsort($yearArr);

				    foreach ($yearArr as $year) {
					    echo "<option value='$year' >$year</option>";
				    }
				    ?>
				</select>
			    </div>
			</div>
		    </div>
		</div>
		<br/>
	    </div>
	    <div class="row">
		<div class="col-sm-12">
		    <div class="form-group">
			<label for="address">Mailing Address *</label>
			<input type="text" class="form-control" id="address" name="address" placeholder="Enter agent's adress. (include street name, poscode and area)">
		    </div>
		</div>
	    </div>
	    <div class="row">
		<div class="col-sm-6">
		    <div class="form-group">
			<label for="country">Country *</label>
			<select id="country" name="country" class="form-control">
			    <option value="">Select agent's country.</option>
			    <?php
			    foreach ($countryList as $value) {
				    $countryName = $value['name'];
				    $countryCode = $value['code'];
				    echo "<option value='$countryCode'>$countryName</option>";
			    }
			    ?>
			</select>
		    </div>
		</div>
		<div id="states" class="col-sm-6 hidden">
		    <div class="form-group">
			<label for="states">States *</label>
			<select id="states" name="states" class="form-control">
			    <option value="">Select agent's states.</option>
			    <?php
			    foreach ($states as $key => $value) {
				    $statesName = $value;
				    $statesCode = $key;
				    echo "<option value='$statesCode'>$statesName</option>";
			    }
			    ?>
			</select>
		    </div>
		</div>
	    </div>
	    <div class="row">
		<div class="col-sm-4">
		    <div class="form-group">
			<label for="gender">Gender *</label>
			<select id="gender" name="gender" class="form-control">
			    <option value="">Select agent's gender.</option>
			    <option value="m">Male</option>
			    <option value="f">Female</option>
			</select>
		    </div>
		</div>
		<div class="col-sm-4">
		    <div class="form-group">
			<label for="phone">Phone Number</label>
			<input type="text" class="form-control" id="phone" name="phone" placeholder="Enter agent's phone no. (eg: +60532127177)">
		    </div>
		</div>
		<div class="col-sm-4">
		    <div class="form-group">
			<label for="mobile">Mobile Number *</label>
			<input type="text" class="form-control" id="mobile" name="mobile" placeholder="Enter agent's mobile no. (eg: +60172345678)">
		    </div>
		</div>
	    </div>
	    <div class="row">
		<div class="col-sm-6">
		    <div class="form-group">
			<label for="username">Username *</label>
			<div class="input-group">
			    <input type="text" class="form-control" id="username" name="username" placeholder="Enter agent's username. (3 - 20 character)" />

			    <span class="input-group-btn">
				<button class="btn btn-info" id="chkusername" name="chkusername" data-url="<?php echo BASE_PATH; ?>join/chkUsername" data-check="0" type="button">Check availability</button>
			    </span>
			</div>
			<span class="small text-muted help-block"><strong>NOTE!</strong> Usernames are important..</span>
		    </div>
		</div>
	    </div>
	    <div class="row">
		<div class="col-sm-6">
		    <div class="form-group">
			<label for="email">Email *</label>
			<input type="email" class="form-control" id="email" name="email" placeholder="Enter agent's email" />
		    </div>
		</div>
		<div class="col-sm-6">
		    <div class="form-group">
			<label for="cemail">Confirm Email *</label>
			<input type="email" class="form-control" id="cemail" name="cemail" placeholder="Enter agent's email again" />
		    </div>
		</div>
	    </div>
	    <div class="alert small" role="alert" id="alert">
		<button type="button" class="close">
		    <span aria-hidden="true">&times;</span>
		    <span class="sr-only">Close</span>
		</button>
		<div id="alert-body"></div>
	    </div>
	    <div class="clearfix text-center">
		<div class="row">
		    <div class="col-xs-6">
			<button type="button" data-url="<?php echo BASE_PATH; ?>mynetwork/geneology" class="col-xs-12 btn btn-danger btn-lg" id="btn_cancel">Cancel</button> 
		    </div>
		    <div class="col-xs-6">
			<button type="submit" class="col-xs-12 btn btn-primary btn-lg" id="btn_submit">Register Now!</button> 
		    </div>
		</div>
	    </div>
	    <?php
	    foreach ($newUplineData as $key => $value) {
		    ?>
		    <input type="hidden" class="form-control" id="<?php echo $key; ?>" name="<?php echo $key; ?>" value="<?php echo $value; ?>" />
		    <?php
	    }
	    ?>
	    <input type="hidden" class="form-control" id="dt_join" name="dt_join" value="<?php echo Date('Y-m-d H:i:s'); ?>" />
	    <input type="hidden" class="form-control" id="dob" name="dob" value="" />
	    <input type="hidden" class="form-control" id="subscribe" name="subscribe" value="on" />

        </form>
    </div>
</div>
