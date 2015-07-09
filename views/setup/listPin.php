<?php ?>

<div class="col-xs-12">
    <h2 class="page-header">Advertisement Pin List</h2>
    <div class="pinList">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li class="active"><a href="#all" role="tab" data-toggle="tab">View All</a></li>
            <li><a href="#custom" role="tab" data-toggle="tab">Enter Pin</a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane active" id="all">
                <div class="row">
                    <div class="col-xs-12">
                        <form class="alert alert-info small" role="form" action="#" method="post" id="formFilter" name="formFilter">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="col-xs-12">
                                        Sort by:
                                    </div>
                                    <div class="col-sm-12">
                                        <select id="sortby" name="sortby" class="form-control input-sm">
                                            <option value="ORDER BY available_pin DESC">Available Pin</option>
                                            <option value="ORDER BY available_pin DESC">Highest first</option>
                                            <option value="ORDER BY available_pin ASC">Lowest first</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div id="pinList" class="table-responsive" data-url="<?php echo BASE_PATH; ?>setup/getListPin" data-page="1">
                            <!--LIST WILL BE GENERATE USING JSON-->
                            <div class="col-xs-12 text-center">
                                <i class="fa fa-spinner fa-spin fa-3x"></i>
                                <br/>
                                <br/>
                                <p>
                                    Generating downline list. Please wait...
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="custom">
                <div class="row">
                    <div class="col-xs-12">
                        <form class="alert alert-info small" role="form" action="<?php echo BASE_PATH; ?>setup/checkPin" method="post" id="frmCheckPin" name="frmCheckPin">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon">Enter Pin</span>
                                        <input id="pin" name="pin" type="text" class="form-control" placeholder="Please enter advertisement pin.">
                                        <span class="input-group-btn">
                                            <button class="btn btn-primary" type="submit">Check Pin</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="alert small" role="alert" id="alert">
                            <button type="button" class="close">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Close</span>
                            </button>
                            <div id="alert-body"></div>
                        </div>
                        <div id="pinResult" class="table-responsive">
                            <!--LIST WILL BE GENERATE USING JSON-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
