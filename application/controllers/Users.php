<?php

	class Users extends CI_Controller{

		// Register user
		public function register(){

			// Check if the user is already logged in.
			if($this->session->userdata('logged_in')){
				redirect('home');
			}

            $data['title'] = 'Sign Up';
            
			$this->form_validation->set_rules('firstName', 'FirstName', 'required');
			$this->form_validation->set_rules('lastName', 'LastName', 'required');
			$this->form_validation->set_rules('username', 'Username', 'required|callback_check_username_exists');
			$this->form_validation->set_rules('email', 'Email', 'required|callback_check_email_exists');
			$this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('password2', 'Confirm Password', 'matches[password]');
            
			if($this->form_validation->run() === FALSE){
				$this->load->view('templates/header', $data);
				$this->load->view('users/register', $data);
				$this->load->view('templates/footer');
			} else {
				// Encrypt password
				$enc_password = md5($this->input->post('password'));
				$this->user_model->register($enc_password);
				// Set message
				$this->session->set_flashdata('flash-success', 'You are now registered. Log In to continue');
				redirect('userdashboard');
			}
		}


		// Log in user
		public function login(){
			
			// Check if the user is already logged in.
			if($this->session->userdata('logged_in')){
				redirect('home');
			}

			$data['title'] = 'Login';

			$this->form_validation->set_rules('username', 'Username', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');
			if($this->form_validation->run() === FALSE){
				$this->load->view('templates/header', $data);
				$this->load->view('users/login', $data);
				$this->load->view('templates/footer');
			} else {
				
				
				// Get username
				$username = $this->input->post('username');
				// Get and encrypt the password
				$password = md5($this->input->post('password'));

				// CHECKING IN USERS TABLE
				// Login user
				$getres = $this->user_model->login($username, $password);

				if($getres){
					// Create session
					$user_data = array(
						'user_id' => $getres[0],
						'first_name' => $getres[1],
						'last_name' => $getres[2],
						'username' => $username,
						'usertype' => 'manufacturer',
						'logged_in' => true
					);
					$this->session->set_userdata($user_data);
					// Set message
					$this->session->set_flashdata('flash-success', 'You are now logged in');
					redirect('home');
				} else {

						// CHECKING IN VENDORS TABLE
						// Login admin
						$getres = $this->vendor_model->login($username, $password);
						if($getres){
							// Create session
							$user_data = array(
								'user_id' => $getres[0],
								'first_name' => $getres[1],
								'last_name' => $getres[2],
								'username' => $username,
								'usertype' => 'vendor',
								'logged_in' => true
							);
							$this->session->set_userdata($user_data);
							// Set message
							$this->session->set_flashdata('flash-success', 'You are now logged in');
							redirect('users/userdashboard');
						} else {
							
								// CHECKING IN ADMINS TABLE
								// Login admin
								$getres = $this->admin_model->login($username, $password);
								if($getres){
									// Create session
									$user_data = array(
										'user_id' => $getres[0],
										'first_name' => $getres[1],
										'last_name' => $getres[2],
										'username' => $username,
										'usertype' => 'shadmin',
										'logged_in' => true
									);
									$this->session->set_userdata($user_data);
									// Set message
									$this->session->set_flashdata('flash-success', 'You are now logged in');
									redirect('home');
								} else {
									// Set message
									$this->session->set_flashdata('flash-danger', 'Login details invalid');
									redirect('users/login');
								}
						}	
				}		
			}
		}

		// Log user out
		public function logout(){
			// Unset user data
			$this->session->unset_userdata('logged_in');
			$this->session->unset_userdata('user_id');
			$this->session->unset_userdata('username');
			$this->session->unset_userdata('first_name');
            $this->session->unset_userdata('last_name');
            $this->session->unset_userdata('usertype');
			// Set message
			$this->session->set_flashdata('flash-success', 'You are now logged out');
			redirect('home');
		}

	/*	// forgot password
		public function forgotpassword(){

    $email=$_POST["email"];
$conn = mysqli_connect("localhost","root","","stockhub");
if(mysqli_connect_error())
	{
	echo "failed to connect";
	}
$sql = "SELECT * FROM manufacturers WHERE m_email='".$email."'";
$res = $conn->query($sql);
            
$count = mysqli_num_rows($res);
	if($count == 1){
		echo "Send email to user with password";
	}else{
		echo "User name does not exist in database";
	}
$r = mysqli_fetch_assoc($res);
$password = $r['m_password'];
$to = $r['m_email'];
$subject = "Your Recovered Password";
$message = "Please use this password to login " . $password;
$headers = "From : khawarey16@gmail.com";
        
if(mail($to, $subject, $message, $headers))
{
	echo "Your Password has been sent to your email id";
}else{
	echo "Failed to Recover your password, try again";
}
       
        }
*/
        
        		// forgot password
		public function forgotpassword(){
			$email = $this->input->post('email');
			$id = $this->user_model->check_email_exists($email, 1);
			if(!empty($id)){
				
				$seed = str_split('abcdefghijklmnopqrstuvwxyz'
								.'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
								.'0123456789!@#$%^&*()');
				$rand = '';
				foreach (array_rand($seed, 10) as $k) $rand .= $seed[$k];

				$hashpass = md5($rand);

				$this->user_model->changePassword($hashpass , $id);
				$this->send_mail($email, 'recovery' , $rand);

			} else {
				$this->session->set_flashdata('flash-warning', 'Incorrect Email. Please provide an email which is given while registration.');
				redirect('users/login');
			}
		}

		public function send_mail($to, $type = NULL , $password = NULL) { 

			$config = Array(
				'protocol' => 'smtp',
				'smtp_host' => 'ssl://smtp.googlemail.com',
				'smtp_port' => 465,
				'smtp_user' =>'khawarey16@gmail.com',
				'smtp_pass' => '7209945082',
				'mailtype'  => 'html', 
				'charset'   => 'iso-8859-1'
			);
            
			$this->load->library('email', $config);
			$this->email->set_newline("\r\n");

			if($type === NULL){
				$this->session->set_flashdata("flash-danger","Internal Error : Mail Type not defined.");
				redirect('home');
			}
			elseif($type === 'recovery'){
				$subject = 'Password Recovery - StockHUB';
				$message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml">
				  <head>
					<meta name="viewport" content="width=device-width, initial-scale=1.0" />
					<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
					<title>Set up a new password</title>
					<!--
					The style block is collapsed on page load to save you some scrolling.
					Postmark automatically inlines all CSS properties for maximum email client
					compatibility. You can just update styles here, and Postmark does the rest.
					-->
					<style type="text/css" rel="stylesheet" media="all">
					/* Base ------------------------------ */
				
					*:not(br):not(tr):not(html) {
					  font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
					  box-sizing: border-box;
					}
				
					body {
					  width: 100% !important;
					  height: 100%;
					  margin: 0;
					  line-height: 1.4;
					  background-color: #F2F4F6;
					  color: #74787E;
					  -webkit-text-size-adjust: none;
					}
				
					p,
					ul,
					ol,
					blockquote {
					  line-height: 1.4;
					  text-align: left;
					}
				
					a {
					  color: #3869D4;
					}
				
					a img {
					  border: none;
					}
				
					td {
					  word-break: break-word;
					}
					/* Layout ------------------------------ */
				
					.email-wrapper {
					  width: 100%;
					  margin: 0;
					  padding: 0;
					  -premailer-width: 100%;
					  -premailer-cellpadding: 0;
					  -premailer-cellspacing: 0;
					  background-color: #F2F4F6;
					}
				
					.email-content {
					  width: 100%;
					  margin: 0;
					  padding: 0;
					  -premailer-width: 100%;
					  -premailer-cellpadding: 0;
					  -premailer-cellspacing: 0;
					}
					/* Masthead ----------------------- */
				
					.email-masthead {
					  padding: 25px 0;
					  text-align: center;
					}
				
					.email-masthead_logo {
					  width: 94px;
					}
				
					.email-masthead_name {
					  font-size: 16px;
					  font-weight: bold;
					  color: #bbbfc3;
					  text-decoration: none;
					  text-shadow: 0 1px 0 white;
					}
					/* Body ------------------------------ */
				
					.email-body {
					  width: 100%;
					  margin: 0;
					  padding: 0;
					  -premailer-width: 100%;
					  -premailer-cellpadding: 0;
					  -premailer-cellspacing: 0;
					  border-top: 1px solid #EDEFF2;
					  border-bottom: 1px solid #EDEFF2;
					  background-color: #FFFFFF;
					}
				
					.email-body_inner {
					  width: 570px;
					  margin: 0 auto;
					  padding: 0;
					  -premailer-width: 570px;
					  -premailer-cellpadding: 0;
					  -premailer-cellspacing: 0;
					  background-color: #FFFFFF;
					}
				
					.email-footer {
					  width: 570px;
					  margin: 0 auto;
					  padding: 0;
					  -premailer-width: 570px;
					  -premailer-cellpadding: 0;
					  -premailer-cellspacing: 0;
					  text-align: center;
					}
				
					.email-footer p {
					  color: #AEAEAE;
					}
				
					.body-action {
					  width: 100%;
					  margin: 30px auto;
					  padding: 0;
					  -premailer-width: 100%;
					  -premailer-cellpadding: 0;
					  -premailer-cellspacing: 0;
					  text-align: center;
					}
				
					.body-sub {
					  margin-top: 25px;
					  padding-top: 25px;
					  border-top: 1px solid #EDEFF2;
					}
				
					.content-cell {
					  padding: 35px;
					}
				
					.preheader {
					  display: none !important;
					  visibility: hidden;
					  mso-hide: all;
					  font-size: 1px;
					  line-height: 1px;
					  max-height: 0;
					  max-width: 0;
					  opacity: 0;
					  overflow: hidden;
					}
					/* Attribute list ------------------------------ */
				
					.attributes {
					  margin: 0 0 21px;
					}
				
					.attributes_content {
					  background-color: #EDEFF2;
					  padding: 16px;
					}
				
					.attributes_item {
					  padding: 0;
					}
					/* Related Items ------------------------------ */
				
					.related {
					  width: 100%;
					  margin: 0;
					  padding: 25px 0 0 0;
					  -premailer-width: 100%;
					  -premailer-cellpadding: 0;
					  -premailer-cellspacing: 0;
					}
				
					.related_item {
					  padding: 10px 0;
					  color: #74787E;
					  font-size: 15px;
					  line-height: 18px;
					}
				
					.related_item-title {
					  display: block;
					  margin: .5em 0 0;
					}
				
					.related_item-thumb {
					  display: block;
					  padding-bottom: 10px;
					}
				
					.related_heading {
					  border-top: 1px solid #EDEFF2;
					  text-align: center;
					  padding: 25px 0 10px;
					}
					/* Discount Code ------------------------------ */
				
					.discount {
					  width: 100%;
					  margin: 0;
					  padding: 24px;
					  -premailer-width: 100%;
					  -premailer-cellpadding: 0;
					  -premailer-cellspacing: 0;
					  background-color: #EDEFF2;
					  border: 2px dashed #9BA2AB;
					}
				
					.discount_heading {
					  text-align: center;
					}
				
					.discount_body {
					  text-align: center;
					  font-size: 15px;
					}
					/* Social Icons ------------------------------ */
				
					.social {
					  width: auto;
					}
				
					.social td {
					  padding: 0;
					  width: auto;
					}
				
					.social_icon {
					  height: 20px;
					  margin: 0 8px 10px 8px;
					  padding: 0;
					}
					/* Data table ------------------------------ */
				
					.purchase {
					  width: 100%;
					  margin: 0;
					  padding: 35px 0;
					  -premailer-width: 100%;
					  -premailer-cellpadding: 0;
					  -premailer-cellspacing: 0;
					}
				
					.purchase_content {
					  width: 100%;
					  margin: 0;
					  padding: 25px 0 0 0;
					  -premailer-width: 100%;
					  -premailer-cellpadding: 0;
					  -premailer-cellspacing: 0;
					}
				
					.purchase_item {
					  padding: 10px 0;
					  color: #74787E;
					  font-size: 15px;
					  line-height: 18px;
					}
				
					.purchase_heading {
					  padding-bottom: 8px;
					  border-bottom: 1px solid #EDEFF2;
					}
				
					.purchase_heading p {
					  margin: 0;
					  color: #9BA2AB;
					  font-size: 12px;
					}
				
					.purchase_footer {
					  padding-top: 15px;
					  border-top: 1px solid #EDEFF2;
					}
				
					.purchase_total {
					  margin: 0;
					  text-align: right;
					  font-weight: bold;
					  color: #2F3133;
					}
				
					.purchase_total--label {
					  padding: 0 15px 0 0;
					}
					/* Utilities ------------------------------ */
				
					.align-right {
					  text-align: right;
					}
				
					.align-left {
					  text-align: left;
					}
				
					.align-center {
					  text-align: center;
					}
					/*Media Queries ------------------------------ */
				
					@media only screen and (max-width: 600px) {
					  .email-body_inner,
					  .email-footer {
						width: 100% !important;
					  }
					}
				
					@media only screen and (max-width: 500px) {
					  .button {
						width: 100% !important;
					  }
					}
					/* Buttons ------------------------------ */
				
					.button {
					  background-color: #3869D4;
					  border-top: 10px solid #3869D4;
					  border-right: 18px solid #3869D4;
					  border-bottom: 10px solid #3869D4;
					  border-left: 18px solid #3869D4;
					  display: inline-block;
					  color: #FFF;
					  text-decoration: none;
					  border-radius: 3px;
					  box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16);
					  -webkit-text-size-adjust: none;
					}
				
					.button--green {
					  background-color: #22BC66;
					  border-top: 10px solid #22BC66;
					  border-right: 18px solid #22BC66;
					  border-bottom: 10px solid #22BC66;
					  border-left: 18px solid #22BC66;
					}
				
					.button--red {
					  background-color: #FF6136;
					  border-top: 10px solid #FF6136;
					  border-right: 18px solid #FF6136;
					  border-bottom: 10px solid #FF6136;
					  border-left: 18px solid #FF6136;
					}
					/* Type ------------------------------ */
				
					h1 {
					  margin-top: 0;
					  color: #2F3133;
					  font-size: 19px;
					  font-weight: bold;
					  text-align: left;
					}
				
					h2 {
					  margin-top: 0;
					  color: #2F3133;
					  font-size: 16px;
					  font-weight: bold;
					  text-align: left;
					}
				
					h3 {
					  margin-top: 0;
					  color: #2F3133;
					  font-size: 14px;
					  font-weight: bold;
					  text-align: left;
					}
				
					p {
					  margin-top: 0;
					  color: #74787E;
					  font-size: 16px;
					  line-height: 1.5em;
					  text-align: left;
					}
				
					p.sub {
					  font-size: 12px;
					}
				
					p.center {
					  text-align: center;
					}
					</style>
				  </head>
				  <body>
					<span class="preheader">Use this link to reset your password. The link is only valid for 24 hours.</span>
					<table class="email-wrapper" width="100%" cellpadding="0" cellspacing="0">
					  <tr>
						<td align="center">
						  <table class="email-content" width="100%" cellpadding="0" cellspacing="0">
							<tr>
							  <td class="email-masthead">
								<a href="www.stockhub.tk" class="email-masthead_name">
						StockHub
					  </a>
							  </td>
							</tr>
							<!-- Email Body -->
							<tr>
							  <td class="email-body" width="100%" cellpadding="0" cellspacing="0">
								<table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0">
								  <!-- Body content -->
								  <tr>
									<td class="content-cell">
									  <h1>Hi,</h1>
									  <p>You recently requested to reset your password for your <strong></strong>StockHub</strong> account. Follow the instructions to change it. <br><br><strong>Your Password is successfully changed to "'.$password.'" (without the quotes)</strong></p>
									  <!-- Action -->
									  <table class="body-action" align="center" width="100%" cellpadding="0" cellspacing="0">
										<tr>
										  <td align="center">
											<!-- Border based button
									   https://litmus.com/blog/a-guide-to-bulletproof-buttons-in-email-design -->
										 
									  <p>You can now login to your account using this temporary password and change it in the dashboard</p>
									  <p>Thanks,
										<br>The StockHub Team</p>
									  <!-- Sub copy -->
									  <table class="body-sub">
										<tr>
										  <td>
											<p class="sub">For security reasons, do not share this temporary password with anyone. If you did not request a password reset, please ignore this email or contact the StockHub support if you have questions</p>
											<p class="sub" align="center>www.stockhub.tk</p>
										  </td>
										</tr>
									  </table>
									</td>
								  </tr>
								</table>
							  </td>
							</tr>
							<tr>
							  <td>
								<table class="email-footer" align="center" width="570" cellpadding="0" cellspacing="0">
								  <tr>
									<td class="content-cell" align="center">
									  <p class="sub align-center">&copy; 2018 StockHub. All rights reserved.</p>
									  <p class="sub align-center">
										Christ University,
										Bangalore
									  </p>
									</td>
								  </tr>
								</table>
							  </td>
							</tr>
						  </table>
						</td>
					  </tr>
					</table>
				  </body>
				</html>';
		
				// $this->email->initialize($config);
				$this->email->from('khawarey16@gmail.com');
				$this->email->to($to);
				$this->email->subject($subject);
				$this->email->message($message);
		
				//Send mail 
				if($this->email->send()){
					$this->session->set_flashdata("flash-success","Email sent successfully.");
					redirect('users/login');
				}
				else {
					// show_error($this->email->print_debugger());
					$this->session->set_flashdata("flash-danger","Failed to sent Email.");
					redirect('home');
				}
			}
        }
			
		// Check if username exists
		public function check_username_exists($username){
			$this->form_validation->set_message('check_username_exists', 'That username is taken. Please choose a different one');
			if($this->user_model->check_username_exists($username)){
				return true;
			} else {
				return false;
			}
		}
        




		// Check if email exists
		public function check_email_exists($email){
			$this->form_validation->set_message('check_email_exists', 'That email is taken. Please choose a different one');
			if($this->user_model->check_email_exists($email)){
				return true;
			} else {
				return false;
			}
		}

		public function userdashboard(){
			
			// Check if the user is not logged in.
			if($this->session->userdata('logged_in')){
				if($this->session->userdata('usertype') === 'manufacturer') {

					$this->user_model->check_active_status();
					$id = $this->session->userdata('user_id');

					$data['title'] = "Manufacturer Dashboard";
					
					$data['addresses_arr'] =$this->user_model->get_address();
					$data['messages'] = $this->user_model->get_messages();
					$data['userDetails'] = $this->user_model->userIDInfo($id);
					
					$this->load->view('templates/header', $data);
					$this->load->view('users/userdashboard', $data);
					$this->load->view('templates/footer');

				}
				elseif($this->session->userdata('usertype') === 'vendor') {

					$this->vendor_model->check_active_status();

					$id = $this->session->userdata('user_id');

					$data['title'] = "Vendor Dashboard";
					
					$data['addresses_arr'] = $this->user_model->get_address();
					$data['vendorMaterials'] = $this->vendor_model->get_vendorMaterials();
					$data['materials'] = $this->material_model->get_materials();
					$data['messages'] = $this->user_model->get_messages();
					$data['userDetails'] = $this->user_model->userIDInfo($id);

					
					$this->load->view('templates/header', $data);
					$this->load->view('vendors/vendordashboard', $data);
					$this->load->view('templates/footer');

				}
				elseif($this->session->userdata('usertype') === 'shadmin') {

					$data['title'] = "Admin Dashboard";
					
					$data['manufacturers'] =$this->admin_model->get_manufacturers();
					$data['vendors'] =$this->admin_model->get_vendors();
					$data['reports'] =$this->admin_model->get_reports();
					
					$this->load->view('templates/header', $data);
					$this->load->view('admins/admindashboard', $data);
					$this->load->view('templates/footer');

				}

				else{
					redirect('home');
				}
			}
			else{
				redirect('home');
			}

			
		}


		//Add new address
		public function newAddress(){

			$data['addresses_arr'] =$this->user_model->get_address();
			
			// Check if the user is already logged in.
			if(!$this->session->userdata('logged_in')){
				redirect('home');
			}
			elseif(sizeof($data['addresses_arr']) >= 2){
				$this->session->set_flashdata('flash-warning', 'Maximum of 2 addresses can be added');
				redirect('userdashboard');
			}
			
			$this->user_model->newAddress();
			// Set message
			$this->session->set_flashdata('flash-success', 'New address added');
			redirect('userdashboard');
			
		}

		//Delete address
		public function delAddress($address = NULL){

			// Check if the user is already logged in.
			if(!$this->session->userdata('logged_in')){
				redirect('home');
			}
			// No address passed
			elseif($address === NULL){
				$this->session->set_flashdata('flash-warning', 'Address does not exist');
				redirect('userdashboard');
			}
			//execute code
			else{
				$this->user_model->delAddress($address);
				// Set message
				$this->session->set_flashdata('flash-success', 'Address Deleted');
				redirect('userdashboard');
			}
			
		}
        


		//View address before editing
		public function viewAddress($address = NULL){

			// Check if the user is already logged in.
			if(!$this->session->userdata('logged_in')){
				redirect('home');
			}
			// No address passed
			elseif($address === NULL){
				$this->session->set_flashdata('flash-warning', 'Address does not exist');
				redirect('userdashboard');
			}
			//execute code
			else{
				$data['title'] = "Edit Address";
				$data['address_arr'] =$this->user_model->get_address(1,$address);
				$this->load->view('templates/header', $data);
				$this->load->view('users/viewAddress', $data);
				$this->load->view('templates/footer');
			}
			
		}



		//Edit address
		public function editAddress($address = NULL){

			// Check if the user is already logged in.
			if(!$this->session->userdata('logged_in')){
				redirect('home');
			}
			// No address passed
			elseif($address === NULL){
				$this->session->set_flashdata('flash-warning', 'Address does not exist');
				redirect('userdashboard');
			}
			//execute code
			else{
				$this->user_model->editAddress($address);
				// Set message
				$this->session->set_flashdata('flash-success', 'Address details changed');
				redirect('userdashboard');
			}
			
		}

		// user tender management
		public function userTenders(){

			$this->tender_model->checkExpiryStatus();

			if($this->session->userdata('usertype') === 'vendor'){
				redirect('vendors/vendorTenders');
			}
			
			$data['title'] = "Manage Tenders";

			$data['activeTenders'] = $this->tender_model->userTenders("active");
			$data['expiredTenders'] = $this->tender_model->userTenders("expired");
			$data['completedTenders'] = $this->tender_model->userTenders("completed");
			$data['ongoingTenders'] = $this->tender_model->userTenders("ongoing");


			$this->load->view('templates/header', $data);
			$this->load->view('users/userTenders', $data);
			$this->load->view('templates/footer');
		}

		//Delete message
		public function delMessage($message = NULL){

			// Check if the user is already logged in.
			if(!$this->session->userdata('logged_in')){
				redirect('home');
			}
			// No message passed
			elseif($message === NULL){
				$this->session->set_flashdata('flash-warning', 'Message does not exist');
				redirect('userdashboard');
			}
			//execute code
			else{
				$this->user_model->delMessage($message);
				// Set message
				$this->session->set_flashdata('flash-success', 'Message Deleted');
				redirect('userdashboard');
			}
			
		}
		
		//Send message
		public function sendMessage($toID = NULL){
			$this->user_model->sendMessage($toID);	
			$this->session->set_flashdata('flash-success', 'Message Sent');
			redirect('users/messages/'.$toID);	
		}
		
		//Send message
		public function sendFeedback($toID = NULL){
			$this->user_model->sendFeedback($toID);	
			$this->session->set_flashdata('flash-success', 'Feedback Sent');
			redirect('userdashboard');	
		}
		//direct message
		public function messages($id1 = NULL){

			// Check if the user is already logged in.
			if(!$this->session->userdata('logged_in')){
				redirect('home');
			}
			// No toID passed
			else{

				$id2 = $this->session->userdata('user_id');
				if($id1 != $id2){
					$data['messages'] = $this->user_model->messages($id1);
					$data['id1'] = $this->user_model->userIDInfo($id1);
					$data['toID'] = $id1;
					// $data['id2'] = $this->user_model->userIDInfo($id2);
					$data['title'] = "Message";
	
					$this->load->view('templates/header', $data);
					$this->load->view('users/messages', $data);
					$this->load->view('templates/footer');
				}
				else{
					redirect('userdashboard');
				}
			}
			
		}

		// view vendor profile
		public function profile($id){
			
			$data['title'] = "Profile";
			
			$data['address_arr'] = $this->user_model->get_address(0,$id);
			$data['userDetails'] = $this->user_model->userIDInfo($id);
			$data['id'] = $id;
			
			if($id[0] === 'V'){
				$data['completedTenders'] = $this->tender_model->vendorTenders("completed",$id);
				$data['ongoingTenders'] = $this->tender_model->vendorTenders("ongoing",$id);
			}
			else{
				$data['activeTenders'] = $this->tender_model->userTenders("active",$id);
				$data['completedTenders'] = $this->tender_model->userTenders("completed",$id);
				$data['ongoingTenders'] = $this->tender_model->userTenders("ongoing",$id);
			}
			

			$this->load->view('templates/header', $data);
			$this->load->view('users/profile', $data);
			$this->load->view('templates/footer');
		}

		public function do_upload(){
			$id=$this->session->userdata('user_id');
			$config = array(
			'upload_path' => ("./assets/images/Profile_Pic/"),
			'allowed_types' => "jpg|png|jpeg",
			'overwrite' => TRUE,
			'max_size' => "2048000", // 2mb
			'max_height' => "1024",
			'max_width' => "1024",
			'file_name' => $id
			);
			$this->load->library('upload', $config);
			if($this->upload->do_upload())
			{
				$upload_data = $this->upload->data();
				$file_name = $upload_data['file_name'];

				$this->user_model->userProPic($file_name);
				$this->session->set_flashdata('flash-success', 'upload success');
				redirect('userdashboard');
			}
			else
			{
				$error = $this->upload->display_errors();
				$error=str_ireplace('<p>','',$error);
				$error=str_ireplace('</p>','',$error);  
				$this->session->set_flashdata('flash-danger', $error);
				redirect('userdashboard');
			}
		}

		public function changePass(){
			$this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('password2', 'Confirm Password', 'matches[password]');
            
			if($this->form_validation->run() === FALSE){
				$this->session->set_flashdata('flash-danger', "Incorrect Details");
				redirect('userdashboard');
			} else {
				$id=$this->session->userdata('user_id');
				$data['userDetails'] = $this->user_model->userIDInfo($id);
				$password = md5($this->input->post('password'));

				if($id[0] === 'V'){
					if($data['userDetails']['v_password'] === md5($this->input->post('cpassword'))){
						$this->user_model->changePassword($password, $id);
						$this->session->set_flashdata('flash-success', "Password Changed");
						redirect('userdashboard');
					}
					else{
						$this->session->set_flashdata('flash-danger', "Wrong Password");
						redirect('userdashboard');
					}
				}
				else{
					if($data['userDetails']['m_password'] === md5($this->input->post('cpassword'))){
						$this->user_model->changePassword($password, $id);
						$this->session->set_flashdata('flash-success', "Password Changed");
						redirect('userdashboard');
					}
					else{
						$this->session->set_flashdata('flash-danger', "Wrong Password");
						redirect('userdashboard');
					}
				}

				// Encrypt password
				$enc_password = md5($this->input->post('password'));
				$this->user_model->register($enc_password);
				// Set message
				$this->session->set_flashdata('flash-success', 'You are now registered. Log In to continue');
				redirect('userdashboard');
			}
		}
        public function editUserDetails(){
           
			$id = $this->session->userdata('user_id');
			// user data array
			$data = array(
                
				'm_firstname' => $this->input->post('firstName'),
				'm_lastname' => $this->input->post('lastName'),
				'm_username' => $this->input->post('username'),
                'm_org_name' => $this->input->post('orgname')
                
			);
            
			// Edit address
			$this->db->where('m_id', $id);
            $this->session->set_flashdata('flash-success', 'Profile Updated');
            $this->db->update('manufacturers', $data);
            redirect('userdashboard');
			
            
		}

		public function rmProPic($file_name = NULL){
			
			// Check if the user is already logged in.
			if(!$this->session->userdata('logged_in')){
				redirect('home');
			}
			elseif($file_name === NULL){
				$this->session->set_flashdata('flash-warning', "Profile Picture Not Present");
				redirect('userdashboard');
			}
			else{
				$this->user_model->rmProPic($file_name);
				$this->session->set_flashdata('flash-success', "Profile Picture Removed");
				redirect('userdashboard');
			}
			
		}





		
	}