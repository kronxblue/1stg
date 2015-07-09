<?php
$paymentDetails = $this->paymentDetails;

$id = $paymentDetails['id'];
$agent_id = $paymentDetails['agent_id'];
$fullname = $paymentDetails['fullname'];
$payment_for = $paymentDetails['payment_for'];
$ads_pin = $paymentDetails['ads_pin'];
$payment_date = $paymentDetails['payment_date'];
$payment_time = $paymentDetails['payment_time'];

$from_acc = $paymentDetails['from_acc'];
$to_acc = $this->to_acc['name'] . " - " . $this->to_acc['acc_no'];
$payment_type = $this->payment_type['pay_method'];
$ref = $paymentDetails['ref'];
$amount = $paymentDetails['amount'];
$status = $paymentDetails['status'];
?>
<div id="reviewPayment" class="col-xs-12">
    <h2 class="page-header">
        Payment Review
    </h2>
    <div class="col-sm-12">
        <form role="form" action="<?php echo BASE_PATH; ?>management/payment_review_exec" method="post" id="frmReviewPayment" name="frmReviewPayment">
            <div class="row">
                <h3 class="page-header">
                    Payment Details
                </h3>
            </div>
            <div class="row">
                <div class="form-group col-sm-6">
                    <label for="payee">Payee Name</label>
                    <p class="form-control-static text-primary"><?php echo $fullname; ?></p>
                </div>
                <div class="form-group col-sm-6">
                    <label for="ads_pin">Advertisement Pin</label>
                    <p class="form-control-static text-primary"><?php echo ($ads_pin != "") ? $ads_pin : "-"; ?></p>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-6">
                    <label for="payment_for">Payment For</label>
                    <p class="form-control-static text-primary"><?php echo $payment_for; ?></p>
                </div>

                <div class="form-group col-sm-6">
                    <label for="ref">Reference No.</label>
                    <p class="form-control-static text-primary"><?php echo ($ref != "") ? $ref : "-"; ?></p>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-6">
                    <label for="payment_date">Payment Date</label>
                    <p class="form-control-static text-primary"><?php echo date("d M Y", strtotime($payment_date)) . " / " . date("h:i A", strtotime($payment_time)); ?></p>
                </div>
                <div class="form-group col-sm-6">
                    <label for="payment_type">Payment Type</label>
                    <p class="form-control-static text-primary"><?php echo $payment_type; ?></p>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-6">
                    <label for="from_acc">From Account</label>
                    <p class="form-control-static text-primary"><?php echo $from_acc; ?></p>

                </div>
                <div class="form-group col-sm-6">
                    <label for="to_acc">To Account</label>
                    <p class="form-control-static text-primary"><?php echo $to_acc; ?></p>
                </div>

                <div class="form-group col-sm-6">
                    <label for="amount">Amount</label>
                    <p class="form-control-static text-primary"><?php echo "RM " . number_format($amount); ?></p>
                </div>
            </div>
            <div class="row">
                <h3 class="page-header">
                    Management
                </h3>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="status">Status *</label>
                    <select class="form-control" id="status" name="status">
                        <option <?php echo ($status == "0") ? "selected='selected'" : NULL; ?> value="">Please verify payment status.</option>
                        <option <?php echo ($status == "-1") ? "selected='selected'" : NULL; ?> value="-1">Reject</option>
                        <option <?php echo ($status == "1") ? "selected='selected'" : NULL; ?> value="1">Pending</option>
                        <option <?php echo ($status == "2") ? "selected='selected'" : NULL; ?> value="2">Approve</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="remarks">Remarks</label>
                    <textarea class="form-control" id="remarks" name="remarks" rows="5"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="alert small" role="alert" id="alert">
                        <button type="button" class="close">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <div id="alert-body"></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <input type="hidden" id="agent_id" name="agent_id" value="<?php echo $agent_id; ?>">
                    <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
                    <input type="hidden" id="ads_pin" name="ads_pin" value="<?php echo $ads_pin; ?>">
                    <input type="hidden" id="amount" name="amount" value="<?php echo $amount; ?>">
                    <button type="button" id="btn_cancel" name="btn_cancel" data-url="<?php echo BASE_PATH; ?>management/payment" class="btn btn-danger">Cancel</button>
                    <button type="submit" id="btn_submit" name="btn_submit" class="btn btn-primary">Submit Review</button>
                </div>
            </div>
        </form>
    </div>
</div>