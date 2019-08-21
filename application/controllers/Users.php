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
							redirect('home');
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

		// forgot password
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