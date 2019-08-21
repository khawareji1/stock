<?php

	class Admins extends CI_Controller{

		public function rmManuf(){
			// Check if the user is already logged in.
			if(!$this->session->userdata('logged_in')){
				redirect('home');
			}
			elseif($this->session->userdata('usertype') != 'shadmin'){
				redirect('home');
			}
			$this->admin_model->rmManuf();
			$this->session->set_flashdata('flash-success', 'Manufacturer removed');
			redirect('userdashboard');
		}

		public function rmVen(){
			// Check if the user is already logged in.
			if(!$this->session->userdata('logged_in')){
				redirect('home');
			}
			elseif($this->session->userdata('usertype') != 'shadmin'){
				redirect('home');
			}
			$this->admin_model->rmVen();
			$this->session->set_flashdata('flash-success', 'Vendor removed');
			redirect('userdashboard');
		}
		
		public function reportUser($accused){
			// Check if the user is already logged in.
			if(!$this->session->userdata('logged_in')){
				redirect('home');
			}
			$this->admin_model->reportUser($accused);
			$this->session->set_flashdata('flash-success', 'Report Submitted');
			redirect('userdashboard');
		}
	}