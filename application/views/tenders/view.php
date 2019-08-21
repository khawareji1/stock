<div class="container">

<h3>Tender Reference No: # <?= $title?></h3>

        <div class="row">
            <div class="col-md-3">
                <img class="post-thumb-view thumbnail" src="<?php echo asset_url().'images/materials/'.$tender['rm_pic'];?>" >
            </div>
            <div class="col-md-8">
                
                <small class="material-date">Posted on: 

                <?php
                                
                                $subdate = $tender['date_of_submission'];
                                $subtime = $tender['time_submission'];
                                $sub = date('Y-m-d H:i:s', strtotime("$subdate $subtime "));
                                
                                $datetime2 = new DateTime($sub);
                                echo $sub;
                                
                            ?>
                </small><br>
                
                <dl class="dl-horizontal">
                    <dt>Manufacturer</dt>
                    <dd><a href="<?php echo base_url(); ?>users/profile/<?php echo ($tender['m_id'])?>"><?php echo ($tender['m_firstname']." ".$tender['m_lastname']); ?></a></dd>
                    <dt>Quantity</dt>
                    <dd><?php echo ($tender['tender_quantity']." ".$tender['tender_quantity_unit']);?></dd>
                    <dt>Time till Expiry</dt>
                    <dd><?php
                                
                                $expdate = $tender['date_expire'];
                                $exptime = $tender['time_expire'];
                                $exp = date('Y-m-d H:i:s', strtotime("$expdate $exptime "));
                                $tempExpired=0;
                                $datetime1 = new DateTime();
                                $datetime2 = new DateTime($exp);
                                if ( $datetime1 >  $datetime2){
                                    echo("Expired");
                                    $tempExpired=1;
                                }
                                else{
                                    $interval = $datetime1->diff($datetime2);
                                echo $interval->format('%d day %h hours %i minutes');
                                }
                                
                            ?>
                    </dd>
                    <dt>Estimated Price</dt>
                    <dd><?php echo ("₹ ".$tender['estimated_price']);?></dd>
                    <dt>Requirements</dt>
                    <dd><?php echo ($tender['extra_info']);?></dd>
                </dl>

                <hr>

                <dl class="dl-horizontal">
                    <dt>Raw Material</dt>
                    <dd><?php echo ($tender['rm_name']);?><dd>
                    <dt>Category</dt>
                    <dd><?php echo ($tender['subcat_name']);?><dd>
                    <dt>Desciption</dt>
                    <dd><?php echo "<p style='text-align:justify;'>".$tender['rm_desc']."</p>"; ?></dd>
                </dl>

<!-- for vendors and other visitors. if the tender is in active mode -->
<?php if($this->session->userdata('user_id') != $tender['m_id']  && $tender['tender_status'] === "active" ): ?>

            <br><br>
            <button class="btn btn-primary" role="button" data-toggle="modal" data-target="#requestModal" <?php if($tempExpired==1){echo("disabled='true'");} ?> >Send Request <span class="glyphicon glyphicon-send" aria-hidden="true"></span></button>
            <a class="btn btn-default" role="button" href="<?php echo site_url('/tenders'); ?>">Go Back</a>

                <!-- Request Modal -->
                <div class="modal fade" id="requestModal" role="dialog">
                    <div class="modal-dialog">
                    
                    <!-- Request Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Send Request</h4>
                        </div>
                        <div class="modal-body">
                            
                            <?php echo form_open('/tenders/tenderRequest/'.$tender['tender_id'].'/'.$tender['m_id']); ?>
                                <div class="row">

                                    <div class="col-md-8 col-md-offset-2">

                                        <p  class="text-center"> <?php echo validation_errors(); ?></p>
                                        


                                        <!-- <div class="form-group">
                                            <label for="inpuFname">Enter the quantity that you can deliver</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-align-justify"></i></span>
                                                <input type="number" value="1" class="form-control" min="1" name="tender_quantity"  id="tender_quantity">
                                            </div>
                                        </div> -->

                                        <div class="row">
                                        <label>Enter the quantity that you can deliver</label>
                                            <div class="col-xs-6 col-sm-7 col-md-7">
                                                <div class="form-group">
                                                    <!-- <label for="inpuFname">Quantity</label> -->
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="glyphicon glyphicon-align-justify"></i></span>
                                                        <input type="number" value="1" class="form-control" min="1" name="tender_quantity"  id="tender_quantity">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xs-6 col-sm-5 col-md-5">
                                                <div class="form-group">

                                                    <!-- <label for="sel1">Select Unit:</label> -->
                                                    <select class="form-control" name="tender_quantity_unit" id="tender_quantity_unit">
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


                                        <div class="form-group">
                                            <label>Enter the Quoted Price</label>
                                            <div class="input-group"> 
                                                <span class="input-group-addon">₹</span>
                                                <input type="number" class="form-control" name="quoted-price" id="quoted-price" value="0" min="0" required/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Date of Delivery</label>
                                            <div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                <input type="date" class="form-control" name="dod" id="dod" min="<?php echo date("Y-m-d",strtotime('tomorrow')); ?>" required/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Extra Info / Comments (Optional)</label>
                                            <div class="input-group"> 
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-comment"></i></span>
                                                <textarea class="form-control" rows="5" placeholder="Max 300 characters" maxlength="300" name="extra_info" id="extra_info"></textarea>
                                            </div>
                                        </div>




                                        
                                        <button type="submit" class="btn btn-success btn-block" >Submit</button>

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

