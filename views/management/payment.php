<div id="managePayment" class="col-xs-12">
    <h2 class="page-header">
        Payment Record
    </h2>
    <div class="col-sm-12">
        <h3>
            Waiting for Review
            <input type="hidden" id="wp" name="wp" value="<?php echo isset($_REQUEST['wp']) ? $_GET['wp'] : 1; ?>" />
        </h3>
        <div id="waitingPayment" data-url="<?php echo BASE_PATH; ?>management/getWaitingPayment" class="table-responsive">
            <div class="col-xs-12 text-center">
                <i class="fa fa-spinner fa-spin fa-3x"></i>
                <br/>
                <br/>
                <p>
                    Generating payment list. Please wait...
                </p>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <h3>
            Summary
            <input type="hidden" id="sp" name="sp" value="<?php echo isset($_REQUEST['sp']) ? $_GET['sp'] : 1; ?>" />
        </h3>
        <div id="searchPayment" class="row">
            <div class="col-sm-4">
                <div class="input-group input-group-sm">
                    <span class="input-group-addon"><i class="fa fa-search fa-fw"></i></span>
                    <input type="text" id="s" name="s" data-url="<?php echo BASE_PATH; ?>management/payment?s=" class="form-control" placeholder="Search fullname / username / agent ID" value="<?php echo isset($_REQUEST['s']) ? $_GET['s'] : NULL; ?>">
                    <span class="input-group-btn">
                        <?php
                        echo isset($_REQUEST['s']) ? "<a id='btnClear' class='btn btn-danger' href='" . BASE_PATH . "management/payment'>Clear search <i class='fa fa-times fa-fw'></i></a>" : NULL;
                        ?>
                        <button id="btnSearch" data-url="<?php echo BASE_PATH; ?>management/payment?s=" class="btn btn-default" type="button">Go!</button>
                    </span>
                </div>

            </div>
        </div>
        <br/>
        <div id="summaryPayment" data-url="<?php echo BASE_PATH; ?>management/getSummaryPayment" class="table-responsive">
            <div class="col-xs-12 text-center">
                <i class="fa fa-spinner fa-spin fa-3x"></i>
                <br/>
                <br/>
                <p>
                    Generating payment list. Please wait...
                </p>
            </div>
        </div>
    </div>
</div>