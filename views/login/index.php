<div class="container">
    <div class="row">
        <div class="login col-lg-4 col-lg-offset-4 col-md-6 col-md-offset-3 col-xs-10 col-xs-offset-1 clearfix">
            <h2 class="page-header col-xs-12 text-center"><span class="text-blue">Agent</span> Login</h2>
            <form role="form" class="col-xs-12" action="<?php echo BASE_PATH; ?>login/exec" method="POST" id="frm_login" name="frm_login">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" />
                </div>
                <div class="form-group">
                    <label for="pass">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" />

                    <a href="<?php echo BASE_PATH; ?>login/forgotPass" class="btn-link btn-sm btn-forgot-pass">Forgot password?</a>


                </div>
                <div class="checkbox page-header clearfix">
                    <label>
                        <input type="checkbox" name="rememberme" value="on" /> Remember me on this computer.
                    </label>
                </div>
                <div class="alert small" role="alert" id="alert">
                    <button type="button" class="close">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <div id="alert-body"></div>
                </div>
                <div class="clearfix">

                    <div class="row">
                        <div class="col-xs-12">
                            <a href="<?php echo BASE_PATH; ?>join" class="btn btn-success pull-left">Create an account</a>
                            <button type="submit" class="btn btn-primary pull-right">Log in</button>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <a href="<?php echo BASE_PATH; ?>join/request_activation" class="btn-link btn-sm">Don't receive activation email? Click here.</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
