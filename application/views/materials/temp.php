<div class="row display-flex">
    <?php foreach($materials as $material) : ?>
        <div class="col-sm-6 col-md-3 display-flex">
            <div class="thumbnail">
                <img class="post-thumb thumbnail" src="<?php echo asset_url().'images/materials/'.$material['rm_pic'];?>" >
                <div class="caption">
                    <h3 class="h3-margin-top-change"><?php echo $material['rm_name']; ?></h3>
                    <small class="material-date">Posted on: <?php echo $material['rm_created_at']; ?> in <strong><?php echo $material['subcat_name'];?></strong></small>
                    <p class="flex-text"><?php echo word_limiter($material['rm_desc'],30); ?></p>
                    <p>
                        <div class="row">
							<div class="col-md-6">
                                <button class="btn btn-primary" role="button" onclick="location.href = '<?php echo site_url('/tenderOpen/'.$material['rm_slug']); ?>';">Put a Tender</button> 
                            </div>
                            <div class="col-md-6">
                                <button class="btn btn-default" role="button"  onclick="location.href = '<?php echo site_url('/materials/'.$material['rm_slug']); ?>';">Read More</button>
                            </div>
                        </div>
                    </p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    </div>