<?php
$accTypeList = $this->accTypeList;
$referer = $this->referer;

if ($referer != FALSE) {
	$refererData = $this->refererData;
}
?>

<div class="container join">
    <div class="row">
        <div class="col-xs-12">
	    <?php
	    if ($referer != FALSE) {
		    ?>
		    <div class="reffered text-right">
			Referred by: <?php echo $refererData['username']; ?>
			<br/><strong><?php echo $refererData['accType']; ?></strong>
		    </div>
		    <?php
	    }
	    ?>
            <h2 class="page-header">
                Create <span class="text-blue">New</span> Account
            </h2>

            <form role="form" class="col-xs-12" action="<?php echo BASE_PATH; ?>" method="POST" id="frm_join" name="frm_join">
                <div class="row">
                    <div class="form-group col-sm-3">
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
                    <div class="form-group col-sm-9">
                        <label for="fullname">Fullname *</label>
                        <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Enter your fullname" />
                        <span class="small text-muted help-block">* Fullname must be same as in your Identity Card (IC).</span>
                    </div>
                    <div class="form-group col-sm-6" id="username-parent">
                        <label for="username">Username *</label>
                        <div class="input-group">

                            <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username. (3 - 20 character)" />

                            <span class="input-group-btn">
                                <button class="btn btn-info" id="chkusername" name="chkusername" data-url="<?php echo BASE_PATH; ?>join/chkUsername" data-check="0" type="button">Check availability</button>
                            </span>

                        </div>
                        <span class="small text-muted help-block"><strong>NOTE!</strong> Usernames is important..</span>
                    </div>
                    <div class="form-group col-sm-6">
                        <div class="row">
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
                        <span class="small text-muted help-block">* Date of Birth must be same as in your Identity Card (IC).</span>
                    </div>
                </div>

                <div class="page-header">
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="email">Email *</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" />
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="cemail">Confirm Email *</label>
                            <input type="email" class="form-control" id="cemail" name="cemail" placeholder="Enter your email again" />
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="acc_type">Account Type *</label>
                            <select id="acc_type" name="acc_type" class="form-control">
                                <option value="">Select your account type.</option>
				<?php
				foreach ($accTypeList as $value) {
					$price = $value['price'];
					$label = $value['label'];
					$code = $value['code'];

					if ($code != 'admin' and $code != 'md') {
						echo "<option value='$code'>$label - RM" . number_format($price) . "</option>";
					}
				}
				?>
                            </select>
                        </div>
			<div class="form-group col-sm-6">
                            <label for="cemail">Refferal ID *</label>
			    <input type="text" class="form-control" id="sponsor_id" name="sponsor_id" <?php echo ($referer != FALSE) ? "readonly='readonly'" : NULL; ?> value="<?php echo ($referer != FALSE) ? $referer : NULL; ?>" placeholder="Enter 1STG agent refferal ID" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" id="subscribe" name="subscribe" checked="checked"> Yes! Please send me tips and monthly news updates.
                                    </label>
                                </div>
                            </div>
                            <div class="help-block small">
                                By clicking "Create my 1STG account!", you certify that you are at least 18 years old, and agree to our <a href="#" target="_blank">Privacy Policy</a> and <a href="#" target="_blank">Terms and Conditions</a>.
                            </div>
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
                    <button type="submit" class="btn btn-primary btn-lg" id="btn_submit">Create my 1STG account!</button> 
                </div>
                <input type="hidden" id="dt_join" name="dt_join" value="<?php echo Date('Y-m-d H:i:s'); ?>" />
                <input type="hidden" id="dob" name="dob" value="" />
            </form>
        </div>
    </div>
</div>
