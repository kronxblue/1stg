<?php
$userdata = $this->_userData;



$countryList = $this->countryList;
$statesList = $this->statesList;

$statesArr = $statesList[0]['states'];
$statesDecode = json_decode($statesArr);
$states = get_object_vars($statesDecode);
?>
<div class="col-xs-12">
    <h2 class="page-header">Account Setup</h2>
    <?php
    include 'menu.php';
    ?>
    <div>
        <div class="account-setup tab-content">
            <div class="tab-pane active" id="home">
                <div class="col-xs-12">
                    <form class="col-xs-12" action="<?php echo BASE_PATH; ?>setup/saveDetails" method="post" id="frm_details" name="frm_details" role="form">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="form-group col-sm-6">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" readonly="readonly" id="username" name="username" placeholder="Username" value="<?php echo $userdata['username']; ?>">
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="agent_id">Agent ID</label>
                                    <input type="text" class="form-control" readonly="readonly" id="agent_id" name="agent_id" placeholder="Agent ID" value="<?php echo $userdata['agent_id']; ?>">
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="fullname">Fullname</label>
                                    <input type="text" class="form-control" readonly="readonly" id="fullname" name="fullname" placeholder="Fullname" value="<?php echo $userdata['fullname']; ?>">
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" readonly="readonly" id="email" name="email" placeholder="Email" value="<?php echo $userdata['email']; ?>">
                                </div>

                                <div class="divider"></div>

                                <div class="form-group col-sm-6">
                                    <label for="ic_no">IC Number *</label>
                                    <input type="text" class="form-control" id="ic_no" name="ic_no" placeholder="Enter your IC number. (without 'space' or '-')" value="<?php echo $userdata['ic_no']; ?>">
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="gender">Gender *</label>
                                    <select id="gender" name="gender" class="form-control">
					<?php
					$g = $userdata['gender'];
					?>
                                        <option value="">Select your gender.</option>
					<option <?php ($g == "m") ? print_r("selected='selected'") : NULL; ?> value="m">Male</option>
                                        <option <?php ($g == "f") ? print_r("selected='selected'") : NULL; ?> value="f">Female</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="address">Mailing Address *</label>
                                    <input type="text" class="form-control" id="address" name="address" placeholder="Enter your adress. (include street name, poscode and area)" value="<?php echo $userdata['address']; ?>">
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="mobile">Mobile Number *</label>
                                    <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Enter your mobile no. (eg: +60172345678)" value="<?php echo $userdata['mobile']; ?>">
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="country">Nationality *</label>
                                    <select id="country" name="country" class="form-control">
                                        <option value="">Select your nationality.</option>
					<?php
					foreach ($countryList as $value) {
						$countryName = $value['name'];
						$countryCode = $value['code'];

						if ($userdata['country'] == $countryCode) {
							echo "<option selected='selected' value='$countryCode'>$countryName</option>";
						} else {
							echo "<option value='$countryCode'>$countryName</option>";
						}
					}
					?>
                                    </select>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="phone">Phone Number</label>
                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter your phone no. (eg: +60532127177)" value="<?php echo $userdata['phone']; ?>">
                                </div>
                                <div id="states" class="form-group col-sm-6 <?php ($userdata['country'] == "MY") ? NULL : "hidden"; ?>">
                                    <label for="states">States *</label>
                                    <select name="states" class="form-control">
                                        <option value="">Select your states.</option>
					<?php
					foreach ($states as $key => $value) {
						$statesName = $value;
						$statesCode = $key;
						
						if ($userdata['states'] == $statesCode) {
							echo "<option selected='selected' value='$statesCode'>$statesName</option>";
						} else {
							echo "<option value='$statesCode'>$statesName</option>";
						}
						
						
					}
					?>
                                    </select>
                                </div>
                                <div class="divider"></div>
                                <div class="alert small" role="alert" id="alert">
                                    <button type="button" class="close">
                                        <span aria-hidden="true">&times;</span>
                                        <span class="sr-only">Close</span>
                                    </button>
                                    <div id="alert-body"></div>
                                </div>
                            </div>
                            <div class="panel-footer clearfix">
                                <button type="submit" id="btn_submit" name="btn_submit" class="btn btn-primary pull-right">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
