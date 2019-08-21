<div class="container">

<h3><?php echo $material['rm_name']; ?></h3>

        <div class="row display-flex">
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <img class="post-thumb-view thumbnail" src="<?php echo asset_url().'images/materials/'.$material['rm_pic'];?>" >
                </div>
                <div class="col-md-8">
                    <small class="material-date">Posted on: <?php echo $material['rm_created_at']; ?> in <strong><?php echo $material['subcat_name'];?></strong></small><br>
                    <?php echo "<p style='text-align:justify;'>".$material['rm_desc']."</p>"; ?>
                    <br><br>

                    <div class="row well">
                        <div class="col-md-6">
                            <h4 class="text-success">Pros</h4>
                            <p><?php echo "<p style='text-align:justify;'>".$material['rm_adv']."</p>"; ?></p>
                        </div>
                        <div class="col-md-6">
                            <h4 class="text-danger">Cons</h4>
                            <p><?php echo "<p style='text-align:justify;'>".$material['rm_disadv']."</p>"; ?></p>
                        </div>
                    </div>

                    <a class="btn btn-primary" role="button" href="<?php echo site_url('/tenderOpen/'.$material['rm_slug']); ?>">Create Tender</a>
                    <a class="btn btn-default" role="button" href="<?php echo site_url('/materials'); ?>">Go Back</a>
                </div>
</div></div>