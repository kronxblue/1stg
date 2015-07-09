<?php
$supplier_data = $this->supplier_data;
$supplier_list = $this->supplier_list;
print_r($supplier_list);
?>
<div id="addNewAdvertisement" class="col-xs-12">
    <h2 class="page-header">
        Add New Advertisement
    </h2>
    <div class="col-xs-12">
        <form class="container" role="form" action="<?php echo BASE_PATH; ?>supplier/addNew_exec" method="post" id="frmAddSupplier" name="frmAddSupplier">
	    <h3>
                Company Info
            </h3>
            <hr/>
	    <?php if ($supplier_data == FALSE) { ?>
            <div class="row">
		<div class="col-sm-6">
		    <div class="form-group">
			<label for="comp_name">Company Name</label>
			<select class="form-control" id="comp_name" name="comp_name">
			    <option value="">-- Select company --</option>
			    <?php
				    foreach ($supplier_list as $key => $value) {
					    $supplier_id = $value['supplier_id'];
					    $comp_name = $value['comp_name'];
					    echo "<option value='$supplier_id' >$comp_name</option>";
				    }
			    ?>
			</select>

		    </div>
		    <a class="btn btn-primary btn-sm" href="<?php echo BASE_PATH; ?>supplier/addNew">Not in the list? Click here to add...</a>
		</div>
	    </div>
	    <?php } else {?>
            <div class="row">
		<div class="col-sm-4">
		    Company Name : <?php echo $supplier_data['comp_name']; ?>
		</div>
		<div class="col-sm-4">
		    Company Reg. No. : <?php echo $supplier_data['comp_reg_no']; ?>
		</div>
		<div class="col-sm-4">
		    Supplier ID : <?php echo $supplier_data['supplier_id']; ?>
		</div>
	    </div>
	    <?php } ?>
            <hr/>
            <h3>
                Advertisement Details <small>[ This section is important for search engine crawler. ]</small>
            </h3>
            <hr/>

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
        </form>
    </div>
</div>
