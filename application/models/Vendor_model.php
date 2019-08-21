<?php
	class Vendor_model extends CI_Model{
		public function register($enc_password){

			$this->db->select('v_id');
			$this->db->from('vendors');
			$query = $this->db->get();

			// print_r( $query->result_array());
			$checker = 0;
			foreach( $query->result_array() as $result):
				// print_r($result["id"]);
				// $len = strlen($result["id"]);
				$num= substr($result["v_id"], 1, strlen($result["v_id"]));
				if($checker < $num ):
					$checker = $num;
				endif;
			endforeach;

			$checker++;
			$idCreated = "V".$checker;

			// User data array
			$data = array(
				'v_id' => $idCreated,
				'v_firstname' => $this->input->post('firstName'),
				'v_lastname' => $this->input->post('lastName'),
				'v_email' => $this->input->post('email'),
                'v_username' => $this->input->post('username'),
                'v_password' => $enc_password
			);
			// Insert user
			return $this->db->insert('vendors', $data);
		}
		// Log user in
		public function login($username, $password){
			// Validate
			$this->db->where('v_username', $username);
			$this->db->where('v_password', $password);
			$result = $this->db->get('vendors');
			if($result->num_rows() == 1){
				$getres[0] = $result->row(0)->v_id;
				$getres[1] = $result->row(0)->v_firstname;
				$getres[2] = $result->row(0)->v_lastname;
				return $getres;
			} else {
				return false;
			}
		}
		// Check username exists
		public function check_username_exists($username){
			$query = $this->db->get_where('vendors', array('v_username' => $username));
			if(empty($query->row_array())){
				return true;
			} else {
				return false;
			}
		}
		// Check email exists
		public function check_email_exists($email){
			$query = $this->db->get_where('users', array('email' => $email));
			if(empty($query->row_array())){
				return true;
			} else {
				return false;
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
             redirect('userdashboard');
			return $this->db->update('vendors', $data);
           
           
		}

		public function get_address(){
			$id = $this->session->userdata('user_id');

			// $this->db->select('v_address_id');
			// $this->db->from('users');
			// $this->db->where('v_id', $id);
			// $query = $this->db->get();

			$this->db->join('address', 'address.add_id = users.v_address_id');
			
			$query = $this->db->get('vendors', array('v_id' => $id));
			return $query->row_array();


		}

		// Check active status
		public function check_active_status($return = FALSE){
			if($return === FALSE){
				$id = $this->session->userdata('user_id');

				$this->db->select('*');
				$this->db->from('vendors');
				$this->db->where('v_id', $id);
				$this->db->where('v_address_id !=', '');
				$query = $this->db->get();
				
	
				if(empty($query->row_array())){
	
					$data = array(
						'v_status' => 'Inactive'
					);

					$this->db->update('vendors',  $data);

					// Set message
					$this->session->set_flashdata('flash-warning', 'You are not an Active User. Add an address in your dashboard');
				}
				else{
	
					$this->db->select('v_status');
					$this->db->from('vendors');
					$this->db->where('v_id', $id);
					$query = $this->db->get();
	
					if($query->row_array()['v_status'] === 'Inactive'){
						$this->db->set('v_status', 'Active');
						$this->db->where('v_id', $id);
						$this->db->update('vendors');
					}
					
				}
			}
			else{
				$id = $this->session->userdata('user_id');
				$this->db->select('v_status');
				$this->db->from('vendors');
				$this->db->where('v_id', $id);
				$query = $this->db->get();

				if($query->row_array()['v_status'] === 'Inactive'){
					return FALSE;
				}
				return TRUE;
				
			}

		}

		public function newAddress(){
			// address data array
			$data = array(
				'state' => $this->input->post('listBox'),
				'city' => $this->input->post('secondlist'),
				'street' => $this->input->post('street'),
                'building_no' => $this->input->post('buildno'),
				'land_mark' => $this->input->post('landmark'),
				'pincode' => $this->input->post('pincode'),
				'country' => $this->input->post('country')
			);
			// Insert address
			$this->db->insert('address', $data);

			$insert_id = $this->db->insert_id();

			$id = $this->session->userdata('user_id');

			$newdata = array(
				'v_address_id' => $insert_id
			);
			
			$this->db->where('v_id', $id);
			return $this->db->update('vendors', $newdata);
		}
		
		public function delAddress($data){
			// Delete address
			$this->db->delete('address', array('add_id' => $data));
			$id = $this->session->userdata('user_id');
			// address data array
			$newdata = array(
				'v_address_id' => ''
			);
			// Edit address
			$this->db->where('v_id', $id);
			return $this->db->update('vendors', $newdata);
		}
		
		public function newVendorMaterial(){
			// address data array
			$data = array(
				'vendor_id' => $id = $this->session->userdata('user_id'),
				'v_raw_material_id' => $this->input->post('matsel1'),
				'quality_info' => $this->input->post('quality_info')
			);
			// Insert address
			$this->db->insert('vendor_materials', $data);
		}
		
		public function delVendorMaterial($data){
			// Delete material
			$this->db->delete('vendor_materials', array('v_material_id' => $data));
		}

		public function get_vendorMaterials(){

			$id = $this->session->userdata('user_id');

			$this->db->join('raw_material','raw_material.raw_material_id = vendor_materials.v_raw_material_id');
			$query = $this->db->get_where('vendor_materials', array('vendor_id' => $id));
			return $query->result_array();

		}

	}