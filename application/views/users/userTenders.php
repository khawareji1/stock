<h2 style="padding-left:20px;"> <?= $title ?> </h2>

<div class="row" id="accordion">

    <div class="col-md-2 col-sm-4">
    <div class="list-group" id="listInUserTender">
        <a href="#active" class="list-group-item active" data-toggle="collapse" data-parent="#accordion" >Created Tenders<span class="badge"><?php echo count($activeTenders);?></span></a>
        <a href="#ongoing" class="list-group-item" data-toggle="collapse" data-parent="#accordion">Ongoing Tenders<span class="badge"><?php echo count($ongoingTenders);?></span></a>
        <a href="#completed" class="list-group-item" data-toggle="collapse" data-parent="#accordion">Completed Tenders<span class="badge"><?php echo count($completedTenders);?></span></a>
        <a href="#expired" class="list-group-item" data-toggle="collapse" data-parent="#accordion">Expired Tenders<span class="badge"><?php echo count($expiredTenders);?></span></a>
    </div>
    </div>


    <div class="col-md-10 col-sm-8" >
        
        <div class="row collapse in" id="active">

            <h3 style="padding-left:20px;" >Created Tenders</h3>

            <?php foreach($activeTenders as $active): ?>

                 <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" id="clickableTenders">  <!-- for making it clickable -->
                    <div class="well well-lg">
                        
                        <div class="row">

                            <div class="col-xs-2">
                                
                                <img class="post-thumb-view img-circle" src="<?php echo asset_url().'images/materials/'.$active['rm_pic'];?>" >
                            </div>

                            <div class="col-xs-10">
                                <dl class="dl-horizontal" >
                                    <dt>Tender ID</dt>
                                    <dd><?php echo ("#".$active['tender_id']); ?></dd>
                                    <dt>Item</dt>
                                    <dd><?php echo ($active['rm_name']); ?></dd>
                                    <dt>Quantity</dt>
                                    <dd><?php echo ($active['tender_quantity']." ".$active['tender_quantity_unit']);?></dd>
                                    <dt>Estimated Price</dt>
                                    <dd><?php echo ("₹ ".$active['estimated_price']);?></dd>
                                    <dt>Posted On</dt>
                                    <dd><?php
                                    
                                    $subdate = $active['date_of_submission'];
                                    $subtime = $active['time_submission'];
                                    $sub = date('Y-m-d H:i:s', strtotime("$subdate $subtime "));
                                    
                                    $datetime2 = new DateTime($sub);
                                    echo $sub;
                                    
                                    ?></dd>
                                    <dt>Time till Expiry</dt>
                                    <dd><?php
                                                
                                                $expdate = $active['date_expire'];
                                                $exptime = $active['time_expire'];
                                                $exp = date('Y-m-d H:i:s', strtotime("$expdate $exptime "));
                                                $temp=0;
                                                $datetime1 = new DateTime();
                                                $datetime2 = new DateTime($exp);
                                                if ( $datetime1 >  $datetime2){
                                                    echo("Expired");
                                                    $temp=1;
                                                }
                                                else{
                                                    $interval = $datetime1->diff($datetime2);
                                                echo $interval->format('%d day %h hours %i minutes');
                                        
                                                }
                                        
                                            ?>
                                    </dd>
                                    <a style="display:none;" href="<?php echo base_url(); ?>tenders/view/<?php echo($active['tender_id']); ?>" >View</a>
                                </dl>
                            </div>

                        </div>

                    </div>
                </div>


            <?php endforeach;
                    if($activeTenders == NULL): ?>
                        <h6 class="text-center"><i>Empty</i></h6>
            <?php endif;?>

        </div>


        <div class="row collapse" id="ongoing">
            <hr>
            <h3 style="padding-left:20px;">Ongoing Tenders</h3>

            <?php foreach($ongoingTenders as $ongoing): ?>

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" id="clickableTenders">  <!-- for making it clickable -->
            <div class="well well-lg">
                
                <div class="row">

                    <div class="col-xs-2">
                        
                        <img class="post-thumb-view img-circle" src="<?php echo asset_url().'images/materials/'.$ongoing['rm_pic'];?>" >
                    </div>

                    <div class="col-xs-10">
                        <dl class="dl-horizontal" >
                            <dt>Tender ID</dt>
                            <dd><?php echo ("#".$ongoing['tender_id']); ?></dd>
                            <dt>Item</dt>
                            <dd><?php echo ($ongoing['rm_name']); ?></dd>
                            <dt>Quantity</dt>
                            <dd><?php echo ($ongoing['tender_quantity']." ".$ongoing['tender_quantity_unit']);?></dd>
                            <dt>Estimated Price</dt>
                            <dd><?php echo ("₹ ".$ongoing['estimated_price']);?></dd>
                            <dt>Posted On</dt>
                            <dd><?php
                            
                            $subdate = $ongoing['date_of_submission'];
                            $subtime = $ongoing['time_submission'];
                            $sub = date('Y-m-d H:i:s', strtotime("$subdate $subtime "));
                            
                            $datetime2 = new DateTime($sub);
                            echo $sub;
                            
                            ?></dd>
                            <dt>Expired On</dt>
                            <dd><?php
                            
                            $subdate = $ongoing['date_of_submission'];
                            $subtime = $ongoing['time_submission'];
                            $sub = date('Y-m-d H:i:s', strtotime("$subdate $subtime "));
                            
                            $datetime2 = new DateTime($sub);
                            echo $sub;
                            
                            ?></dd>
                            <a style="display:none;" href="<?php echo base_url(); ?>tenders/view/<?php echo($ongoing['tender_id']); ?>" >View</a>
                        </dl>
                    </div>

                </div>

            </div>
            </div>

            <?php endforeach;
                        if($ongoingTenders == NULL): ?>
                        <h6 class="text-center"><i>Empty</i></h6>
            <?php endif;?>
        </div>


        <div class="row collapse" id="completed">
            <hr>
            <h3 style="padding-left:20px;">Completed Tenders</h3>

            <?php foreach($completedTenders as $completed): ?>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" id="clickableTenders">  <!-- for making it clickable -->
                <div class="well well-lg">
                    
                    <div class="row">

                        <div class="col-xs-2">
                            
                            <img class="post-thumb-view img-circle" src="<?php echo asset_url().'images/materials/'.$completed['rm_pic'];?>" >
                        </div>

                        <div class="col-xs-10">
                            <dl class="dl-horizontal" >
                                <dt>Tender ID</dt>
                                <dd><?php echo ("#".$completed['tender_id']); ?></dd>
                                <dt>Item</dt>
                                <dd><?php echo ($completed['rm_name']); ?></dd>
                                <dt>Quantity</dt>
                                <dd><?php echo ($completed['tender_quantity']." ".$completed['tender_quantity_unit']);?></dd>
                                <dt>Estimated Price</dt>
                                <dd><?php echo ("₹ ".$completed['estimated_price']);?></dd>
                                <dt>Posted On</dt>
                                <dd><?php
                                
                                $subdate = $completed['date_of_submission'];
                                $subtime = $completed['time_submission'];
                                $sub = date('Y-m-d H:i:s', strtotime("$subdate $subtime "));
                                
                                $datetime2 = new DateTime($sub);
                                echo $sub;
                                
                                ?></dd>
                                <dt>Expired On</dt>
                                <dd><?php
                                
                                $subdate = $completed['date_expire'];
                                $subtime = $completed['time_expire'];
                                $sub = date('Y-m-d H:i:s', strtotime("$subdate $subtime "));
                                
                                $datetime2 = new DateTime($sub);
                                echo $sub;
                                
                                ?></dd>
                                <a style="display:none;" href="<?php echo base_url(); ?>tenders/view/<?php echo($completed['tender_id']); ?>" >View</a>
                            </dl>
                        </div>

                    </div>

                </div>
                </div>

                <?php endforeach; 
                    if($completedTenders == NULL): ?>
                        <h6 class="text-center"><i>Empty</i></h6>
                <?php endif;?>
        </div>

        <div class="row collapse" id="expired">

            <hr>
            <h3 style="padding-left:20px;">Expired Tenders</h3>
            <?php foreach($expiredTenders as $expired): ?>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" id="clickableTenders">  <!-- for making it clickable -->
                <div class="well well-lg">
                    
                    <div class="row">

                        <div class="col-xs-2">
                            
                            <img class="post-thumb-view img-circle" src="<?php echo asset_url().'images/materials/'.$expired['rm_pic'];?>" >
                        </div>

                        <div class="col-xs-10">
                            <dl class="dl-horizontal" >
                                <dt>Tender ID</dt>
                                <dd><?php echo ("#".$expired['tender_id']); ?></dd>
                                <dt>Item</dt>
                                <dd><?php echo ($expired['rm_name']); ?></dd>
                                <dt>Quantity</dt>
                                <dd><?php echo ($expired['tender_quantity']." ".$expired['tender_quantity_unit']);?></dd>
                                <dt>Estimated Price</dt>
                                <dd><?php echo ("₹ ".$expired['estimated_price']);?></dd>
                                <dt>Posted On</dt>
                                <dd><?php
                                
                                $subdate = $expired['date_of_submission'];
                                $subtime = $expired['time_submission'];
                                $sub = date('Y-m-d H:i:s', strtotime("$subdate $subtime "));
                                
                                $datetime2 = new DateTime($sub);
                                echo $sub;
                                
                                ?></dd>
                                <dt>Expired On</dt>
                                <dd><?php
                                
                                $subdate = $expired['date_expire'];
                                $subtime = $expired['time_expire'];
                                $sub = date('Y-m-d H:i:s', strtotime("$subdate $subtime "));
                                
                                $datetime2 = new DateTime($sub);
                                echo $sub;
                                
                                ?></dd>
                                <a style="display:none;" href="<?php echo base_url(); ?>tenders/view/<?php echo($expired['tender_id']); ?>" >View</a>
                            </dl>
                        </div>

                    </div>

                </div>
                </div>

                <?php endforeach;
                            if($expiredTenders == NULL): ?>
                            <h6 class="text-center"><i>Empty</i></h6>
                <?php endif;?>
        </div>


    </div>

</div>