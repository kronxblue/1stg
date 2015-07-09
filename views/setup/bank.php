<?php
$user = $this->_userData;
$bankData = $this->bankData;
$bankList = $this->bankList;

$holder_name = ($bankData['holder_name'] == "") ? $user['fullname'] : $bankData['holder_name'];
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
                    <form class="col-sm-6 col-sm-offset-3" action="<?php echo BASE_PATH; ?>setup/saveBank" method="post" id="frm_bank" name="frm_bank" role="form">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="holder_name">Bank Holder Name *</label>
                                    <input type="text" class="form-control" id="holder_name" name="holder_name" placeholder="Enter bank account holder name." value="<?php echo ucwords(strtolower($holder_name)); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="bank_name">Bank Name *</label>
                                    <select id="bank_name" name="bank_name" class="form-control">
                                        <option value="">Select your bank.</option>
					<?php
					foreach ($bankList as $value) {
						$bankName = $value['name'];
						$bankCode = $value['code'];
						if ($bankData['bank_name'] == $bankCode) {
							echo "<option selected='selected' value='$bankCode'>$bankName</option>";
						} else {
							echo "<option value='$bankCode'>$bankName</option>";
						}
					}
					?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="acc_no">Bank Account No. *</label>
                                    <input type="text" class="form-control" id="acc_no" name="acc_no" placeholder="Enter your bank account no." value="<?php echo $bankData['acc_no'] ?>">
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
                                <button type="button" id="btn_skip_bank" name="btn_skip_bank" data-url="<?php echo BASE_PATH; ?>setup/skipBank" class="btn btn-default pull-left">Skip</button>
                                <button type="submit" id="btn_submit" name="btn_submit" class="btn btn-primary pull-right">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
