<div class="container"> 
    <h2> <?= $title ?> </h2>
</div>

<?php
function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}
?>


<div id="tabnav" class="tabnav">

	<div class="container">
		<ul class="nav nav-tabs nav-justified">
			<li class="active"><a data-toggle="tab" href="#profile"><b>Profile</b></a></li>
			<li><a data-toggle="tab" href="#messages"><b>Messages</b></a></li>
			<li><a data-toggle="tab" href="#address"><b>Address</b></a></li>
			<li><a data-toggle="tab" href="#materials"><b>Materials</b></a></li>
			<!-- <li><a data-toggle="tab" href="#menu2">My Storage</a></li>
			<li><a data-toggle="tab" href="#menu3">My Booking</a></li> -->
		</ul>

		<div class="tab-content">

			<!-- ========================= PROFILE SECTION ========================= -->

			<div id="profile" class="tab-pane fade in active">
				<div class="row">
					
					<div class="col-md-6 img-align-center">
					<img class="img-circle" src="<?php echo asset_url().'images/Profile_Pic/'.$userDetails['v_profile_pic'] ?>" alt="Image not found" onerror="this.onerror=null;this.src='<?php echo asset_url().'images/web-req/noimg.png' ?>';" width="200" height="200" />

					</div>
					
					<div class="col-md-6">
						<div class="well">
							
							<h3><b>Name</b> : <?php echo($userDetails['v_firstname']." ".$userDetails['v_lastname']) ?></h3>
							<h3><b>Email</b> : <?php echo($userDetails['v_email']) ?></h3>
							<h3><b>Status</b> : <?php echo($userDetails['v_status']) ?></h3>
							<?php if($userDetails['v_org_name']):?>
								<h3><b>Organisation</b> : <?php echo($userDetails['v_org_name']); ?></h3>
							<?php endif;?>
							<?php if($userDetails['v_website']):?>
								<h3><b>Website</b> : <a href="<?php echo($userDetails['v_website']); ?>" target="_blank">Click Here</a> </h3>
							<?php endif;?>
							<?php if($userDetails['v_exprt_mthd']):?>
								<h3><b>Export Method</b> : <?php echo($userDetails['v_exprt_mthd']); ?></h3>
							<?php endif;?>
							<br>
							<!-- <button type="button" class="btn btn-primary btn-lg btn-block login-button" data-toggle="modal" data-target="#editProModal" >Edit</button> -->

						</div>
					</div>

					<div class="btn-group btn-group-justified">
						<div class="btn-group">
							<button type="button" class="btn btn-info" data-toggle="modal" data-target="#changeProfilePicModal">Change Profile Picture</button>
						</div>
						<div class="btn-group">
							<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editProModal">Edit Details</button>
						</div>
						<div class="btn-group">
							<button type="button" class="btn btn-default" data-toggle="modal" data-target="#changePassModal">Change Password</button>
						</div>
					</div> 

					<!-- editPro Modal -->
					<div class="modal fade" id="editProModal" role="dialog">
						<div class="modal-dialog">
							<!-- Add Modal content-->
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Edit User Details</h4>
								</div>
								<div class="modal-body">
									
									<?php echo form_open('vendors/editUserDetails'); ?>
										<div class="row">

											<div class="col-md-8 col-md-offset-2">

												<p  class="text-center"> <?php echo validation_errors(); ?></p>



												<label>Full name</label>
												<div class="row">
													<div class="col-xs-6">
														<div class="form-group">
															<div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
																<input type="text" class="form-control" name="firstName" placeholder="First name" value="<?php echo($userDetails['v_firstname']) ?>" />
															</div>
														</div>
													</div>
													<div class="col-xs-6">
														<div class="form-group">
															<div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
																<input type="text" class="form-control" name="lastName" placeholder="Last name" value="<?php echo($userDetails['v_lastname']) ?>" />
															</div>
														</div>
													</div>
												</div>


												<div class="form-group">
													<label>Username</label>
													<div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
														<input type="text" class="form-control" name="username" placeholder="Username" value="<?php echo($userDetails['v_username']) ?>" required/>
													</div>
												</div>
												<div class="form-group">
													<label>Organization Name</label>
													<div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-blackboard"></i></span>
														<input type="text" class="form-control" name="orgname" placeholder="Organisation Name" value="<?php echo($userDetails['v_org_name']) ?>" required/>
													</div>
												</div>

												<div class="form-group">
													<label>Website</label>
													<div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-globe"></i></span>
														<input type="url" class="form-control" name="website" placeholder="http://www.example.com" value="<?php echo($userDetails['v_website']) ?>" required/>
													</div>
												</div>

												
												<div class="form-group">
													<label for="sel1">Export Method</label>
													<div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-send"></i></span>
													<select class="form-control" id="sel1" name="exptMethod">
														<option value="Ship">By Ship</option>
														<option value="Road">By Road</option>
														<option value="Air">By Air</option>
													</select>
													</div>
												</div>
												
											




												
												<button type="submit" class="btn btn-success btn-block">Submit</button>

											</div>

										</div>
										
									<?php echo form_close(); ?>

								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								</div>
							</div>
						</div>
					</div>

					<!-- changePassModal Modal -->
					<div class="modal fade" id="changePassModal" role="dialog">
						<div class="modal-dialog">
							<!-- Add Modal content-->
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Change Password</h4>
								</div>
								<div class="modal-body">
									
									<?php echo form_open('users/changePass','id="reg_form"'); ?>
										<div class="row">

											<div class="col-md-8 col-md-offset-2">

												<p  class="text-center"> <?php echo validation_errors(); ?></p>


												<div class="form-group">
													<label>Current Password</label>
													<div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
														<input type="password" class="form-control" name="cpassword" placeholder="Password" required/>
													</div>
												</div>
												<div class="form-group">
													<label>New Password</label>
													<div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
														<input type="password" class="form-control" name="password" placeholder="Password" required/>
													</div>
												</div>
												<div class="form-group">
													<label>Confirm Password</label>
													<div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
														<input type="password" class="form-control" name="password2" placeholder="Confirm Password" required/>
													</div>
												</div>
												
												<button type="submit" class="btn btn-success btn-block">Submit</button>

											</div>

										</div>
										
									<?php echo form_close(); ?>

								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								</div>
							</div>
						</div>
					</div>

					<!-- changeProfilePicModal Modal -->
					<div class="modal fade" id="changeProfilePicModal" role="dialog">
						<div class="modal-dialog">
							<!-- Add Modal content-->
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Change Profile Picture</h4>
								</div>
								<div class="modal-body">
									<p class="text-warning">Picture Must Be:
										<li class="text-warning">Size : Less than 2 MB</li>
										<li class="text-warning">Max Height and Width : 1024 x 1024</li>
										<li class="text-warning">Formats : jpg, png, jpeg</li>
									</p>
									<?php echo form_open_multipart('users/do_upload');?>
									<?php echo "<input type='file' name='userfile' size='20' />"; ?>
									<?php echo "<br>"; ?>
									<?php echo "<input class='btn btn-primary' type='submit' name='submit' value='Upload' /> ";?>
									<?php echo "</form>"?>

								</div>
								<div class="modal-footer">
								<button type="button" class="btn btn-danger" onclick="location.href='<?php echo base_url(); ?>users/rmProPic/<?php echo $userDetails['v_profile_pic'] ?>'">Remove Profile Picture</button>
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								</div>
							</div>
						</div>
					</div>
					
				</div>
			</div>


			<!-- ========================= MESSAGES SECTION ========================= -->

			<div id="messages" class="tab-pane fade in">
												
					<div class="container">
						<div class="row">
							<div class="box-body no-padding">
								<div class="mailbox-controls">
									<!-- control button -->
									<button class="btn btn-primary btn-sm" onClick="window.location.reload()"><i class="glyphicon glyphicon-refresh"></i></button>


								</div>
								<hr>
								<div class="table-responsive mailbox-messages">
									<table class="table table-hover table-striped">
										
										<tbody>
											
											<?php $a = array(); ?>
											<?php if(empty($messages)):?>
												<h5 class="text-center text-warning"><i>No Messages</i></h5>
											<?php else:?>
											<?php foreach(array_reverse($messages) as $message) : ?>
											
												<?php if($message['message_type'] === 'DM' && !in_array($message['from_id'], $a)): ?>
													<?php array_push($a,$message['from_id']); ?>
													<tr>
														<td class="mailbox-star"><i class="fas <?php if($message['message_type'] === 'DM') : echo('far fa-envelope'); else: echo('fas fa-exclamation-circle'); endif;?>"></i></td>
														<td class="mailbox-name"><a href="<?php echo base_url(); ?>users/profile/<?php echo ($message['from_id'])?>"><?php echo($message['m_firstname']." ".$message['m_lastname'])?></a></td>
														<td class="mailbox-subject"><?php echo($message['message_body']) ?></td>
														<td class="mailbox-date"><?php echo(time_elapsed_string($message['message_time'])) ?></td>
														<td>
														<div class="btn-group">
															<button class="btn btn-info btn-sm" onclick="location.href='<?php echo base_url(); ?>users/messages/<?php echo ($message['from_id'])?>/<?php echo($message['m_firstname'])?>/<?php echo($message['m_lastname'])?>'"><i class="glyphicon glyphicon-arrow-left"></i> </button>
															<button class="btn btn-danger btn-sm" onclick="location.href='<?php echo base_url(); ?>users/delMessage/<?php echo ($message['messages_id'])?>'"><i class="glyphicon glyphicon-trash"></i></button>
														</div>
														</td>
													</tr>
												<?php elseif($message['message_type'] === 'Notification'): ?>
												<tr>
														<td class="mailbox-star"><i class="fas <?php if($message['message_type'] === 'DM') : echo('far fa-envelope'); else: echo('fas fa-exclamation-circle'); endif;?>"></i></td>
														<td class="mailbox-name"><a href="<?php echo base_url(); ?>users/profile/<?php echo ($message['from_id'])?>"><?php echo($message['m_firstname']." ".$message['m_lastname'])?></a></td>
														<td class="mailbox-subject"><?php echo($message['message_body']) ?></td>
														<td class="mailbox-date"><?php echo(time_elapsed_string($message['message_time'])) ?></td>
														<td>
														<button class="btn btn-danger btn-sm" onclick="location.href='<?php echo base_url(); ?>users/delMessage/<?php echo ($message['messages_id'])?>'"><i class="glyphicon glyphicon-trash"></i></button>
														</td>
													</tr>
												<?php elseif($message['message_type'] === 'Feedback'): ?>
												<tr>
														<td class="mailbox-star"><i class="far fa-comment"></i></td>
														<td class="mailbox-name"><a href="<?php echo base_url(); ?>users/profile/<?php echo ($message['from_id'])?>"><?php echo($message['m_firstname']." ".$message['m_lastname'])?></a></td>
														<td class="mailbox-subject"><?php echo($message['message_body']) ?></td>
														<td class="mailbox-date"><?php echo(time_elapsed_string($message['message_time'])) ?></td>
														<td>
														<button class="btn btn-danger btn-sm" onclick="location.href='<?php echo base_url(); ?>users/delMessage/<?php echo ($message['messages_id'])?>'"><i class="glyphicon glyphicon-trash"></i></button>
														</td>
													</tr>
												<?php endif;?>
											<?php endforeach; ?>
											<?php endif;?>
										</tbody>
									</table><!-- /.table -->
								</div><!-- /.mail-box-messages -->
							</div><!-- /.box-body -->
							<hr>
						</div><!-- /. box -->
					</div><!-- /.col -->


			</div>

			<!-- ========================= ADDRESS SECTION ========================= -->

			<div id="address" class="tab-pane fade in">
				<h3> Manage Address</h3>

				<div class="row is-flex">

					<!-- == DISPLAY ADDRESS == -->

					<?php foreach($addresses_arr as $address_arr) : ?>
					<div class="col-sm-6 col-md-3">
						<div class="well">
							<div class="caption">
								<h4 class="h4-margin-top-change"><?php echo ($address_arr['building_no']." , ".$address_arr['street']." , ".$address_arr['city']." , ".$address_arr['state']." , ".$address_arr['country'].". Pincode : ".$address_arr['pincode']); ?></h4>
									
									<div class="row">
										
										<div class="col-md-6">
											<button class="btn btn-warning btn-block" type="button" onclick="location.href='<?php echo base_url(); ?>users/viewAddress/<?php echo ($address_arr['add_id'])?>'"><span class=" glyphicon glyphicon-pencil" aria-hidden="true"></span></button> 
										</div>
										<div class="col-md-6">
											<button class="btn btn-danger btn-block" type="button" href="#" title="Do you want to delete this Address?" data-toggle="popover" data-trigger="focus" data-placement="bottom" data-content="<form action='<?php echo base_url(); ?>vendors/delAddress/<?php echo($address_arr['add_id']) ?>'><input class='btn btn-danger btn-block' type='submit' value='Yes' /></form> <button class='btn btn-info btn-block' href='home'>No</button>"><span class=" glyphicon glyphicon-trash" aria-hidden="true"></span></button>
										</div>

									</div>
							</div>
						</div>
					</div>
					<?php endforeach; ?>

					<!-- == ADD ADDRESS == -->

					<div class="col-sm-6 col-md-3">
						
						<button class="btn btn-info btn-lg btn-block" type="button" data-toggle="modal" data-target="#addModal" <?php if(!empty($addresses_arr)): echo("disabled='true'"); endif;?> ><i class="glyphicon glyphicon-plus"></i></button>  


						<!-- Add Modal -->
						<div class="modal fade" id="addModal" role="dialog">
							<div class="modal-dialog">
							
							<!-- Add Modal content-->
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Add New Address</h4>
								</div>
								<div class="modal-body">
									
									<?php echo form_open('vendors/newAddress',' id="address_form"'); ?>
										<div class="row">

											<div class="col-md-8 col-md-offset-2">

												<p  class="text-center"> <?php echo validation_errors(); ?></p>



												<div class="form-group">
													<label>Building/Flat No: </label>
														<input type="text" class="form-control" id="buildno" name="buildno" maxlength="24" required/>
												</div>

												<div class="form-group">
													<label>Street: </label>
													<textarea class="form-control" rows="3" id="street" name="street" placeholder="Max 100 characters" maxlength="100"></textarea>
												</div>

												<div class="form-group">
													<label>Pincode No: </label>
														<input type="number" class="form-control" id="pincode" name="pincode"  min="100000" max="999999" required/>
												</div>

												<div class="form-group">
													<label>Landmark (Optional): </label>
														<input type="text" class="form-control" id="landmark" name="landmark" maxlength="49" />
												</div>

												<div class="form-group">
													<label>State: </label>
													<select class="form-control" id="listBox" name="listBox" maxlength="24" onchange='selct_district(this.value)' ></select>
												</div>

												<div class="form-group">
													<label>City: </label>
													<select class="form-control" id='secondlist' maxlength="29" name="secondlist" ></select>
												</div>

												<div class="form-group">
													<label>Country: </label>
													<input type="text" class="form-control" value="India" id="country" name="country" data-toggle="popover" data-trigger="hover" data-content="Only available in India now." readonly="readonly"/>
												</div>




												
												<button type="submit" class="btn btn-success btn-block">Submit</button>

											</div>

										</div>
										
									<?php echo form_close(); ?>

								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								</div>
							</div>
							
							</div>
						</div>


					</div>

				</div>
			</div>


			<!-- ========================= MATERIALS SECTION ========================= -->

			<div id="materials" class="tab-pane fade in">

				<h3> Manage Materials</h3><small>Add the materials you can supply. If a tender is created for the same, you will be notified</small>
				<br><br>

				<div class="row is-flex">

					<!-- == DISPLAY MATERIALS == -->

					<?php foreach($vendorMaterials as $vendorMaterial) : ?>
					<div class="col-sm-6 col-md-4">
						<div class="well">
							<div class="caption">
								<h3 class="h4-margin-top-change"><?php echo ($vendorMaterial['rm_name']); ?></h3>
								<h4 ><?php echo ("Quality Info : ".$vendorMaterial['quality_info']); ?></h4>
									
								<button class="btn btn-danger btn-block" type="button" href="#" title="Do you want to delete this Material?" data-toggle="popover" data-trigger="focus" data-placement="bottom" data-content="<form action='<?php echo base_url(); ?>vendors/delVendorMaterial/<?php echo($vendorMaterial['v_material_id']) ?>'><input class='btn btn-danger btn-block' type='submit' value='Yes' /></form> <button class='btn btn-info btn-block' href='home'>No</button>"><span class=" glyphicon glyphicon-trash" aria-hidden="true"></span></button>
									
							</div>
						</div>
					</div>
					<?php endforeach; ?>

					<!-- == ADD MATERIAL == -->

					<div class="col-sm-6 col-md-3">
						
						<button class="btn btn-info btn-lg btn-block" type="button" data-toggle="modal" data-target="#addMaterialModal" ><i class="glyphicon glyphicon-plus"></i></button>  


						<!-- Add Material Modal -->
						<div class="modal fade" id="addMaterialModal" role="dialog">
							<div class="modal-dialog">
							
							<!-- Add Material Modal content-->
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Add Material</h4>
								</div>
								<div class="modal-body">
									
									<?php echo form_open('vendors/newVendorMaterial'); ?>
										<div class="row">

											<div class="col-md-8 col-md-offset-2">

												<p  class="text-center"> <?php echo validation_errors(); ?></p>

												<div class="form-group">
													<label for="matsel1">Select Material</label>
													<select class="form-control" id="matsel1" name="matsel1">
													<?php foreach($materials as $material) : ?>
														<option value="<?php echo ($material['raw_material_id']); ?>"><?php echo ($material['rm_name']); ?></option>
													<?php endforeach; ?>
													</select>
												</div>

												<div class="form-group">
													<label>Quality Information</label>
													<div class="input-group"> 
														<span class="input-group-addon"><i class="glyphicon glyphicon-comment"></i></span>
														<textarea class="form-control" rows="5" id="comments" placeholder="Max 300 characters" maxlength="300" name="quality_info"></textarea>
													</div>
												</div>

												
												<button type="submit" class="btn btn-success btn-block">Submit</button>

											</div>

										</div>
										
									<?php echo form_close(); ?>

								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								</div>
							</div>
							
							</div>
						</div>


					</div>

				</div>
			</div>


		</div>
	</div>
</div>