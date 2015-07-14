<?php
$categoryList = $this->categoryList;
$countryList = $this->countryList;
$statesList = $this->statesList;
$states = $statesList[0]['states'];
$states = json_decode($states);
$states = get_object_vars($states);

$agentList = $this->agentList;

//CATEGORY
$categoryArr = array();
foreach ($categoryList as $key => $value) {
	$category = $value['category'];
	if (!in_array($category, $categoryArr)) {
		$categoryArr[] = $category;
	}
}
$categoryListFilter = array();
foreach ($categoryArr as $value) {

	foreach ($categoryList as $value2) {
		$id = $value2['id'];
		$cat = $value2['category'];
		$subcat = $value2['subcategory'];

		if ($value == $cat) {
			$categoryListFilter[$value][$id] = $subcat;
		}
	}
}
?>
<div id="addNewSupplier" class="col-xs-12">
    <h2 class="page-header">
        Add New Supplier
    </h2>
    <div class="col-xs-12">
        <form role="form" action="<?php echo BASE_PATH; ?>management/addSupplier_exec" method="post" id="frmAddSupplier" name="frmAddSupplier">
	    <h3>
                Select Agent
            </h3>
            <hr/>
	    <div class="row">
                <div class="col-sm-8">
                    <div class="form-group">
                        <label for="agent_id">Username (Agent ID)</label>
			<select class="form-control" id="agent_id" name="agent_id">
			    <option value="">Select agent...</option>
			    <?php
			    foreach ($agentList as $key3 => $value3) {
				    $agent_id = $value3['agent_id'];
				    $username = $value3['username'];
				    echo "<option value='$agent_id'>$username ($agent_id)</option>";
			    }
			    ?>
			</select>
                    </div>
                </div>
            </div>
	    <hr/>
	    <div id="sect2" class="hidden">
		<h3>
		    Company Info
		</h3>
		<hr/>
		<div class="row">
		    <div class="col-sm-8">
			<div class="form-group">
			    <label for="comp_name">Individual / Company Name *</label>
			    <input type="text" class="form-control" id="comp_name" name="comp_name" placeholder="Client name / company name."/>
			</div>
		    </div>
		    <div class="col-sm-4">
			<div class="form-group">
			    <label for="comp_reg_no">Registration No.</label>
			    <input type="text" class="form-control" id="comp_reg_no" name="comp_reg_no" placeholder="Company registration number." />
			</div>
		    </div>
		</div>
		<div class="row">
		    <div class="col-xs-12">
			<div class="form-group">
			    <label for="comp_address">Address *</label>
			    <input type="text" class="form-control" id="comp_address" name="comp_address" placeholder="Company address." />
			</div>
		    </div>
		</div>
		<div class="row">
		    <div class="col-sm-4">
			<div class="form-group">
			    <label for="comp_postcode">Poscode *</label>
			    <input type="text" class="form-control" id="comp_postcode" name="comp_postcode" placeholder="Address poscode.">
			</div>
		    </div>
		    <div class="col-sm-8">
			<div class="form-group">
			    <label for="comp_state">State *</label>
			    <span class="input-group-select">
				<select class="form-control" style="width: 30%;" id="comp_state" name="comp_state">
				    <option value="">-- Select State --</option>
				    <?php
				    foreach ($states as $key => $value) {
					    echo "<option value='$key'>$value</option>";
				    }
				    ?>
				    <option value="oth">Other</option>
				</select>
				<input type="text" class="form-control" readonly="readonly" style="width: 70%;" id="state_other" name="state_other" value="Select state.">
			    </span>
			</div>
		    </div>
		</div>
		<div class="row">
		    <div class="col-sm-4">
			<div class="form-group">
			    <label for="comp_country">Country *</label>
			    <select class="form-control" id="comp_country" name="comp_country">
				<option value="">-- Select Country --</option>
				<?php
				foreach ($countryList as $value) {
					$countryName = $value['name'];
					$countryCode = $value['code'];
					echo "<option value='$countryCode'>$countryName</option>";
				}
				?>
			    </select>
			</div>
		    </div>
		</div>
		<div class="row">
		    <div class="col-sm-4">
			<div class="form-group">
			    <label for="comp_phone1">Phone 1 *</label>
			    <input type="text" class="form-control" id="comp_phone1" name="comp_phone1" placeholder="Company main phone no.">
			</div>
		    </div>
		    <div class="col-sm-4">
			<div class="form-group">
			    <label for="comp_phone2">Phone 2</label>
			    <input type="text" class="form-control" id="comp_phone2" name="comp_phone2" placeholder="Alternative phone no.">
			</div>
		    </div>
		    <div class="col-sm-4">
			<div class="form-group">
			    <label for="comp_fax">Fax</label>
			    <input type="text" class="form-control" id="comp_fax" name="comp_fax" placeholder="Company fax no.">
			</div>
		    </div>
		</div>
		<hr/>
		<h3>
		    Business Details <small>[ This section is important for whatyouwant.my request engine. ]</small>
		</h3>
		<hr/>
		<div class="row">
		    <div class="col-sm-8">
			<div class="form-group">
			    <label for="website">Website URL</label>
			    <input type="text" class="form-control" id="website" name="website" placeholder="Business website (if any)." />
			</div>
		    </div>
		    <div class="col-sm-4">
			<div class="form-group">
			    <label for="category">Category *</label>
			    <select class="form-control" id="category" name="category">
				<option value="">-- Select Category --</option>
				<?php
				foreach ($categoryListFilter as $key => $value) {
					echo "<option disabled='disabled' style='background-color:#ccc; color:#333;' value=''>$key</option>";
					foreach ($value as $key2 => $value2) {
						echo "<option value='$key2'>$value2</option>";
					}
				}
				?>
			    </select>
			</div>
		    </div>
		    <div class="col-xs-12">
			<div class="form-group">
			    <label for="tag">Keyword Tag * <small>Separate by comma (,)</small></label>
			    <input type="text" class="form-control" id="tag" name="tag" placeholder="Enter keyword that related to client business." />
			</div>
		    </div>
		    <div class="col-xs-12">
			<div class="form-group">
			    <label for="desc">Description *</label>
			    <textarea rows="5" class="form-control" id="desc" name="desc" placeholder="Describe about client business field."></textarea>
			</div>
		    </div>
		</div>
		<hr/>
		<h3>
		    Person In Charge
		</h3>
		<hr/>
		<div class="row">
		    <div class="col-sm-4">
			<div class="form-group">
			    <label for="salutation">Salutation *</label>
			    <select class="form-control" id="salutation" name="salutation">
				<option value="">-- Select --</option>
				<option value="MR." >Mr.</option>
				<option value="MISS." >Miss</option>
				<option value="MRS." >Mrs.</option>
				<option value="MS." >Ms.</option>
				<option value="DR." >Dr.</option>
			    </select>
			</div>
		    </div>
		    <div class="col-sm-8">
			<div class="form-group">
			    <label for="p_fullname">Fullname *</label>
			    <input type="text" class="form-control" id="p_fullname" name="p_fullname" placeholder="Person in charge fullname." />
			</div>
		    </div>
		</div>
		<div class="row">
		    <div class="col-sm-4">
			<div class="form-group">
			    <label for="p_pos">Position / Title</label>
			    <input type="text" class="form-control" id="p_pos" name="p_pos" placeholder="Position in the company.">
			</div>
		    </div>
		    <div class="col-sm-4">
			<div class="form-group">
			    <label for="p_phone">Phone / Office Number</label>
			    <input type="text" class="form-control" id="p_phone" name="p_phone" placeholder="Enter phone no. (eg: +60532127177)">
			</div>
		    </div>
		    <div class="col-sm-4">
			<div class="form-group">
			    <label for="p_mobile">Mobile Number *</label>
			    <input type="text" class="form-control" id="p_mobile" name="p_mobile" placeholder="Enter mobile no. (eg: +60172345678)">
			</div>
		    </div>
		</div>
		<div class="row">
		    <div class="col-sm-4">
			<div class="form-group">
			    <label for="p_gender">Gender *</label>
			    <select id="p_gender" name="p_gender" class="form-control">
				<option value="">Select gender.</option>
				<option value="m">Male</option>
				<option value="f">Female</option>
			    </select>
			</div>
		    </div>
		    <div class="col-sm-8">
			<div class="form-group">
			    <label for="comp_email">Email *</label>
			    <input type="email" class="form-control" id="comp_email" name="comp_email" placeholder="Enter person in charge email." />
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
		<div class="clearfix text-center">
		    <div class="row">
			<div class="col-xs-6">
			    <a href="<?php echo BASE_PATH; ?>supplier" class="col-xs-12 btn btn-danger btn-lg" id="btn_cancel">Cancel</a> 
			</div>
			<div class="col-xs-6">
			    <button type="submit" class="col-xs-12 btn btn-primary btn-lg" id="btn_submit">Submit!</button> 
			</div>
		    </div>
		</div>
		<input type="hidden" class="form-control" id="regdate" name="regdate" value="<?php echo Date('Y-m-d H:i:s'); ?>" />
	    </div>
        </form>
    </div>
</div>
