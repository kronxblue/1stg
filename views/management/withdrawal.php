<?php
$pending_count = $this->pendingCount;
?>
<div id="manageWithdrawal" class="col-xs-12">
    <h2 class="page-header">
        Withdrawal Record
    </h2>
        <div class="col-sm-6">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-search fa-fw"></i></span>
                <input type="text" id="s" name="s" class="form-control" placeholder="Search holder name / agent ID" value="<?php echo isset($_REQUEST['s']) ? $_GET['s'] : NULL; ?>">
                <span class="input-group-btn">
                    <?php
                    echo isset($_REQUEST['s']) ? "<a id='btnClear' class='btn btn-danger' href='" . BASE_PATH . "management/withdrawal'>Clear search <i class='fa fa-times fa-fw'></i></a>" : NULL;
                    ?>
                    <button id="btn-search" data-url="<?php echo BASE_PATH; ?>management/withdrawal?s=" class="btn btn-default" type="button">Go!</button>
                </span>
            </div>
        </div>
    <div class="col-sm-12">
        <h3>
            Waiting for Review
            <button type="button" class="btn btn-primary btn-sm pull-right" id="btn-review-all" name="btn-review-all" data-count="<?php echo $pending_count; ?>">Review All</button>
            <input type="hidden" id="rp" name="rp" value="<?php echo isset($_REQUEST['rp']) ? $_GET['rp'] : 1; ?>" />
        </h3>
        <div id="allAction">
            <div class="alert alert-info clearfix">
                <form action="<?php BASE_PATH; ?>management/withdrawalReviewAll">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="status_all">Status *</label>
                            <select class="form-control input-sm" id="status_all" name="status_all">
                                <option value="">Please select status.</option>
                                <option value="-1">Reject</option>
                                <option value="1">Process</option>
                                <option value="2">Complete</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label for="bank_name">Remarks</label>
                            <input type="text" class="form-control input-sm" id="remarks" name="remarks" value="" />
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <input type="button" class="btn btn-danger btn-sm" id="btn_cancel" name="btn_cancel" value="Cancel" />
                        <input type="submit" class="btn btn-primary btn-sm" id="btn_submit" name="btn_submit" value="Submit" />
                    </div>
                </form>
            </div>
        </div>
        <div id="waitingReview" data-url="<?php echo BASE_PATH; ?>management/getWithdrawList" class="table-responsive">
            <div class="col-xs-12 text-center">
                <i class="fa fa-spinner fa-spin fa-3x"></i>
                <br/>
                <br/>
                <p>
                    Generating withdrawal list. Please wait...
                </p>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <h3>
            Waiting for Complete Process
            <input type="hidden" id="pp" name="pp" value="<?php echo isset($_REQUEST['pp']) ? $_GET['pp'] : 1; ?>" />
        </h3>
        <div id="waitingProcess" data-url="<?php echo BASE_PATH; ?>management/getWithdrawList" class="table-responsive">
            <div class="col-xs-12 text-center">
                <i class="fa fa-spinner fa-spin fa-3x"></i>
                <br/>
                <br/>
                <p>
                    Generating withdrawal list. Please wait...
                </p>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <h3>
            All Record
            <input type="hidden" id="sp" name="sp" value="<?php echo isset($_REQUEST['sp']) ? $_GET['sp'] : 1; ?>" />
        </h3>
        <div id="summaryWithdraw" data-url="<?php echo BASE_PATH; ?>management/getWithdrawList" class="table-responsive">
            <div class="col-xs-12 text-center">
                <i class="fa fa-spinner fa-spin fa-3x"></i>
                <br/>
                <br/>
                <p>
                    Generating withdrawal list. Please wait...
                </p>
            </div>
        </div>
    </div>
</div>