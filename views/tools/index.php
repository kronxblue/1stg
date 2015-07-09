<?php
$data = $this->tools;
?>
<div id="tools" class="col-xs-12">
    <h2 class="page-header">
        1STG Tools
    </h2>
    <div class="col-xs-12">
        <div class="table-responsive">
            <table class="table table-bordered table-condensed">
                <thead>
                    <tr class="active">
                        <th width="80" class="text-center">No.</th>
                        <th class="text-center">Filename</th>
                        <th width="180" class="text-center">File Type</th>
                        <th width="180" class="text-center">Last Update</th>
                        <th width="180" class="text-center">Download Count</th>
                        <th width="180" class="text-center">Action </th>
                    </tr>

                </thead>
                <tbody>
		    <?php
		    $x = count($data);

		    if ($x == 0) {
			    
		    } else {
			    $i = 1;
			    foreach ($data as $key => $value) {

				    $date = date("H:i:s d M Y", strtotime($value['lastupdate']));

				    echo "<tr class='text-center'>";
				    echo "<td>$i</td>";
				    echo "<td>" . $value['filename'] . "<i class='fa fa-question-circle fa-fw toolsDesc' data-placement='bottom' title='" . $value['desc'] . "'></i></td>";
				    echo "<td>" . $value['filetype'] . "</td>";
				    echo "<td>$date</td>";
				    echo "<td>" . $value['dcount'] . "</td>";
				    echo "<td><a href='" . BASE_PATH . "tools/download' class='download' data-id='" . $value['id'] . "'>Download</a></td>";
				    echo "</tr>";
				    $i++;
			    }
		    }
		    ?>
		</tbody>
            </table>
        </div>
    </div>

</div>