<!-- for manufacterur who created the tender. if the tender is in active mode -->
<?php elseif($this->session->userdata('user_id') === $tender['m_id']  && $tender['tender_status'] === "active"): ?>

        </div>
        </div>
        <hr>
        <button class="btn btn-danger pull-right" type="button" href="#" title="Do you want to cancel this tender?" data-toggle="popover" data-trigger="focus" data-placement="bottom" data-content="<form action='<?php echo base_url(); ?>tenders/cancelTender/<?php echo($tender['tender_id']) ?>'><input class='btn btn-danger btn-block' type='submit' value='Yes' /></form> <button class='btn btn-info btn-block' href='home'>No</button>"><span class=" glyphicon glyphicon-trash" aria-hidden="true"></span> Cancel Tender</button>
		<h3>Tender Requests</h3>
        </br>
                
        <?php if($tempExpired==1): ?>
            <h5 class="text-center text-danger"><i>Tender Expired</i></h5>
        <?php elseif(empty($DiffVendorRequests)): ?>
            <h5 class="text-center text-warning"><i>No Requests</i></h5>
        <?php else: ?>

            <table class="table table-striped table-hover " id="diffVendorTable">
                    
                <thead>
                    <tr>
                        <th>SI No</th>
                        <th onclick="sortTable(0)" >Request ID</th>
                        <th onclick="sortTable(1)" >Vendor Name</th> 
                        <th onclick="sortTable(2)" >Quantity</th> <!-- quantity and unit combined-->
                        <th onclick="sortTable(3)" >Quoted Price (₹)</th>
                        <th onclick="sortTable(4)" >Delivery Date</th>
                        <th>Additional Info</th>
                        <th>Operations</th>
                    </tr>
                </thead>

                <tbody id="diffVendoTableBody">
                    <?php $i = 1; ?>
                    <?php foreach($DiffVendorRequests as $DiffVendorRequest): 
                            if($DiffVendorRequest['req_status'] != "declined"): ?>
                            <tr> 
                                <td>  <?php echo($i++);?></td>
                                <td><?php echo ("#".$DiffVendorRequest['request_id']); ?></td>
                                <td><a href="<?php echo base_url(); ?>users/profile/<?php echo ($DiffVendorRequest['vendor_id'])?>"><?php echo ($DiffVendorRequest['v_firstname']." ".$DiffVendorRequest['v_lastname']); ?></a></td>
                                <td><?php echo ($DiffVendorRequest['quantity']." ".$DiffVendorRequest['quantity_unit']);?></td>
                                <td><?php echo ("₹ ".$DiffVendorRequest['quoted_price']);?></td>
                                <td><?php echo ($DiffVendorRequest['delivery_date']); ?></td>
                                <td><?php echo ($DiffVendorRequest['req_desc']); ?></td>
                                <td>
                                    <!-- <button class="btn btn-success" role="button"  ><span class="glyphicon glyphicon-ok"></span></button> -->
                                    <!-- <button class="btn btn-danger" role="button"  ><span class="glyphicon glyphicon-remove"></span></button> -->
                                    <button class="btn btn-success" type="button" title="Do you want to accept this request?" data-toggle="popover" data-trigger="focus" data-placement="right" data-content="<form action='<?php echo base_url(); ?>tenders/acptRequests/<?php echo($DiffVendorRequest['request_id']) ?>'><input class='btn btn-danger btn-block' type='submit' value='Yes' /></form> <button class='btn btn-info btn-block' href='home'>No</button>"><span class=" glyphicon glyphicon-ok" aria-hidden="true"></span></button>
                                    <button class="btn btn-danger" type="button" title="Do you want to decline this request?" data-toggle="popover" data-trigger="focus" data-placement="right" data-content="<form action='<?php echo base_url(); ?>tenders/declRequests/<?php echo($DiffVendorRequest['request_id']) ?>'><input class='btn btn-danger btn-block' type='submit' value='Yes' /></form> <button class='btn btn-info btn-block' href='home'>No</button>"><span class=" glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                </td>
                                
                            </tr>
                            <?php endif;
                        endforeach; ?>
                </tbody>

            </table> 
        <?php endif;?>

