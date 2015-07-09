<div class="col-xs-12">



    <?php
    $userlists = $this->userlists;
    $paymentlists = $this->paymentlists;
    $aid = array();
    $pid = array();

    foreach ($userlists as $key => $value) {
	    $aid[] = $value['agent_id'];
    }
    foreach ($paymentlists as $key2 => $value2) {
	    $pid[] = $value2['agent_id'];
    }

    foreach ($pid as $key3 => $value3) {
	    if (!in_array($value3, $aid)) {
		    print_r($value3 . "<br/>");
	    }
    }
    ?>
</div>
