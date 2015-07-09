<?php
$userdata = $this->_userData;
?>

<div class="col-xs-12">
    <h2 class="page-header">Account Setup <span class="text-green">Complete</span></h2>
    <div>
        <div class="account-setup tab-content">
            <div class="tab-pane active" id="home">
                <div class="col-xs-12">
                    <form class="col-sm-8 col-sm-offset-2" action="<?php echo BASE_PATH; ?>setup/savePayment" method="post" id="frm_payment" name="frm_payment" role="form">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <h3 class="text-primary">Congratulation!</h3>
                                <p>
                                    You have completely setup your 1STG account. We will verify your payment within 24 hours.
                                    <br/>
                                    Please take your time to explore 1STG Back Office. If you have any problem, feel free to contact us.
                                </p>
                                <p>
                                    Thank you,
                                    <br/>
                                    1STG Support Team
                                </p>
                            </div>
                            <div class="panel-footer clearfix">
                                <a class="btn btn-primary pull-right" href="<?php echo BASE_PATH; ?>dashboard">Continue to Dashboard</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>