<!-- if the tender is in ONGOING mode -->
<?php elseif($tender['tender_status'] === "ongoing"): ?>
</div>
        </div>
        <hr>
        <h3>Ongoing Tender</h3>
        </br>

        <div class="row">
            
            <div class="col-md-6">
                <div class="well">
                    <h4 class="text-center">Transaction Summary</h4></br>
                    <?php foreach($DiffVendorRequests as $DiffVendorRequest): 
                            if($DiffVendorRequest['request_id'] === $transaction['diff_vendor_reqid']): ?>
                    <dl class="dl">
                        <dt>Vendor</dt>
                        <dd><?php echo ($DiffVendorRequest['v_firstname']." ".$DiffVendorRequest['v_lastname']); ?></dd>
                        <dt>Quantity</dt>
                        <dd><?php echo ($DiffVendorRequest['quantity']." ".$DiffVendorRequest['quantity_unit']);?></dd>
                        <dt>Price Fixed</dt>
                        <dd><?php echo ("₹ ".$DiffVendorRequest['quoted_price']);?></dd>
                        <dt>Requirements</dt>
                        <dd><?php echo ($tender['extra_info']);?></dd>
                        <dt>Transaction created Date</dt>
                        <dd><?php echo ($transaction['start_date']." ".$transaction['start_time']);?>
                        </dd>
                        <dt>Estimated Time of Delivery</dt>
                        <dd><?php echo ($transaction['delvy_date']." ".$transaction['delvy_time']);?></dd>
                        
                        <?php $tempDelayed=0;?>
                        <?php if($transaction['trans_delay_time'] != null && $transaction['trans_delay_unit'] != null): 
                                $tempDelayed=1;?>
                            <dt class="text-danger">Delayed by : </dt>
                            <dd class="text-danger"><?php echo ("+".$transaction['trans_delay_time']." ".$transaction['trans_delay_unit']);?></dd>
                        <?php endif;?>

                    </dl>
                    <?php endif;
                        endforeach; ?>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="well">
                    <h4 class="text-center">Transaction Status</h4></br>
                    <?php if($transaction['trans_status'] === 'orderConfirmed'):?>
                        <h5>Transaction Status : Order Confirmed</h5>
                        <div class="progress progress-vertical progress-striped active">
                            <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    <?php elseif($transaction['trans_status'] === 'packed'): ?>
                        <h5>Transaction Status : Packed</h5>
                        <div class="progress progress-vertical progress-striped active">
                            <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    <?php elseif($transaction['trans_status'] === 'dispatched'): ?>
                        <h5>Transaction Status : Dispatched</h5>
                        <div class="progress progress-vertical progress-striped active">
                            <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    <?php elseif($transaction['trans_status'] === 'delivered'): ?>
                        <h5>Transaction Status : Delivered</h5>
                        <div class="progress progress-vertical progress-striped active">
                            <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    <?php endif; ?>
                    
                    <?php if($transaction['trans_message'] != ''):?>
                        <?php if($transaction['trans_message'] === 'DNR'):?>
                            <h5 class="text-danger" >Message From Manufacturer : Delivery not Recieved</h5>
                            </br>
                        <?php else:?>
                            <h5>Message From Vendor : <?php echo($transaction['trans_message']);?></h5>
                            </br>
                        <?php endif; ?>
                    <?php endif; ?>
                    
                
                <!-- for manufacturer who requested. if the tender is in ONGOING mode -->
                <?php if($this->session->userdata('user_id') === $tender['m_id']): ?>
                    
                    <?php if($tempDelayed == 1): ?>    
                    <button class="btn btn-danger btn-block" type="button"  data-toggle="modal" data-target="#cancelTender">Cancel Tender</button>


                            <!-- changeStatus Modal -->
                            <div class="modal fade" id="cancelTender" role="dialog">
                                <div class="modal-dialog">
                                
                                <!-- changeStatus Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Cancel Tender</h4>
                                    </div>
                                    <div class="modal-body">
                                        
                                        <?php echo form_open('/tenders/cancelTender/'.$tender['tender_id']); ?>
                                            <div class="row">

                                                <div class="col-md-8 col-md-offset-2">

                                                    <p  class="text-center"> <?php echo validation_errors(); ?></p>
                                                    <p class="text-danger text-center">Are you Sure? (This can't be undone)</p>
                                                    <div class="btn-group btn-group-justified">
                                                        <div class="btn-group">
                                                            <button type="submit" class="btn btn-danger btn-block" >Yes</button>
                                                        </div>
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-primary btn-block" data-dismiss="modal">No</button>
                                                        </div>
                                                    </div>

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
                    
                    <?php else: ?>
                        <button class="btn btn-danger btn-block" type="button" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="Tender can only be cancelled if the delivery is delayed." disabled='true'>Cancel Tender</button>
                    <?php endif; ?>

                <!-- for vendor who requested. if the tender is in ONGOING mode -->
                <?php elseif($this->session->userdata('user_id') === $transaction['vendor_id']): ?>
                    <div class="btn-group btn-group-justified">
                        <div class="btn-group">
                            <button class="btn btn-primary" type="button"  data-toggle="modal" data-target="#changeStatusModal">Change Status</button>
                        </div>
                        <div class="btn-group">
                            <button class="btn btn-danger" type="button" data-toggle="modal" data-target="#changeETAModal">Change ETA</button>
                        </div>
                    </div>

                            <!-- changeStatus Modal -->
                            <div class="modal fade" id="changeStatusModal" role="dialog">
                                <div class="modal-dialog">
                                
                                <!-- changeStatus Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Change Status</h4>
                                    </div>
                                    <div class="modal-body">
                                        
                                        <?php echo form_open('/tenders/changeStatus/'.$transaction['trans_id']); ?>
                                            <div class="row">

                                                <div class="col-md-8 col-md-offset-2">

                                                    <p  class="text-center"> <?php echo validation_errors(); ?></p>

                                                    
                                                    <div class="form-group">
                                                        <label>Select the status</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="glyphicon glyphicon-send"></i></span>
                                                            <select class="form-control" name="trans_status_change" id="trans_status_change">
                                                                <option value="orderConfirmed">Order Confirmed</option>
                                                                <option value="packed">Packed</option>
                                                                <option value="dispatched">Dispatched</option>
                                                                <option value="delivered">Delivered</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Message (Optional)</label>
                                                        <div class="input-group"> 
                                                            <span class="input-group-addon"><i class="glyphicon glyphicon-comment"></i></span>
                                                            <textarea class="form-control" rows="5" placeholder="Max 300 characters" maxlength="300" name="message" id="message"></textarea>
                                                        </div>
                                                    </div>

                                                    <button type="submit" class="btn btn-success btn-block" >Submit</button>

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

                            <!-- changeETA Modal -->
                            <div class="modal fade" id="changeETAModal" role="dialog">
                                <div class="modal-dialog">
                                
                                <!-- changeETA Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Change Estimated time of Delivery</h4>
                                    </div>
                                    <div class="modal-body">
                                        
                                        <?php echo form_open('/tenders/changeETA/'.$transaction['trans_id']); ?>
                                            <div class="row">

                                                <div class="col-md-8 col-md-offset-2">

                                                    <p  class="text-center"> <?php echo validation_errors(); ?></p>
                                                    <p class="text-warning">Note : By changing the ETA the Manufacturer gets the option to remove this tender</p>

                                                    <div class="row">
                                                    <label>Enter the quantity that you can deliver</label>
                                                        <div class="col-xs-6 col-sm-7 col-md-7">
                                                            <div class="form-group">
                                                                <!-- <label for="inpuFname">Quantity</label> -->
                                                                <div class="input-group">
                                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-plus"></i></span>
                                                                    <input type="number" value="1" class="form-control" min="1" max="100" name="trans_delay_time"  id="trans_delay_time">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xs-6 col-sm-5 col-md-5">
                                                            <div class="form-group">

                                                                <!-- <label for="sel1">Select Unit:</label> -->
                                                                <select class="form-control" name="trans_delay_unit" id="trans_delay_unit">
                                                                    <option value="Hours">Hours</option>
                                                                    <option value="Days">Days</option>
                                                                </select>

                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="form-group">
                                                        <label>Message/Reason (Optional)</label>
                                                        <div class="input-group"> 
                                                            <span class="input-group-addon"><i class="glyphicon glyphicon-comment"></i></span>
                                                            <textarea class="form-control" rows="5" placeholder="Max 300 characters" maxlength="300" name="message" id="message"></textarea>
                                                        </div>
                                                    </div>

                                                    <button type="submit" class="btn btn-success btn-block" >Submit</button>

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
                <?php endif; ?>

                </div>

                <?php if($transaction['trans_status'] === 'delivered' && $this->session->userdata('user_id') === $tender['m_id']): ?>
                
                    <?php echo form_open('/tenders/deliveryComplete/'.$tender['tender_id']); ?>
                    <div class="well">
                        <h4 class="text-center">Did you receive the delivery ?</h4></br>
                        <div class="btn-group btn-group-justified">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-success ger btn-block" >Yes</button>
                    <?php echo form_close(); ?>
                    <?php echo form_open('/tenders/deliveryNotGet/'.$transaction['trans_id']); ?>
                    
                            </div>
                            <div class="btn-group">
                                <button type="submit" class="btn btn-danger btn-block" >No</button>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close(); ?>

                <?php endif; ?>

            </div>
        </div>

<!-- if the tender is in COMPLETED mode -->
<?php elseif($tender['tender_status'] === "completed"): ?>
</div>
        </div>
        <hr>
        <h3 class="text-center">Tender completed</h3>
        <div class="well">
                    <h4 class="text-center">Transaction Summary</h4></br>
                    <?php foreach($DiffVendorRequests as $DiffVendorRequest): 
                            if($DiffVendorRequest['request_id'] === $transaction['diff_vendor_reqid']): ?>
                    <dl class="dl">
                        <dt>Vendor</dt>
                        <dd><?php echo ($DiffVendorRequest['v_firstname']." ".$DiffVendorRequest['v_lastname']); ?></dd>
                        <dt>Quantity</dt>
                        <dd><?php echo ($DiffVendorRequest['quantity']." ".$DiffVendorRequest['quantity_unit']);?></dd>
                        <dt>Price Fixed</dt>
                        <dd><?php echo ("₹ ".$DiffVendorRequest['quoted_price']);?></dd>
                        <dt>Requirements</dt>
                        <dd><?php echo ($tender['extra_info']);?></dd>
                        <dt>Transaction created Date</dt>
                        <dd><?php echo ($transaction['start_date']." ".$transaction['start_time']);?>
                        </dd>
                        <dt>Time of Delivery</dt>
                        <dd><?php echo ($transaction['delvy_date']." ".$transaction['delvy_time']);?></dd>
                        
                        <?php if($transaction['trans_delay_time'] != null && $transaction['trans_delay_unit'] != null): 
                                $tempDelayed=1;?>
                            <dt class="text-danger">Delayed by : </dt>
                            <dd class="text-danger"><?php echo ("+".$transaction['trans_delay_time']." ".$transaction['trans_delay_unit']);?></dd>
                        <?php endif;?>

                    </dl>
                    <?php endif;
                        endforeach; ?>
                <button class="btn btn-info" onclick="location.href='<?php echo base_url(); ?>tenders/print/<?php echo $title?>'">Print Invoice</button>
                <?php if($this->session->userdata('user_id') === $tender['m_id']): ?>
                    <button class="btn btn-info" data-toggle="modal" data-target="#myModal">Give Feedback</button>

                    <!-- Modal -->
                    <div id="myModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Send Feedback</h4>
                            </div>
                            <div class="modal-body">
                            <?php echo form_open('users/sendFeedback/'.$transaction['vendor_id']); ?>
                            
                                <div class="form-group">
                                    <div class="input-group"> 
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-comment"></i></span>
                                        <textarea class="form-control" rows="8" id="message" placeholder="Max 300 characters" maxlength="300" name="message" required></textarea>
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn btn-success btn-block">Submit</button>
                                
                            <?php echo form_close(); ?>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                            </div>

                        </div>
                    </div>
                <?php endif;?>
                </div>
            </div>


<!-- if the tender is in CANCELLED mode -->
<?php elseif($tender['tender_status'] === "cancelled"): ?>
</div>
        </div>
        <hr>
        <h3 class="text-center text-danger">Tender cancelled</h3>

<?php endif; ?>

        
        
</div>