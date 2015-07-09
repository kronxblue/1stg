<?php
$beneficiaryData = $this->beneficiaryData;

$bankList = $this->bankList;
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
                    <form class="col-sm-8 col-sm-offset-2" action="<?php echo BASE_PATH; ?>setup/saveBeneficiary" method="post" id="frm_beneficiary" name="frm_beneficiary" role="form">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="name">Beneficiary Name *</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your beneficiary name." value="<?php echo $beneficiaryData['name'] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="ic_no">Beneficiary IC No. *</label>
                                    <input type="text" class="form-control" id="ic_no" name="ic_no" placeholder="Enter your beneficiary IC number." value="<?php echo $beneficiaryData['ic_no'] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="contact">Beneficiary Contact No. *</label>
                                    <input type="text" class="form-control" id="contact" name="contact" placeholder="Enter your beneficiary contact number." value="<?php echo $beneficiaryData['contact'] ?>">
                                </div>
                                <div class="divider"></div>
                                <div class="form-group">
                                    <label for="bank_name">Bank Name *</label>
                                    <select id="bank_name" name="bank_name" class="form-control">
                                        <option value="">Select your beneficiary bank.</option>
					<?php
					foreach ($bankList as $value) {
						$bankName = $value['name'];
						$bankCode = $value['code'];

						if ($beneficiaryData['bank_name'] == $bankCode) {
							echo "<option selected='selected' value='$bankCode'>$bankName</option>";
						} else {
							echo "<option value='$bankCode'>$bankName</option>";
						}
					}
					?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="bank_acc_no">Bank Account No. *</label>
                                    <input type="text" class="form-control" id="bank_acc_no" name="bank_acc_no" placeholder="Enter your beneficiary bank account no." value="<?php echo $beneficiaryData['bank_acc_no'] ?>">
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
                                <input type="hidden" id="agent_id" name="agent_id" value="<?php echo session::get(AGENT_SESSION_NAME); ?>">
                                <button type="button" id="btn_skip_beneficiary" name="btn_skip_beneficiary" data-url="<?php echo BASE_PATH; ?>setup/skipBeneficiary" class="btn btn-default pull-left">Skip</button>
                                <button type="submit" id="btn_submit" name="btn_submit" class="btn btn-primary pull-right">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
