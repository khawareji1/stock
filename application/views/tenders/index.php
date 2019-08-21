<div class="container">
    
    

    <div class="row">
    
        <!-- <div class="col-md-2">
            <h1>     </h1>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Show results for</h3>
                </div>
                <div class="panel-body">
                    
                        <h3 class="panel-title">Price</h3>
                        <li class="list-unstyled"><a href="#">Under ₹10,000</a></li>
                        <li class="list-unstyled"><a href="#">₹1,000 - ₹10,000</a></li>
                        <li class="list-unstyled"><a href="#">₹10,000 - ₹50,000</a></li>
                        <li class="list-unstyled"><a href="#">₹50,000 - ₹1,00,000</a></li>
                        <li class="list-unstyled"><a href="#">Over ₹1,00,000</a></li>

            </div>

            </div>
        </div>

        <div class="col-md-10"> -->

            <h1><?= $title ?></h1>

            <input class="form-control" id="tenderSearchInput" type="text" placeholder="Search" >
            <br>

            <table class="table table-striped table-hover " id="tenderSearchTable">
                
                <thead>
                    <tr>
                        <th>#</th>
                        <th onclick="sortTable(0)" >Raw Material</th>
                        <th onclick="sortTable(1)" >Quantity</th> <!-- quantity and unit combined-->
                        <th onclick="sortTable(2)" >Time till Expiry</th>
                        <th onclick="sortTable(3)" >Estimated Price (₹)</th>
                    </tr>
                </thead>

                <tbody id="tenderSearchTableBody">
                    <?php $i = 1; ?>
                    <?php foreach($tenders as $tender): ?>
                    <?php if($tender['tender_status'] === 'active' || $tender['tender_status'] === 'ongoing' ): ?>
                            <tr> 
                                <td> <a href="<?php echo base_url(); ?>tenders/view/<?php echo($tender['tender_id']); ?>"></a> <?php echo($i++);?></td>
                                <td><?php echo ($tender['rm_name']);?></td>
                                <td><?php echo ($tender['tender_quantity']." ".$tender['tender_quantity_unit']);?> </td>
                                <td id="tenderSearchTableTD">
                                <?php
                                    
                                    $expdate = $tender['date_expire'];
                                    $exptime = $tender['time_expire'];
                                    $exp = date('Y-m-d H:i:s', strtotime("$expdate $exptime "));
                                    
                                    $datetime1 = new DateTime();
                                    $datetime2 = new DateTime($exp);
                                    if ( $datetime1 >  $datetime2){
                                        echo("Expired");
                                    }
                                    else{
                                        $interval = $datetime1->diff($datetime2);
                                        echo $interval->format('%d day %h hours %i minutes');
                                    }
                                    
                                    
                                ?>
                                </td>
                                <td><?php echo ($tender['estimated_price']);?></td>
                                
                            </tr>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table> 
        </div>
        
    </div>



</div>
