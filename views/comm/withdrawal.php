<?php
$userdata = $this->_userData;

$availableComm = $this->_availableCommission;
$bankList = $this->bankList;

$bankDetails = $this->bankDetails;
$bankName = $bankDetails['bank_name'];
$acc_no = $bankDetails['acc_no'];
$holderName = $bankDetails['holder_name'];

$monthList = $this->monthList;
?>

<div id="withdrawal" class="col-xs-12">
    <h2 class="page-header">
        Withdrawal
    </h2>
    <div class="col-xs-12">
        <h3>
            Request
        </h3>
        <div class="row">
            <div class="col-xs-12">
                <div class="alert alert-info small" role="alert">
                    <strong>Note :</strong>
                    <ol>
                        <li>
                            All withdrawal request will process within <b>3 working days</b> on (15th and at the end of the month) every month.
                        </li>
                        <li>
                            Bank holder name must be same as 1STG registered account name.
                        </li>
                        <li>
                            All withdrawal transaction will be deduct <b>RM5</b> for bank process and admin fee.
                        </li>
                        <li>
                            All transaction will done through Direct Transfer via our Company Account or Cheque.
                        </li>
                    </ol>
                </div>
            </div>
        </div>
        <form role="form" action="<?php echo BASE_PATH; ?>comm/withdrawal_exec" method="post" id="frmWithdrawal" name="frmWithdrawal">
            <div class="row">
                <div class="col-xs-12">
                    <h3>Available Payout : <span class="text-primary">RM<?php echo number_format($availableComm); ?></span></h3>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="bank_name">Bank *</label>
                        <select class="form-control" id="bank_name" name="bank_name">
                            <option value="">Select bank</option>
                            <?php
                            foreach ($bankList as $key => $value) {
                                $name = $value['name'];
                                $code = $value['code'];

                                echo ($code == $bankName) ? "<option selected='selected' value='$code'>$name</option>" : "<option value='$code'>$name</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="acc_no">Account No.</label>
                        <input type="text" class="form-control" id="acc_no" name="acc_no" placeholder="Enter your bank account no." value="<?php echo $acc_no; ?>" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="holder_name">Bank Holder Name</label>
                        <input type="text" class="form-control" id="holder_name" name="holder_name" placeholder="Enter your fullname." value="<?php echo $holderName; ?>" />
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <div class="input-group">
                            <span class="input-group-addon">RM</span>
                            <input type="text" class="form-control" id="amount" name="amount" placeholder="Enter amount you want to withdraw." value="" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your 1STG account password."  value="" />
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
            <div class="clearfix">
                <div class="row">
                    <div class="col-xs-6">
                        <input type="hidden" class="form-control" id="agent_id" name="agent_id" value="<?php echo $userdata['agent_id']; ?>" />
                        <input type="hidden" class="form-control" id="date_request" name="date_request" value="<?php echo date("Y-m-d H:i:s"); ?>" />
                        <button type="submit" class="btn btn-primary" id="btn_submit">Submit</button> 
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="col-xs-12">
        <h3>
            History
            <input type="hidden" id="p" name="p" value="<?php echo isset($_REQUEST['p']) ? $_GET['p'] : 1; ?>" />
        </h3>
        <div id="filterMonth" class="row form-horizontal">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="col-sm-3 col-md-2 control-label" for="f">Filter :</label>
                    <div class="col-sm-7 col-md-6">
                        <select class="form-control" id="f" name="f">
                            <option value="">Filter by month</option>
                            <?php
                            foreach ($monthList as $value) {
                                $code = date("Y-m", strtotime($value));

                                if (isset($_REQUEST['f'])) {
                                    $f = $_GET['f'];
                                    if ($f == $code) {
                                        echo "<option selected='selected' value='$code' >$value</option>";
                                    } else {
                                        echo "<option value='$code' >$value</option>";
                                    }
                                } else {
                                    echo "<option value='$code' >$value</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div id="withdrawalHistory" data-url="<?php echo BASE_PATH; ?>comm/getWithdrawalStatement" class="table-responsive">
            <div class="col-xs-12 text-center">
                <i class="fa fa-spinner fa-spin fa-3x"></i>
                <br/>
                <br/>
                <p>
                    Generating withdrawal history. Please wait...
                </p>
            </div>
        </div>
    </div>
</div>