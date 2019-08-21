<?php echo form_open('materials/tenderRegister/'.$slug,' id="tenderRegister_form"'); ?>
	<div class="row">

		<div class="col-md-6 col-md-offset-3   col-xs-10 col-xs-offset-1   col-sm-8 col-sm-offset-2   col-lg-4 col-lg-offset-4">

			<h1 class="text-center">Send Message</h1>

			<p  class="text-center"> <?php echo validation_errors(); ?></p>

			<div class="form-group">
				<label>Tender Item</label>
				<div class="input-group">
					<p class="form-control-static"><?= $material_title; ?></p>
				</div>
			</div>

			<div class="form-group">
				<label>Date of Submission</label>
				<div class="input-group">
					<p class="form-control-static"><?php echo date("d(D) - M - Y"); ?></p>
				</div>
			</div>

			<div class="row">

				<div class="col-xs-6 col-sm-8 col-md-8">
					<div class="form-group">
						<label for="inpuFname">Quantity</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-align-justify"></i></span>
							<input type="number" value="1" class="form-control" min="1" name="tender_quantity">
						</div>
					</div>
				</div>

				<div class="col-xs-6 col-sm-4 col-md-4">
					<div class="form-group">

						<label for="sel1">Select Measurement:</label>
						<select class="form-control" id="sel1" name="tender_quantity_unit">
							<option value="Kilograms">Kilograms</option>
							<option value="Pounds">Pounds</option>
							<option value="Quintals">Quintals</option>
							<option value="Litres">Litres</option>
							<option value="Gallons">Gallons</option>
							<option value="Units">Units</option>
						</select>

					</div>
				</div>

			</div>



			<div class="row">
				<div class="col-xs-6 col-sm-8 col-md-8">
					<div class="form-group">
						<label>Date of Expiry</label>
						<div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
							<input type="date" class="form-control" name="doe" min="<?php echo date("Y-m-d",strtotime('tomorrow')); ?>" required/>
						</div>
					</div>
				</div>
				<div class="col-xs-6 col-sm-4 col-md-4">
					<div class="form-group">
						<label>Time of Expiry</label>
						<div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
							<input type="time" class="form-control" name="toe" value="<?php echo date("H:i"); ?>" required/>
						</div>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label>Deilvery Location</label>
				<!-- <div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
					<input type="email" class="form-control" name="email" placeholder="Email" required/>
				</div> -->
				<?php foreach($addresses_arr as $address_arr) : ?>
				<div class="radio well well-sm">								<!-- NO ECHO vvvvvvvvvvvv -->
					<label>
						<input type="radio" name="deliveryLocation" id="deliveryLocation1" value="<?php echo $address_arr['m_address_dict_id'] ?>" > 
							<h4 class="h3-margin-top-change">
								<?php echo ($address_arr['building_no']." , ".$address_arr['street']." , ".$address_arr['city']." , ".$address_arr['state']." , ".$address_arr['country'].". Pincode : ".$address_arr['pincode']); ?>
							</h4>
					</label>
				</div>
				<?php endforeach; ?>
				<div class="text-center well well-sm">
					<a href="<?php echo base_url(); ?>userdashboard"> Manage Address Book </a>
				</div>

			</div>

			<div class="form-group">
				<label>Estimated Price</label>
				<div class="input-group"> 
					<span class="input-group-addon">₹</span>
					<input type="number" class="form-control" name="estimated-price" value="0" min="0" required/>
				</div>
			</div> 

			<div class="form-group">
				<label>Extra Requirements / Comments (Optional)</label>
				<div class="input-group"> 
					<span class="input-group-addon"><i class="glyphicon glyphicon-comment"></i></span>
					<textarea class="form-control" rows="5" id="comments" placeholder="Max 300 characters" maxlength="300" name="extra_info"></textarea>
				</div>
			</div>

            <!-- <label>Full name</label>
            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group">
                        <div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input type="text" class="form-control" name="firstName" placeholder="First name" />
                        </div>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input type="text" class="form-control" name="lastName" placeholder="Last name" />
                        </div>
                    </div>
                </div>
            </div>


			<div class="form-group">
				<label>Email</label>
				<div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
					<input type="email" class="form-control" name="email" placeholder="Email" required/>
				</div>
			</div>
			<div class="form-group">
				<label>Username</label>
				<div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
					<input type="text" class="form-control" name="username" placeholder="Username" required/>
				</div>
			</div>
			<div class="form-group">
				<label>Password</label>
				<div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
					<input type="password" class="form-control" name="password" placeholder="Password" required/>
				</div>
			</div>
			<div class="form-group">
				<label>Confirm Password</label>
				<div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
					<input type="password" class="form-control" name="password2" placeholder="Confirm Password" required/>
				</div>
			</div> -->

			<button type="submit" class="btn btn-success btn-block">Submit</button>

		</div>

	</div>
	
<?php echo form_close(); ?>