<?php
$supplier_data = $this->supplier_data;

if ($supplier_data['comp_state'] == "oth") {
	$states = $supplier_data['state_other'];
} else {
	$states = user::getStates($supplier_data['comp_country']);
	$states = $states[0]['states'];
	$states = json_decode($states);
	$states = get_object_vars($states);

	foreach ($states as $key => $value) {
		if ($supplier_data['comp_state'] == $key) {
			$comp_states = $value;
		}
	}
}

$countryList = user::getCountry();
foreach ($countryList as $key2 => $value2) {
	if ($value2['code'] == $supplier_data['comp_country']) {
		$country = $value2['name'];
	}
}

$categoryList = user::getCategory();
foreach ($categoryList as $key3 => $value3) {
	if ($supplier_data['category'] == $value3['id']) {
		$category = $value3['category'] . " - " . $value3['subcategory'];
	}
}


$header_color = "active";
?>
<div id="supplierDetails" class="col-xs-12">
    <h2 class="page-header">
        Supplier Details 
    </h2>
    <div class="container">
        <h3>
	    <?php echo $supplier_data['comp_name']; ?> <a class="btn btn-primary btn-sm pull-right" href="<?php echo BASE_PATH; ?>supplier"><i class="fa fa-fw fa-angle-left"></i> Back</a>
        </h3>
	<hr>
	<div class="col-sm-12 bg-info">
	    <b>COMPANY INFO</b>
	</div>
	<div class="col-sm-6">
	    Supplier ID : #<?php echo $supplier_data['supplier_id']; ?>
	</div>
	<div class="col-sm-6">
	    Registration No. : <?php echo $supplier_data['comp_reg_no']; ?>
	</div>
	<div class="col-sm-12">
	    Address :<br/> <?php echo $supplier_data['comp_address']; ?>
	</div>
	<div class="col-sm-4">
	    Postcode : <?php echo $supplier_data['comp_postcode']; ?>
	</div>
	<div class="col-sm-4">
	    State : <?php echo $comp_states; ?>
	</div>
	<div class="col-sm-4">
	    Country : <?php echo $country; ?>
	</div>
	<div class="col-sm-4">
	    Phone 1 : <?php echo $supplier_data['comp_phone1']; ?>
	</div>
	<div class="col-sm-4">
	    Phone 2 : <?php echo ($supplier_data['comp_phone2'] != NULL) ? $supplier_data['comp_phone2'] : "-"; ?>
	</div>
	<div class="col-sm-4">
	    Fax : <?php echo ($supplier_data['comp_fax'] != NULL) ? $supplier_data['comp_fax'] : "-"; ?>
	</div>
	<div class="col-sm-12 bg-info">
	    <b>BUSINESS DETAILS</b>
	</div>
	<div class="col-sm-6">
	    Website URL : <?php echo $supplier_data['website']; ?>
	</div>
	<div class="col-sm-6">
	    Category : <?php echo $category; ?>
	</div>
	<div class="col-sm-12">
	    Keyword Tag :<br/> <?php echo $supplier_data['tag']; ?>
	</div>
	<div class="col-sm-12">
	    Description :<br/> <?php echo $supplier_data['desc']; ?>
	</div>
	<div class="col-sm-12 bg-info">
	    <b>PERSON IN CHARGE</b>
	</div>
	<div class="col-sm-6">
	    Name : <?php echo $supplier_data['salutation'] . " " . $supplier_data['p_fullname']; ?>
	</div>
	<div class="col-sm-6">
	    Position : <?php echo $supplier_data['p_pos']; ?>
	</div>
	<div class="col-sm-4">
	    Gender : <?php echo ($supplier_data['p_gender'] == "m") ? "Male" : "Female"; ?>
	</div>
	<div class="col-sm-4">
	    Office Phone : <?php echo ($supplier_data['p_phone'] != NULL) ? $supplier_data['p_phone'] : "-"; ?>
	</div>
	<div class="col-sm-4">
	    Mobile Phone : <?php echo $supplier_data['p_mobile']; ?>
	</div>
	<div class="col-sm-12">
	    Contact Email : <?php echo $supplier_data['comp_email']; ?>
	</div>

    </div>
</div>
