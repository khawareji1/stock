<?php

	class Vendors extends CI_Controller{

		// Register user
		public function register(){

			// Check if the user is already logged in.
			if($this->session->userdata('logged_in')){
				redirect('home');
			}

            $data['title'] = 'Sign Up for Vendors';
            
			$this->form_validation->set_rules('firstName', 'FirstName', 'required');
			$this->form_validation->set_rules('lastName', 'LastName', 'required');
			$this->form_validation->set_rules('username', 'Username', 'required|callback_check_username_exists');
			$this->form_validation->set_rules('email', 'Email', 'required|callback_check_email_exists');
			$this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('password2', 'Confirm Password', 'matches[password]');
            
			if($this->form_validation->run() === FALSE){
				$this->load->view('templates/header', $data);
				$this->load->view('vendors/register', $data);
				$this->load->view('templates/footer');
			} else {
				// Encrypt password
				$enc_password = md5($this->input->post('password'));
				$this->vendor_model->register($enc_password);
				// Set message
				$this->session->set_flashdata('flash-success', 'You are now registered. Log In to continue');
				redirect('userdashboard');
			}
		}


		// Check if username exists
		public function check_username_exists($username){
			$this->form_validation->set_message('check_username_exists', 'Username is taken');
			if($this->user_model->check_username_exists($username)){
				return true;
			} else {
				return false;
			}
		}

		// Check if email exists
		public function check_email_exists($email){
			$this->form_validation->set_message('check_email_exists', 'This e-mail has already been registered');
			if($this->user_model->check_email_exists($email)){
				return true;
			} else {
				return false;
			}
		}

		// user tender management
		public function vendorTenders(){

			$this->tender_model->checkExpiryStatus();
			
			$data['title'] = "Manage Tenders";
			
			$data['completedTenders'] = $this->tender_model->vendorTenders("completed");
			$data['ongoingTenders'] = $this->tender_model->vendorTenders("ongoing");

			$this->load->view('templates/header', $data);
			$this->load->view('vendors/vendorTenders', $data);
			$this->load->view('templates/footer');
		}

		//Add new address
		public function newAddress(){
			
			// Check if the user is already logged in.
			if(!$this->session->userdata('logged_in')){
				redirect('home');
			}
			
			$this->vendor_model->newAddress();
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
				$this->vendor_model->delAddress($address);
				// Set message
				$this->session->set_flashdata('flash-success', 'Address Deleted');
				redirect('userdashboard');
			}
			
		}
		
		//Delete materials
		public function delVendorMaterial($material = NULL){
			
			// Check if the user is already logged in.
			if(!$this->session->userdata('logged_in')){
				redirect('home');
			}
			// No address passed
			elseif($material === NULL){
				$this->session->set_flashdata('flash-warning', 'Material does not exist');
				redirect('userdashboard');
			}
			//execute code
			else{
				$this->vendor_model->delVendorMaterial($material);
				// Set message
				$this->session->set_flashdata('flash-success', 'Material Deleted');
				redirect('userdashboard');
			}
			
		}
        public function editUserDetails(){
			$id = $this->session->userdata('user_id');
			// user data array
			$data = array(
				'v_firstname' => $this->input->post('firstName'),
				'v_lastname' => $this->input->post('lastName'),
				'v_username' => $this->input->post('username'),
                'v_org_name' => $this->input->post('orgname'),
				'v_website' => $this->input->post('website'),
				'v_exprt_mthd' => $this->input->post('exptMethod')
			);
			// Edit address
			$this->db->where('v_id', $id);
            $this->session->set_flashdata('flash-success', 'Profile Updated');
			$this->db->update('vendors', $data);
            redirect('userdashboard');
            
		}

		
		//Add new vendor material
		public function newVendorMaterial(){
			
			// Check if the user is already logged in.
			if(!$this->session->userdata('logged_in')){
				redirect('home');
			}
			
			$this->vendor_model->newVendorMaterial();
			// Set message
			$this->session->set_flashdata('flash-success', 'material added successfully. You will be notified if a tender is created');
			redirect('userdashboard');
			
		}
		
	}