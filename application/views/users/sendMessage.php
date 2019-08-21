
<?php echo form_open('users/sendMessage/'.($toID)); ?>
    <div class="row">

        <div class="col-md-4 col-md-offset-4  col-sm-4 col-sm-offset-4 col-xs-10 col-xs-offset-1">

        <h1 class="text-center"><?= $title; ?></h1>


            <div class="form-group">
				<label>To</label>
				<div class="input-group">
					<p class="form-control-static"><?= $name1; ?> <?= $name2; ?></p>
				</div>
			</div>

           <div class="form-group">
                <label>Message</label>
                <div class="input-group"> 
                    <span class="input-group-addon"><i class="glyphicon glyphicon-comment"></i></span>
                    <textarea class="form-control" rows="8" id="message" placeholder="Max 300 characters" maxlength="300" name="message" required></textarea>
                </div>
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