<?php
$userdata = $this->_userData;
$has_ads_pin = $userdata['ads_pin'];

if ($has_ads_pin != NULL) {
    $ads_pin = $has_ads_pin;
    $selectPin = "disabled";
} else {
    $ads_pin = "";
    $selectPin = NULL;
}

$db = new database(DBTYPE, DBHOST, DBNAME, DBUSER, DBPASS);
$checkPin = $db->select("user_accounts", "acc_type", "agent_id = '$has_ads_pin'", "fetch");

if ($checkPin['acc_type'] == 'admin') {
    $selectPin = NULL;
}

$accType = $this->accType;
$bankList = $this->bankList;
$paymentMethodList = $this->paymentMethodList;

$accCode = $userdata['acc_type'];
$colSize = ($accCode != "pb") ? "col-md-6" : "col-md-12";
$notPB = ($accCode != "pb") ? TRUE : FALSE;
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
                    <form class="col-sm-8 col-sm-offset-2" action="<?php echo BASE_PATH; ?>setup/savePayment" method="post" id="frm_payment" name="frm_payment" role="form">
                        <input type="hidden" id="acc_type" name="acc_type" value="<?php echo $accType['code']; ?>" />
                        <div class="panel panel-info small">
                            <div class="panel-body bg-info">
                                <div class="text-info">
                                    <p><b>Note:</b></p>
                                    <ol>
                                        <li>Fill in the form to notify us <b>AFTER</b> you make payment.</li>
                                        <li>All payment will verify within 24 hours.</li>
                                        <li>If you pay cash to 1STG agent, please include agent name in "Details" field..</li>
                                        <li>All account will setup daily from 9am-12am, include Public Holiday.</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="form-group <?php echo $colSize; ?>">
                                        <label for="payment_for">Payment For *</label>
                                        <input type="text" readonly="readonly" class="form-control" id="payment_for" name="payment_for" placeholder="Enter payment subject." value="<?php echo $userdata['agent_id'] . " - " . $accType['label'] . " (RM" . number_format($accType['price']) . ")"; ?>">
                                    </div>
                                    <?php
                                    if ($notPB) {
                                        ?>
                                        <div class="form-group <?php echo $colSize; ?>">
                                            <label for="ads_pin">Advertisement Pin *</label>
                                            <div class="input-group">
                                                <input type="text" readonly="readonly" class="form-control" id="ads_pin" name="ads_pin" placeholder="Select Advertisement Pin" value="<?php echo $ads_pin; ?>">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-info <?php echo $selectPin; ?>" type="button" id="listPin" data-url="<?php echo BASE_PATH; ?>setup/listPin">Select Pin</button>
                                                </span>
                                            </div>
                                        </div>
                                        <?php
                                    } else {
                                        ?>
                                        <input type="text" readonly="readonly" class="form-control hidden" id="ads_pin" name="ads_pin" value="">
                                    <?php } ?>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="payment_date">Payment Date *</label>
                                        <div class="row">
                                            <div class="col-xs-4">
                                                <select class="form-control" id="payment_m" name="payment_m">
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
                                                <select class="form-control" id="payment_d" name="payment_d">
                                                    <option value="-1">Day</option>
                                                    <?php
                                                    for ($d = 1; $d <= 31; $d++) {
                                                        $d = str_pad($d, 2, "0", 0);
                                                        echo "<option value='$d' >$d</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-xs-4">
                                                <select class="form-control" id="payment_y" name="payment_y">
                                                    <option value="-1">Year</option>
                                                    <?php
                                                    $yearNow = date('Y');
                                                    $yearList = $yearNow - 1;
                                                    $yearArr = range($yearList, $yearNow);
                                                    rsort($yearArr);

                                                    foreach ($yearArr as $year) {
                                                        echo "<option value='$year' >$year</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <input type="hidden" class="form-control" id="payment_date" name="payment_date" value="">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="payment_time">Payment Time *</label>
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <select class="form-control" id="payment_h" name="payment_h">
                                                    <option value="-1">Hour</option>
                                                    <?php
                                                    for ($t = 0; $t <= 23; $t++) {
                                                        $t = str_pad($t, 2, "0", 0);
                                                        echo "<option value='$t' >$t</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-xs-6">
                                                <select class="form-control" id="payment_mn" name="payment_mn">
                                                    <option value="-1">Minute</option>
                                                    <?php
                                                    for ($mn = 0; $mn <= 59; $mn++) {
                                                        $mn = str_pad($mn, 2, "0", 0);
                                                        echo "<option value='$mn' >$mn</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <input type="hidden" class="form-control" id="payment_time" name="payment_time" value="">
                                    </div>

                                </div>
                                <div class="divider"></div>
                                <div class="form-group">
                                    <label for="from_acc">Details *</label>
                                    <input type="text" class="form-control" id="from_acc" name="from_acc" placeholder="Example - Transfer from CIMB 08040085556238.">
                                </div>
                                <div class="form-group">
                                    <label for="to_acc">To Account *</label>
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
                                <div class="divider"></div>
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label for="payment_type">Payment Type *</label>
                                        <select id="payment_type" name="payment_type" class="form-control">
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
                                    <div class="form-group col-sm-6">
                                        <label for="ref">Reference No.</label>
                                        <input type="text" class="form-control" id="ref" name="ref" placeholder="Example: Transaction No / Cheque No.">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="amount">Amount *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">RM</span>
                                        <input type="text" class="form-control" id="amount" name="amount" placeholder="Enter amount value" value="<?php echo $accType['price']; ?>">
                                    </div>
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
                                <input type="hidden" id="payment_price" name="payment_price" value="<?php echo $accType['price']; ?>">
                                <input type="hidden" id="date_submit" name="date_submit" value="<?php echo date("Y-m-d H:i:s"); ?>">
                                <button type="submit" id="btn_submit" name="btn_submit" class="btn btn-primary pull-right">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
