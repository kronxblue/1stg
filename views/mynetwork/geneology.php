<?php
$geneologyError = $this->_geneologyError;
$errorMsg = $this->_errorMsg;

$topUser = $this->topUser;
$midUser = $this->midUser;
$bottomUser = $this->bottomUser;

$sponsordata = $this->sponsorData;
$userdata = $this->_userData;

$autoPlacement_ID = $this->autoPlacement_ID;

$totalAgentsArr = $this->totalAgentsArr;
?>
<div class="col-xs-12">
    <h2 class="page-header">
        Geneology
    </h2>
    <div class="col-xs-12">
        <h3>
            Summary
        </h3>
        <div class="table-responsive">
            <table class="table table-bordered table-condensed">
                <thead>
                    <tr class="active">
                        <th class="text-center" rowspan="2" width="150"></th>
                        <th class="text-center" colspan="10">Tier</th>
                        <th class="text-center" rowspan="2" width="150">Total</th>
                    </tr>
                    <tr class="text-center active">
                        <th class="text-center">1</th>
                        <th class="text-center">2</th>
                        <th class="text-center">3</th>
                        <th class="text-center">4</th>
                        <th class="text-center">5</th>
                        <th class="text-center">6</th>
                        <th class="text-center">7</th>
                        <th class="text-center">8</th>
                        <th class="text-center">9</th>
                        <th class="text-center">10</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-center">
                        <th class="active text-center">Total Agents</th>
                        <?php
                        $totalAgents = 0;
                        foreach ($totalAgentsArr as $value) {
                            echo "<td>" . number_format($value) . "</td>";
                            $totalAgents = $totalAgents + $value;
                        }

                        echo "<td>" . number_format($totalAgents) . "</td>";
                        ?>

                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div id="geneology" class="col-xs-12">
        <h3>
            Geneology Tree
        </h3>
        <div class="panel panel-default ">
            <div class="panel-body">
                <div class="row text-center">
                    <div class="col-sm-6">
                        <h4>NETWORK: <?php echo strtoupper($userdata['username']); ?></h4>
                    </div>
                    <div class="col-sm-6">
                        <h4>SPONSOR: <?php echo ($sponsordata != NULL) ? strtoupper($sponsordata['username']) : "NO SPONSOR"; ?></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 text-center">
                <div class="alert alert-danger" role="alert" id="alert" data-cond="<?php echo $geneologyError; ?>" >
                    <button type="button" class="close">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <div id="alert-body"><?php echo $errorMsg; ?></div>
                </div>
                <a class="btn btn-primary" style="padding: 10px 6px; max-width: 300px;" href="<?php echo BASE_PATH; ?>mynetwork/addagent?lv1=<?php echo $autoPlacement_ID; ?>"><i class="fa fa-plus fa-fw"></i> Add New Agent (Auto Placement)</a>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-xs-12 table-responsive">
                <table class="table table-condensed table-bordered col-xs-12 text-center">
                    <tbody>
                        <tr>
                            <td colspan="10" class="active">
                                <div class="col-sm-2 col-sm-offset-5 col-xs-4 col-xs-offset-4">
                                    <a class="btn thumbnail disabled" href="#">
                                        <img src="<?php echo $topUser['image']; ?>" class="img-thumbnail img-responsive" />
                                        <div class="caption small">
                                            <p>
                                                <?php echo $topUser['username']; ?>
                                                <br/>
                                                <?php echo $topUser['agent_id']; ?>
                                            </p>
                                        </div>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="10"><img src="<?php echo IMAGES_PATH; ?>geneology-tree-1.png" width="85%" /></td>
                        </tr>
                        <tr>
                            <td colspan="10" class="active">
                                <?php
                                foreach ($midUser as $key => $value) {
                                    if ($value != NULL) {
                                        ?>

                                        <div class="col-xs-2 <?php echo ($key == 0) ? "col-xs-offset-1" : NULL; ?>">
                                            <a class="btn btn-success" href="<?php echo BASE_PATH; ?>mynetwork/geneology?top=<?php echo $value['agent_id']; ?>">
                                                <div class="thumbnail">
                                                    <img src="<?php echo $value['image']; ?>" class="img-thumbnail img-responsive" />
                                                    <div class="caption">
                                                        <p>
                                                            <?php echo $value['username']; ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>

                                        <?php
                                    } else {
                                        ?>
                                        <div class="col-xs-2 <?php echo ($key == 0) ? "col-xs-offset-1" : NULL; ?>">
                                            <a class="btn btn-danger" href="<?php echo BASE_PATH; ?>mynetwork/addagent?lv1=<?php echo $topUser['agent_id']; ?>">
                                                <div class="thumbnail">
                                                    <img src="<?php echo IMAGES_PATH; ?>user-default.png" class="img-thumbnail img-responsive" />
                                                    <div class="caption">
                                                        <p>
                                                            <i class="fa fa-plus-square fa-fw fa-2x"></i>
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="10">
                                <table width="100%">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <img src="<?php echo IMAGES_PATH; ?>geneology-tree-2-1.png" width="100%" />
                                            </td>
                                            <td>
                                                <img src="<?php echo IMAGES_PATH; ?>geneology-tree-2-2.png" width="100%" />
                                            </td>
                                            <td>
                                                <img src="<?php echo IMAGES_PATH; ?>geneology-tree-2-3.png" width="100%" />
                                            </td>
                                            <td>
                                                <img src="<?php echo IMAGES_PATH; ?>geneology-tree-2-4.png" width="100%" />
                                            </td>
                                            <td>
                                                <img src="<?php echo IMAGES_PATH; ?>geneology-tree-2-5.png" width="100%" />
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>

                            <?php
                            foreach ($midUser as $key => $value) {
                                ?>
                                <td colspan="2" class="col-margin-bottom active">
                                    <?php
                                    foreach ($bottomUser as $key2 => $value2) {

                                        if ($key2 == $key) {

                                            foreach ($value2 as $key3 => $value3) {
                                                if ($value3 != NULL) {
                                                    ?>
                                                    <div class="col-md-6 col-xs-12">
                                                        <a class="btn btn-success" href="<?php echo BASE_PATH; ?>mynetwork/geneology?top=<?php echo $value3['agent_id']; ?>">
                                                            <div class="thumbnail">
                                                                <img src="<?php echo $value3['image']; ?>" class="img-thumbnail img-responsive" />
                                                                <div class="caption">
                                                                    <p>
                                                                        <?php echo $value3['username']; ?>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <div class="col-md-6 col-xs-12">
                                                        <a class="btn btn-danger <?php echo ($value == NULL) ? "disabled" : NULL; ?>" href="<?php echo BASE_PATH; ?>mynetwork/addagent?lv1=<?php echo $value['agent_id']; ?>">
                                                            <div class="thumbnail">
                                                                <img src="<?php echo IMAGES_PATH; ?>user-default.png" class="img-thumbnail img-responsive" />
                                                                <div class="caption">
                                                                    <p>
                                                                        <i class="fa fa-plus-square fa-fw fa-2x"></i>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                        }
                                    }
                                    ?>

                                    <?php ?>

                                </td>

                                <?php
                            }
                            ?>

<!--                            <td colspan="2" class="col-margin-bottom active">
                                <div class="col-md-6 col-xs-12">
                                    <a class="btn btn-success" href="#">
                                        <div class="thumbnail">
                                            <img src="<?php echo IMAGES_PATH; ?>user-default.png" class="img-thumbnail img-responsive" />
                                            <div class="caption">
                                                <p>
                                                    aloongjerr
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <a class="btn btn-danger" href="#">
                                        <div class="thumbnail">
                                            <img src="<?php echo IMAGES_PATH; ?>user-default.png" class="img-thumbnail img-responsive" />
                                            <div class="caption">
                                                <p>
                                                    <i class="fa fa-plus-square fa-fw fa-2x"></i>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <a class="btn btn-danger" href="#">
                                        <div class="thumbnail">
                                            <img src="<?php echo IMAGES_PATH; ?>user-default.png" class="img-thumbnail img-responsive" />
                                            <div class="caption">
                                                <p>
                                                    <i class="fa fa-plus-square fa-fw fa-2x"></i>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <a class="btn btn-danger" href="#">
                                        <div class="thumbnail">
                                            <img src="<?php echo IMAGES_PATH; ?>user-default.png" class="img-thumbnail img-responsive" />
                                            <div class="caption">
                                                <p>
                                                    <i class="fa fa-plus-square fa-fw fa-2x"></i>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <a class="btn btn-danger" href="#">
                                        <div class="thumbnail">
                                            <img src="<?php echo IMAGES_PATH; ?>user-default.png" class="img-thumbnail img-responsive" />
                                            <div class="caption">
                                                <p>
                                                    <i class="fa fa-plus-square fa-fw fa-2x"></i>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </td>
                            <td colspan="2" class="col-margin-bottom">
                                <div class="col-md-6 col-xs-12">
                                    <a class="btn btn-danger" href="#">
                                        <div class="thumbnail">
                                            <img src="<?php echo IMAGES_PATH; ?>user-default.png" class="img-thumbnail img-responsive" />
                                            <div class="caption">
                                                <p>
                                                    <i class="fa fa-plus-square fa-fw fa-2x"></i>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <a class="btn btn-danger" href="#">
                                        <div class="thumbnail">
                                            <img src="<?php echo IMAGES_PATH; ?>user-default.png" class="img-thumbnail img-responsive" />
                                            <div class="caption">
                                                <p>
                                                    <i class="fa fa-plus-square fa-fw fa-2x"></i>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <a class="btn btn-danger" href="#">
                                        <div class="thumbnail">
                                            <img src="<?php echo IMAGES_PATH; ?>user-default.png" class="img-thumbnail img-responsive" />
                                            <div class="caption">
                                                <p>
                                                    <i class="fa fa-plus-square fa-fw fa-2x"></i>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <a class="btn btn-danger" href="#">
                                        <div class="thumbnail">
                                            <img src="<?php echo IMAGES_PATH; ?>user-default.png" class="img-thumbnail img-responsive" />
                                            <div class="caption">
                                                <p>
                                                    <i class="fa fa-plus-square fa-fw fa-2x"></i>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <a class="btn btn-danger" href="#">
                                        <div class="thumbnail">
                                            <img src="<?php echo IMAGES_PATH; ?>user-default.png" class="img-thumbnail img-responsive" />
                                            <div class="caption">
                                                <p>
                                                    <i class="fa fa-plus-square fa-fw fa-2x"></i>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </td>
                            <td colspan="2" class="col-margin-bottom active">
                                <div class="col-md-6 col-xs-12">
                                    <a class="btn btn-danger" href="#">
                                        <div class="thumbnail">
                                            <img src="<?php echo IMAGES_PATH; ?>user-default.png" class="img-thumbnail img-responsive" />
                                            <div class="caption">
                                                <p>
                                                    <i class="fa fa-plus-square fa-fw fa-2x"></i>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <a class="btn btn-danger" href="#">
                                        <div class="thumbnail">
                                            <img src="<?php echo IMAGES_PATH; ?>user-default.png" class="img-thumbnail img-responsive" />
                                            <div class="caption">
                                                <p>
                                                    <i class="fa fa-plus-square fa-fw fa-2x"></i>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <a class="btn btn-danger" href="#">
                                        <div class="thumbnail">
                                            <img src="<?php echo IMAGES_PATH; ?>user-default.png" class="img-thumbnail img-responsive" />
                                            <div class="caption">
                                                <p>
                                                    <i class="fa fa-plus-square fa-fw fa-2x"></i>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <a class="btn btn-danger" href="#">
                                        <div class="thumbnail">
                                            <img src="<?php echo IMAGES_PATH; ?>user-default.png" class="img-thumbnail img-responsive" />
                                            <div class="caption">
                                                <p>
                                                    <i class="fa fa-plus-square fa-fw fa-2x"></i>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <a class="btn btn-danger" href="#">
                                        <div class="thumbnail">
                                            <img src="<?php echo IMAGES_PATH; ?>user-default.png" class="img-thumbnail img-responsive" />
                                            <div class="caption">
                                                <p>
                                                    <i class="fa fa-plus-square fa-fw fa-2x"></i>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </td>
                            <td colspan="2" class="col-margin-bottom">
                                <div class="col-md-6 col-xs-12">
                                    <a class="btn btn-danger" href="#">
                                        <div class="thumbnail">
                                            <img src="<?php echo IMAGES_PATH; ?>user-default.png" class="img-thumbnail img-responsive" />
                                            <div class="caption">
                                                <p>
                                                    <i class="fa fa-plus-square fa-fw fa-2x"></i>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <a class="btn btn-danger" href="#">
                                        <div class="thumbnail">
                                            <img src="<?php echo IMAGES_PATH; ?>user-default.png" class="img-thumbnail img-responsive" />
                                            <div class="caption">
                                                <p>
                                                    <i class="fa fa-plus-square fa-fw fa-2x"></i>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <a class="btn btn-danger" href="#">
                                        <div class="thumbnail">
                                            <img src="<?php echo IMAGES_PATH; ?>user-default.png" class="img-thumbnail img-responsive" />
                                            <div class="caption">
                                                <p>
                                                    <i class="fa fa-plus-square fa-fw fa-2x"></i>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <a class="btn btn-danger" href="#">
                                        <div class="thumbnail">
                                            <img src="<?php echo IMAGES_PATH; ?>user-default.png" class="img-thumbnail img-responsive" />
                                            <div class="caption">
                                                <p>
                                                    <i class="fa fa-plus-square fa-fw fa-2x"></i>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <a class="btn btn-danger" href="#">
                                        <div class="thumbnail">
                                            <img src="<?php echo IMAGES_PATH; ?>user-default.png" class="img-thumbnail img-responsive" />
                                            <div class="caption">
                                                <p>
                                                    <i class="fa fa-plus-square fa-fw fa-2x"></i>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </td>
                            <td colspan="2" class="col-margin-bottom active">
                                <div class="col-md-6 col-xs-12">
                                    <a class="btn btn-danger" href="#">
                                        <div class="thumbnail">
                                            <img src="<?php echo IMAGES_PATH; ?>user-default.png" class="img-thumbnail img-responsive" />
                                            <div class="caption">
                                                <p>
                                                    <i class="fa fa-plus-square fa-fw fa-2x"></i>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <a class="btn btn-danger" href="#">
                                        <div class="thumbnail">
                                            <img src="<?php echo IMAGES_PATH; ?>user-default.png" class="img-thumbnail img-responsive" />
                                            <div class="caption">
                                                <p>
                                                    <i class="fa fa-plus-square fa-fw fa-2x"></i>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <a class="btn btn-danger" href="#">
                                        <div class="thumbnail">
                                            <img src="<?php echo IMAGES_PATH; ?>user-default.png" class="img-thumbnail img-responsive" />
                                            <div class="caption">
                                                <p>
                                                    <i class="fa fa-plus-square fa-fw fa-2x"></i>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <a class="btn btn-danger" href="#">
                                        <div class="thumbnail">
                                            <img src="<?php echo IMAGES_PATH; ?>user-default.png" class="img-thumbnail img-responsive" />
                                            <div class="caption">
                                                <p>
                                                    <i class="fa fa-plus-square fa-fw fa-2x"></i>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <a class="btn btn-danger" href="#">
                                        <div class="thumbnail">
                                            <img src="<?php echo IMAGES_PATH; ?>user-default.png" class="img-thumbnail img-responsive" />
                                            <div class="caption">
                                                <p>
                                                    <i class="fa fa-plus-square fa-fw fa-2x"></i>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </td>-->
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
