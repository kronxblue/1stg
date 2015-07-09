
<div class="container">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    Contact <span class="text-blue">Us</span>
                </h2>
                <div class="row">
                    <div class="col-xs-12">
                        <iframe width="100%" height="350" frameborder="0" style="border:0;" src="https://www.google.com/maps/embed/v1/place?q=Northpoint,+1,+Medan+Syed+Putra+Utara,+Mid+Valley+City,+58000+Kuala+Lumpur,+Wilayah+Persekutuan+Kuala+Lumpur/@3.120408,101.677538,17z/&key=AIzaSyCT7mL4AqsR_NdQSZ270McjlLAdP8j7IPk"></iframe>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="page-header">
                            Drop Us <span class="text-blue">A</span> Line...
                        </h3>
                        <div class="col-xs-12">
                            <form role="form" id="frmContact" name="frmContact" action="<?php echo BASE_PATH; ?>contact/exec" method="post">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Name - How shall we call you.">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Email - We'll keep it safe.">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone - Optional.">
                                        </div>
                                    </div>
                                    <div class="col-xs-12">
                                        <div class="form-group">
                                            <textarea rows="8" id="message" name="message" class="form-control" placeholder="Message - Share with us any information that might help us to respond to your request."></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="alert small" role="alert" id="alert">
                                    <button type="button" class="close">
                                        <span aria-hidden="true">&times;</span>
                                        <span class="sr-only">Close</span>
                                    </button>
                                    <div id="alert-body"></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <button type="submit" class="btn btn-primary pull-right" id="btn_submit" name="btn_submit">Submit <i class="fa fa-send fa-fw"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <h3 class="page-header">
                            Get <span class="text-blue">In</span> Touch...
                        </h3>
                        <div class="col-xs-12">
                            <div class="row">
                                <div class="col-xs-12">
                                    Got an awesome idea? For a FREE proposal and analysis of your needs, please shoot us an email at <span class="text-primary"><?php echo CONTACT_EMAIL; ?></span>. We’ll contact you shortly!
                                </div>
                                <br/>
                                <br/>
                                <br/>
                                <div class="col-xs-12">
                                    <blockquote>
                                        <address>
                                            <i class="fa fa-map-marker fa-fw fa-2x"></i> <strong>Come visit us...</strong>
                                            <br/>
                                            <span class="small">
                                                <?php echo COMPANY_NAME; ?>
                                                <br/>                                                
                                                <?php echo COMPANY_ADDRESS; ?>
                                            </span>
                                        </address>
                                    </blockquote>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <i class="fa fa-phone fa-fw"></i> <?php echo COMPANY_PHONE; ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <i class="fa fa-fax fa-fw"></i> <?php echo COMPANY_FAX; ?>
                                        </div>
                                        <div class="col-xs-12">
                                            <i class="fa fa-envelope fa-fw"></i> <?php echo CONTACT_EMAIL; ?>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


