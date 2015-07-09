<?php
$monthList = $this->monthList;
$downlineListPB = $this->downlineListPB;
$downlineListAA = $this->downlineListAA;
$downlineListED = $this->downlineListED;
$downlineListEP = $this->downlineListEP;

$header_color = "active";
?>
<div class="col-xs-12">
    <h2 class="page-header">
        My Network
    </h2>
    <div class="col-xs-12">
        <h3>
            Summary
        </h3>
        <div class="table-responsive">
            <table class="table table-bordered table-condensed">
                <thead>
                    <tr class="<?php echo $header_color; ?>">
                        <th rowspan="2" colspan="2"></th>
                        <th colspan="12" class="text-center">MONTH</th>
                    </tr>
                    <tr  class="<?php echo $header_color; ?>">
                        <?php
                        foreach ($monthList as $value) {
                            echo "<th class='text-center'>$value</th>";
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th rowspan="4" class="text-center <?php echo $header_color; ?>" style="vertical-align: middle;">
                            ACCOUNT
                            <br/>
                            TYPE
                        </th>
                        <td class="<?php echo $header_color; ?>">Publisher</td>
                        <?php
                        foreach ($downlineListPB as $value) {
                            echo "<td class='text-center'>$value</td>";
                        }
                        ?>
                    </tr>
                    <tr>
                        <td class="<?php echo $header_color; ?>">Affiliate Agent</td>
                        <?php
                        foreach ($downlineListAA as $value) {
                            echo "<td class='text-center'>$value</td>";
                        }
                        ?>
                    </tr>
                    <tr>
                        <td class="<?php echo $header_color; ?>">Executive Dealer</td>
                        <?php
                        foreach ($downlineListED as $value) {
                            echo "<td class='text-center'>$value</td>";
                        }
                        ?>
                    </tr>
                    <tr>
                        <td class="<?php echo $header_color; ?>">Executive Partner</td>
                        <?php
                        foreach ($downlineListEP as $value) {
                            echo "<td class='text-center'>$value</td>";
                        }
                        ?>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-xs-12">
        <h3>
            Downline List Sponsored
            <input type="hidden" id="p" name="p" value="<?php echo isset($_REQUEST['p']) ? $_GET['p'] : 1; ?>" />

        </h3>
        <div id="searchDownline" class="row hidden">
            <div class="col-sm-4">
                <div class="input-group input-group-sm">
                    <span class="input-group-addon"><i class="fa fa-search fa-fw"></i></span>
                    <input type="text" id="s" name="s" data-url="<?php echo BASE_PATH; ?>mynetwork?s=" class="form-control" placeholder="Search fullname / username" value="<?php echo isset($_REQUEST['s']) ? $_GET['s'] : NULL; ?>">
                    <span class="input-group-btn">
                        <?php
                        echo isset($_REQUEST['s']) ? "<a id='btnClear' class='btn btn-danger' href='" . BASE_PATH . "mynetwork'>Clear search <i class='fa fa-times fa-fw'></i></a>" : NULL;
                        ?>
                        <button id="btnSearch" class="btn btn-default" type="button">Go!</button>
                    </span>
                </div>

            </div>
        </div>
        <br/>
        <div id="downlineList" data-url="<?php echo BASE_PATH; ?>mynetwork/downlineList" class="table-responsive">
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
