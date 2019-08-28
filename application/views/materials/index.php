<div class="container">
    

    
    <!-- <?php //foreach($materials as $material) : ?>
        <h3><?php //echo $material['rm_name']; ?></h3>

        <div class="row">
                <div class="col-md-3">
                <img class="post-thumb thumbnail" src="<?php //echo asset_url().'images/materials/'.$material['rm_pic'];?>" >
                </div>
                <div class="col-md-9">
                    <small class="material-date">Posted on: <?php //echo $material['rm_created_at']; ?> in <strong><?php //echo $material['subcat_name'];?></strong></small><br>
                    <?php //echo word_limiter($material['rm_desc'],60); ?>
                <br><br>
                <p><a class="btn btn-default" role="button" href="<?php //echo site_url('/materials/'.$material['rm_slug']); ?>">Read More</a></p>
                </div>
        </div>
    <?php //endforeach; ?> -->


    <!-- <div id="sidebar-menu" class="col-md-2 hidden-xs hidden-sm">
        <ul class="main-menu nav nav-pills nav-stacked affix">
            <li><a href="#Wood">Wood</a></li>
            <li><a href="#Glass">Glass</a></li>
    	</ul>
    </div> -->
</div>

<!-- test -->



<div class="row" data-spy="scroll" data-target="#sidebar-menu" data-offset="20">
    <nav id="sidebar-menu" class="col-md-1 col-md-offset-1 hidden-xs hidden-sm"  >
        <ul class="main-menu nav nav-stacked affix"> <!-- GETTING THE VALUES FROM RANDOM.JS -->
    	</ul>
    </nav>

    <div id="static-content" class="col-md-10">
    <center><h1><?= $title ?></h1></center>

<!--    <input class="form-control" name="search" id="search" type="text" placeholder="Search" >
    <div class="list-group" id="finalResult"></div> -->

    

    <?php foreach($categorys as $category) : ?>
        <h2 id="<?php echo($category['subcat_name']) ?>" ><?= $category['subcat_name'] ?></h2>
        <div class="row display-flex" >
            <?php foreach($materials as $material) : ?>
                <?php if($material['subcat_name']===$category['subcat_name']) : ?>
                    <div class="col-sm-6 col-md-4 col-lg-3 display-flex">
                        <div class="thumbnail">
                            <img class="img-rounded" src="<?php echo asset_url().'images/materials/'.$material['rm_pic'];?>" >
                            <div class="caption">
                                <h3 class="h3-margin-top-change"><?php echo $material['rm_name']; ?></h3>
                                <p class="flex-text"><?php echo word_limiter($material['rm_desc'],30); ?><a href = "<?php echo site_url('/materials/'.$material['rm_slug']); ?>"> Read More</a></p>
                                
                                    <!-- <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12"> -->
                                            <button class="btn btn-info btn-block" role="button" onclick="location.href = '<?php echo site_url('/tenderOpen/'.$material['rm_slug']); ?>';">Create Tender</button> 
                                        <!-- </div>
                                    </div> -->
                                
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>

    
    </div>

</div>



