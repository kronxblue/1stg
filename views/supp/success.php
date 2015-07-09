<?php
$user = $this->userdata;

?>
<div class="container join">
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
                <span class="text-green">Registration</span> Success
            </h2>

            <p>
                Congratulations! You have successfully create your <?php echo WYW_SUPPLIER_NAME; ?> account.
                <br/>
                We have email your account activation link to <b><?php echo $user['comp_email']; ?></b>.
                <br/>
                <br/>
                If you don't receive any email with your activation link, <a href="<?php echo BASE_PATH; ?>supp/resend_activation" id="resend_activation" data-email='<?php echo $user['comp_email']; ?>'>click here to resend your account activation link</a>.
            </p>
            <div class="alert small" role="alert" id="alert">
                <button type="button" class="close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <div id="alert-body"></div>
            </div>
            <br/>
            <p>
                <a href="<?php echo BASE_PATH; ?>home" class="btn btn-primary">Go to Homepage</a>
            </p>
        </div>
    </div>
</div>
