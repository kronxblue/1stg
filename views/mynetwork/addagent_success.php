<?php
$user = $this->userdata;
?>
<div id="addagent_success" class="col-xs-12">
    <h2 class="page-header">
        Successful Add New Agent
    </h2>
    <div class="col-xs-12">
        <p>
            Congratulations! You have successfully create <?php echo SITE_TITLE; ?> account for <b><?php echo ucwords(strtolower($user['fullname'])); ?></b>.
            <br/>
            We have email the account activation link to <b><?php echo $user['email']; ?></b>. Please make sure this agent activate his/her account.
            <br/>
            <br/>
            If the agent not receive any email with the activation link, they can request their activation link again from login area.
        </p>
        <br/>
        <p>
            <a href="<?php echo BASE_PATH; ?>mynetwork/geneology" class="btn btn-primary">Go to Geneology</a>
        </p>
    </div>
</div>
