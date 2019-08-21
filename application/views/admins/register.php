<head>

<link rel="stylesheet" type="text/css"  href="assets/css/bootstrap.min.css" />

    <link rel="stylesheet" type="text/css"  href="assets/css/style.css" />
    <link rel="stylesheet" type="text/css"  href="assets/css/animate.min.css" />
    <link rel="stylesheet" type="text/css"  href="<?php echo asset_url();?>assets/css/awesomplete.css" />
    <link rel="stylesheet" type="text/css"  href="assets/css/fontawesome-all.min.css" />


</head>

<?php echo form_open('admins/register',' id="reg_form"'); ?>
	<div class="row">

		<div class="col-md-4 col-md-offset-4  col-sm-4 col-sm-offset-4 col-xs-10 col-xs-offset-1">

			<h1 class="text-center"><?= $title; ?></h1>

			<p  class="text-center"> <?php echo validation_errors(); ?></p>



				<label>Full name</label>
				<div class="row">
					<div class="col-xs-6">
						<div class="form-group">
							<div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
								<input type="text" class="form-control" name="firstName" placeholder="First name" />
							</div>
						</div>
					</div>
					<div class="col-xs-6">
						<div class="form-group">
							<div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
								<input type="text" class="form-control" name="lastName" placeholder="Last name" />
							</div>
						</div>
					</div>
				</div>

			<div class="form-group">
				<label>Username</label>
				<div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
					<input type="text" class="form-control" name="username" placeholder="Username" required/>
				</div>
			</div>
			<div class="form-group">
				<label>Password</label>
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
			<button type="submit" class="btn btn-primary btn-block">Submit</button>

		</div>

	</div>
	
<?php echo form_close(); ?>


<!-- 
<script type="text/javascript" src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script type="text/javascript" src='http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js'></script>
<script type="text/javascript" src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.5.3/js/bootstrapValidator.js'></script> -->
