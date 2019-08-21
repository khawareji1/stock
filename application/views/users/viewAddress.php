
<?php echo form_open('users/editAddress/'.($address_arr['add_id']),' id="address_form"'); ?>
    <div class="row">

        <div class="col-md-4 col-md-offset-4  col-sm-4 col-sm-offset-4 col-xs-10 col-xs-offset-1">

        <h1 class="text-center"><?= $title; ?></h1>

            <p  class="text-center"> <?php echo validation_errors(); ?></p>



            <div class="form-group">
                <label>Building/Flat No: </label>
                    <input type="text" class="form-control" id="buildno" name="buildno" maxlength="24" value="<?php echo ($address_arr['building_no'])?>" required/>
            </div>

            <div class="form-group">
                <label>Street: </label>
                <input class="form-control" type="text" id="street" name="street" placeholder="Max 100 characters" maxlength="100" value="<?php echo ($address_arr['street'])?>"/>

            </div>

            <div class="form-group">
                <label>Pincode No: </label>
                    <input type="number" class="form-control" id="pincode" name="pincode"  min="100000" max="999999" value="<?php echo ($address_arr['pincode'])?>" required/>
            </div>

            <div class="form-group">
                <label>Landmark (Optional): </label>
                    <input type="text" class="form-control" id="landmark" name="landmark" maxlength="49" value="<?php echo ($address_arr['land_mark'])?>" />
            </div>

            <div class="form-group">
                <label>State: </label>
                <select class="form-control" id="listBox" name="listBox" maxlength="24" onchange='selct_district(this.value)' required></select>
            </div>

            <div class="form-group">
                <label>City: </label>
                <select class="form-control" id='secondlist' maxlength="29" name="secondlist" required></select>
            </div>

            <div class="form-group">
                <label>Country: </label>
                <input type="text" class="form-control" value="India" id="country" name="country" data-toggle="popover" data-trigger="hover" data-content="Only available in India now." readonly="readonly" value="<?php echo ($address_arr['country'])?>"/>
            </div>




            <div class="row">
                <div class="col-md-6">
                    <a class="btn btn-default btn-block" href="<?php echo base_url(); ?>userdashboard">Go Back</a>
                </div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-success btn-block">Submit</button>
                </div>
            </div>

        </div>

    </div>
    
<?php echo form_close(); ?>