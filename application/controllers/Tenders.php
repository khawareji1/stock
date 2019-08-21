<?php

	class Tenders extends CI_Controller{

		public function index(){

            $data['title'] = 'Tenders';

            $data['tenders'] = $this->tender_model->get_tenders();

            $this->tender_model->checkExpiryStatus();
            

            $this->load->view('templates/header', $data);
            $this->load->view('tenders/index', $data);
            $this->load->view('templates/footer');
        }

        public function view($slug = NULL){
            $data['tender'] = $this->tender_model->get_tenders($slug);
            $data['DiffVendorRequests'] = $this->tender_model->get_diffVendorReq($data['tender']['tender_id']);
            $data['transaction'] = $this->tender_model->get_transaction($data['tender']['tender_id']);
            // print_r( $data['transaction']);
            // print_r( $data['DiffVendorRequests']);
            // print_r( $data['tender']);

            if(empty($data['tender'])){
                show_404();
            }

            $data['title'] =$data['tender']['tender_id'];


            $this->load->view('templates/header' , $data);
			$this->load->view('tenders/view', $data);
			$this->load->view('templates/footer');
        }

        public function tenderRequest($tenderID , $id){
            
            // Check if the user is not logged in.
			if(!$this->session->userdata('logged_in')){
                // Set message
                $this->session->set_flashdata('flash-warning', 'Please Log In to continue');
                redirect('users/login');
            }

            //Check if the user is vendor or not
            if($this->session->userdata('usertype') === 'manufacturer'){
                // Set message
                $this->session->set_flashdata('flash-warning', 'Only Vendors can send requests.');
                redirect('home');
            }

            $this->tender_model->tenderRequest($tenderID);
            $this->session->set_flashdata('flash-success', 'Tender Request Send');
            $this->tender_model->sendNotificationMessageToOne($id, "A Tender Request Recieved. <a href='tenders/view/$tenderID'>View</a>");
			redirect('home');
        }

        public function acptRequests($reqID){
            
            // Check if the user is not logged in.
			if(!$this->session->userdata('logged_in')){
                // Set message
                $this->session->set_flashdata('flash-warning', 'Please Log In to continue');
                redirect('users/login');
            }

            $this->tender_model->acptRequests($reqID);

            $this->session->set_flashdata('flash-success', 'Vendor Request Accepted');
			redirect('users/userTenders');
        }

        public function declRequests($reqID){
            
            // Check if the user is not logged in.
			if(!$this->session->userdata('logged_in')){
                // Set message
                $this->session->set_flashdata('flash-warning', 'Please Log In to continue');
                redirect('users/login');
            }

            $this->tender_model->declRequests($reqID);
            
            $this->session->set_flashdata('flash-success', 'Vendor Request Declined');
			redirect('users/userTenders');
        }

        public function changeStatus($transID){
            $tender_id = $this->tender_model->changeStatus($transID);            
            $this->session->set_flashdata('flash-success', 'Transaction Status Changed.');
            redirect('tenders/view/'.$tender_id);
        }

        public function changeETA($transID){
            $tender_id = $this->tender_model->changeETA($transID);            
            $this->session->set_flashdata('flash-success', 'Transaction ETA Changed.');
            redirect('tenders/view/'.$tender_id);
        }

        public function cancelTender($tenderID){
            // Check if the user is not logged in.
			if(!$this->session->userdata('logged_in')){
                // Set message
                $this->session->set_flashdata('flash-warning', 'Please Log In to continue');
                redirect('users/login');
            }

            $tenders = $this->tender_model->get_tenders($tenderID);
            // validation : only the manufacturer can run this
            if($tenders['m_id'] != $this->session->userdata('user_id')){
                $this->session->set_flashdata('flash-warning', 'Unauthorized access (Code 401)');
                redirect('home');
            }   
            
            $this->tender_model->cancelTender($tenderID);

            $this->session->set_flashdata('flash-success', 'Tender Cancelled.');
            redirect('home');
        }

        public function deliveryComplete($tenderID){
            // Check if the user is not logged in.
			if(!$this->session->userdata('logged_in')){
                // Set message
                $this->session->set_flashdata('flash-warning', 'Please Log In to continue');
                redirect('users/login');
            }

            $tenders = $this->tender_model->get_tenders($tenderID);
            
            // validation : only the manufacturer can run this
            if($tenders['m_id'] != $this->session->userdata('user_id')){
                $this->session->set_flashdata('flash-warning', 'Unauthorized access (Code 401)');
                redirect('home');
            }   
            
            $this->tender_model->deliveryComplete($tenderID);

            $this->session->set_flashdata('flash-success', 'Tender Completed.');
            redirect('home');
        }

        public function deliveryNotGet($transID){
            $tender_id = $this->tender_model->deliveryNotGet($transID);            
            redirect('tenders/view/'.$tender_id);
        }

        public function print($tender_id = NULL){
            if($tender_id === NULL){
                redirect('home');
            }
            $data['tender'] = $this->tender_model->get_tenders($tender_id);
            $data['DiffVendorRequests'] = $this->tender_model->get_diffVendorReq($data['tender']['tender_id']);
            $data['transaction'] = $this->tender_model->get_transaction($data['tender']['tender_id']);
            $data['address_arr'] = $this->user_model->get_address(1,$data['tender']['delivery_location']);

            // print_r($data);
			$this->load->view('tenders/print',$data);
        }


        
	}