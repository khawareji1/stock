<?php
	class Admin_model extends CI_Model{
		public function register($enc_password){
			// User data array
			$data = array(
				'firstname' => $this->input->post('firstName'),
				'lastname' => $this->input->post('lastName'),
                'username' => $this->input->post('username'),
                'password' => $enc_password
			);
			// Insert user
			return $this->db->insert('admins', $data);
		}
		// Log user in
		public function login($username, $password){
			// Validate
			$this->db->where('username', $username);
			$this->db->where('password', $password);
			$result = $this->db->get('admins');
			if($result->num_rows() == 1){
				$getres[0] = $result->row(0)->id;
				$getres[1] = $result->row(0)->firstname;
				$getres[2] = $result->row(0)->lastname;
				return $getres;
			} else {
				return false;
			}
		}
		// Check username exists
		public function check_username_exists($username){
			$query = $this->db->get_where('admins', array('username' => $username));
			if(empty($query->row_array())){
				return true;
			} else {
				return false;
			}
		}

		public function get_manufacturers(){
			$query = $this->db->get('manufacturers');
			return $query->result_array();
		}

		public function get_vendors(){
			$query = $this->db->get('vendors');
			return $query->result_array();
		}
		
		public function rmManuf(){
			return $this->db->delete('manufacturers', array('m_id' => $this->input->post('id'))); 
		}
		
		public function rmVen(){
			return $this->db->delete('vendors', array('v_id' => $this->input->post('id'))); 
		}

		public function get_reports(){
			$query = $this->db->get('report');
			return $query->result_array();
		}
		
		public function reportUser($accused){
			$data = array(
				'user_id' => $this->session->userdata('user_id'),
				'accused_id' => $accused,
				'message' => $this->input->post('message'),
				'report_type' => $this->input->post('rp_type')
			);
			return $this->db->insert('report', $data);
		}
	}