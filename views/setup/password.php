<div class="col-xs-12">
    <h2 class="page-header">Account Setup</h2>
    <?php
    include 'menu.php';
    ?>
    <div>
        <div class="account-setup tab-content">
            <div class="tab-pane active" id="home">
                <div class="col-xs-12">
                    <form class="col-sm-6 col-sm-offset-3" action="<?php echo BASE_PATH; ?>setup/savePassword" method="post" id="frm_password" name="frm_password" role="form">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Set your password. (Min: 6 character)">
                                </div>
                                <div class="form-group">
                                    <label for="cpassword">Confirm Password</label>
                                    <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Retype your password.">
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
                                <button type="submit" id="btn_submit" name="btn_submit" class="btn btn-primary pull-right">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
