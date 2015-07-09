<div class="container join">
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
                <span class="text-primary">Request</span> Activation
            </h2>
            <div class="row">
                <div class="col-xs-12">
                    <form class="col-xs-12 form-horizontal" role="form" action="<?php echo BASE_PATH; ?>join/resend_activation" id="frmRequestActivation" name="frmRequestActivation">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label for="email" >Email :</label>
                            </div>
                            <div class="col-sm-6">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Please enter your email address.">
                            </div>
                        </div>
                        <div class="alert small col-sm-6" role="alert" id="alert">
                            <button type="button" class="close">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Close</span>
                            </button>
                            <div id="alert-body"></div>
                        </div>
                        <div class="clearfix">
                            <div class="row">
                                <div class="col-xs-12">
                                    <a href="<?php echo BASE_PATH; ?>login" id="btn_cancel" name="btn_cancel" class="btn btn-danger">Cancel</a>
                                    <button type="submit" id="btn_submit" name="btn_submit" class="btn btn-primary">Resend Activation Link</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>