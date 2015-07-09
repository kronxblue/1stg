<?php
$user = $this->userdata;
?>
<div class="container join">
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
                <span class="text-green">Account</span> Activated
            </h2>

            <p>
                Congratulations! You have successfully activate your <?php echo SITE_TITLE; ?> account.
                <br/>
                We have email your temporary login and account details to <b><?php echo $user['email']; ?></b>.
                <br/>
                <br/>
                If you don't receive any email with your login details, <a href="<?php echo BASE_PATH; ?>join/resend_details" id="resend_details" data-email='<?php echo $user['email']; ?>'>click here to resend your account details</a>.
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
                <a href="<?php echo BASE_PATH; ?>login" class="btn btn-primary">Go to Login area</a>
            </p>
        </div>
    </div>
</div>