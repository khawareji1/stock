<div class="container"> 
    <h2> <?= $title ?> </h2>
</div>


<div id="tabnav" class="tabnav">

	<div class="container">
		<ul class="nav nav-tabs nav-justified">
			<li class="active"><a data-toggle="tab" href="#manufacturer"><b>Manufacturer </b><span class="badge"><?php echo count($manufacturers);?></span></a></li>
			<li><a data-toggle="tab" href="#vendor"><b>Vendor </b><span class="badge"><?php echo count($vendors);?></span></a></li>
			<li><a data-toggle="tab" href="#report"><b>Reports </b><span class="badge"><?php echo count($reports);?></span></a></li>
		</ul>

		<div class="tab-content">

			<!-- ========================= manufacturer SECTION ========================= -->

			<div id="manufacturer" class="tab-pane fade in active">
            
                <table class="table table-striped table-hover ">
                    
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Firstname</th> 
                            <th>Lastname</th>
                            <th>Email</th>
                            <th>Username</th>
                            <th>Org Name</th>
                            <th>Status</th>
                            <th>Profile Picture</th>
                            <th>Reg Date</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach($manufacturers as $manufacturer): ?>
                                <tr> 
                                    <td><?php echo ($manufacturer['m_id']);?></td>
                                    <td><a href="<?php echo base_url(); ?>users/profile/<?php echo ($manufacturer['m_id'])?>"><?php echo ($manufacturer['m_firstname']);?></a></td>
                                    <td><a href="<?php echo base_url(); ?>users/profile/<?php echo ($manufacturer['m_id'])?>"><?php echo ($manufacturer['m_lastname']);?></a></td>
                                    <td><?php echo ($manufacturer['m_email']);?></td>
                                    <td><?php echo ($manufacturer['m_username']);?></td>
                                    <td><?php echo ($manufacturer['m_org_name']);?></td>
                                    <td><?php echo ($manufacturer['m_status']);?></td>
                                    <td><?php echo ($manufacturer['m_profile_pic']);?></td>
                                    <td><?php echo ($manufacturer['register_date']);?></td>
                                </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#rmManuf">Remove Manufacturer</button>
                    
                    <!-- rmManuf Modal -->
					<div class="modal fade" id="rmManuf" role="dialog">
						<div class="modal-dialog">
							<!-- Add Modal content-->
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Remove Manufacturer</h4>
								</div>
								<div class="modal-body">
                                <?php echo form_open('admins/rmManuf'); ?>
										<div class="row">

											<div class="col-md-8 col-md-offset-2">

												<p  class="text-center"> <?php echo validation_errors(); ?></p>


												<div class="form-group">
													<label>Manufacturer ID</label>
													<div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
														<input type="text" class="form-control" name="id" placeholder="ID" required/>
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
			
            <!-- ========================= Vendor SECTION ========================= -->

			<div id="vendor" class="tab-pane fade in">
                <table class="table table-striped table-hover ">
                    
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Firstname</th> 
                            <th>Lastname</th>
                            <th>Email</th>
                            <th>Username</th>
                            <th>Org Name</th>
                            <th>Status</th>
                            <th>Profile Picture</th>
                            <th>Reg Date</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach($vendors as $vendor): ?>
                                <tr> 
                                    <td><?php echo ($vendor['v_id']);?></td>
                                    <td><a href="<?php echo base_url(); ?>users/profile/<?php echo ($vendor['v_id'])?>"><?php echo ($vendor['v_firstname']);?></a></td>
                                    <td><a href="<?php echo base_url(); ?>users/profile/<?php echo ($vendor['v_id'])?>"><?php echo ($vendor['v_lastname']);?></a></td>
                                    <td><?php echo ($vendor['v_email']);?></td>
                                    <td><?php echo ($vendor['v_username']);?></td>
                                    <td><?php echo ($vendor['v_org_name']);?></td>
                                    <td><?php echo ($vendor['v_status']);?></td>
                                    <td><?php echo ($vendor['v_profile_pic']);?></td>
                                    <td><?php echo ($vendor['created_at']);?></td>
                                </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table> 
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#rmVen">Remove Vendor</button>
                    
                    <!-- rmVen Modal -->
					<div class="modal fade" id="rmVen" role="dialog">
						<div class="modal-dialog">
							<!-- Add Modal content-->
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Remove Vendor</h4>
								</div>
								<div class="modal-body">
                                <?php echo form_open('admins/rmManuf'); ?>
										<div class="row">

											<div class="col-md-8 col-md-offset-2">

												<p  class="text-center"> <?php echo validation_errors(); ?></p>


												<div class="form-group">
													<label>Vendor ID</label>
													<div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
														<input type="text" class="form-control" name="id" placeholder="ID" required/>
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

            <!-- ========================= Report SECTION ========================= -->

			<div id="report" class="tab-pane fade in">
                <table class="table table-striped table-hover ">
                    
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>From ID</th> 
                            <th>Accused ID</th>
                            <th>Message</th>
                            <th>Report Type</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach($reports as $report): ?>
                                <tr> 
                                    <td><?php echo ($report['rep_id']);?></td>
                                    <td><?php echo ($report['user_id']);?></td>
                                    <td><?php echo ($report['accused_id']);?></td>
                                    <td><?php echo ($report['message']);?></td>
                                    <td><?php echo ($report['report_type']);?></td>
                                </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table> 


		    </div>

		</div>


	</div>
</div>