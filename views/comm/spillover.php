<?php
$monthList = $this->monthList;
?>

<div class="col-xs-12">
    <h2 class="page-header">
        Spillover Commission <a class="btn btn-primary btn-sm pull-right" href="<?php echo BASE_PATH; ?>comm">Back to Summary</a>
        <input type="hidden" id="type" name="type" value="Spillover" />
        <input type="hidden" id="p" name="p" value="<?php echo isset($_REQUEST['p']) ? $_GET['p'] : 1; ?>" />
    </h2>
    <div class="col-xs-12">
        <div id="filterMonth" class="row form-horizontal">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="col-sm-3 col-md-2 control-label" for="f">Filter :</label>
                    <div class="col-sm-7 col-md-6">
                        <select class="form-control" id="f" name="f" data-url="<?php echo BASE_PATH; ?>comm/spillover">
                            <option value="">Filter by month</option>
                            <?php
                            foreach ($monthList as $value) {
                                $code = date("Y-m", strtotime($value));

                                if (isset($_REQUEST['f'])) {
                                    $f = $_GET['f'];
                                    if ($f == $code) {
                                        echo "<option selected='selected' value='$code' >$value</option>";
                                    } else {
                                        echo "<option value='$code' >$value</option>";
                                    }
                                } else {
                                    echo "<option value='$code' >$value</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br/>
    <br/>
    <div class="col-xs-12">
        <div id="spilloverCommission" data-url="<?php echo BASE_PATH; ?>comm/getCommissionStatement" class="table-responsive">
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