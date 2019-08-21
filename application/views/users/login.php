
<div class="row">
	<div class="col-md-4 col-md-offset-4  col-sm-4 col-sm-offset-4 col-xs-10 col-xs-offset-1">
		<?php echo form_open('users/login'); ?>
			<h1 class="text-center"><?php echo $title; ?></h1>
			<div class="form-group">
				<input type="text" name="username" class="form-control" placeholder="Enter Username" required autofocus>
				
			</div>
			<div class="form-group">
				<input type="password" name="password" class="form-control" placeholder="Enter Password" required autofocus>
			</div>
			
			<button type="submit" class="btn btn-primary btn-block">Login</button>
		<?php echo form_close(); ?>
		
		<br>
		
		<div style="text-align:center">
  			<a href="#" data-toggle="modal" data-target="#forgotPassModel">Forgot Password?</a>​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​
		</div>

	</div>
</div>

<!-- forgotPassModel Modal -->
<div class="modal fade" id="forgotPassModel" role="dialog">
	<div class="modal-dialog">
		<!-- Add Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Forgot Password?</h4>
			</div>
			<div class="modal-body">
				
			<?php echo form_open('users/forgotpassword'); ?>

				<div class="form-group">
					<label>Enter your Email ( A Recovery Email will be sent )</label>
					<div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
						<input type="email" class="form-control" name="email" placeholder="Email" required/>
					</div>
				</div>
				
				<button type="submit" class="btn btn-success btn-block">Submit</button>

			<?php echo form_close(); ?>

			</div>
			
		</div>
	</div>
</div>