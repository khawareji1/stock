<?php
	class Material_model extends CI_Model{

        public function __construct(){
			$this->load->database();
		}


        public function get_materials($slug = FALSE){

			$this->db->join('material_subcat','material_subcat.subcat_id = raw_material.material_subcat_id');
			if($slug === FALSE){
				$query = $this->db->get('raw_material');
				return $query->result_array();
			}
			elseif($slug === "JSON"){
				$query = $this->db->get('raw_material');
				return $query->result();
			}
			else{
				$query = $this->db->get_where('raw_material', array('rm_slug' => $slug));
				return $query->row_array();
			}
		}

		public function get_products(){
			$this->db->select("*");
			$this->db->from('product_cat');
			$query = $this->db->get();
			return $query->result_array();
		}
		
		public function get_categorys(){
			$this->db->select("*");
			$this->db->from('material_subcat');
			$query = $this->db->get();
			return $query->result_array();
		}

		public function get_materialsearch($search){
			$this->db->select("*");
			$this->db->from('raw_material');
			$this->db->join('material_subcat','material_subcat.subcat_id = raw_material.material_subcat_id');

			$this->db->like('rm_name' ,$search);
			$this->db->or_like('subcat_name', $search);
			
			$query = $this->db->get();
			return $query->result();
		}
		
		public function get_homesearch($search){
			$this->db->select("*");
			$this->db->from('product_subcat');
			$this->db->join('material_subcat','material_subcat.subcat_id = product_subcat.subcat_id');
			$this->db->join('product_cat','product_cat.product_cat_id = product_subcat.product_id');

			$this->db->like('product_cat_name' ,$search);
			
			$query = $this->db->get();
			return $query->result();
		}


		public function hmsearch($search){
			$this->db->select("*");
			$this->db->from('product_subcat');
			$this->db->join('material_subcat','material_subcat.subcat_id = product_subcat.subcat_id');
			$this->db->join('product_cat','product_cat.product_cat_id = product_cat.product_cat_id');

			$this->db->like('product_cat_name' ,$search);
			
			$query = $this->db->get();
			return $query->row_array();
		}



		public function tenderRegister($material_id){
			// User data array
			$data = array(
				'm_id' => $this->session->userdata('user_id'),
				'raw_material_id' => $material_id,
				'tender_quantity' => $this->input->post('tender_quantity'),
				'tender_quantity_unit' => $this->input->post('tender_quantity_unit'),
				'date_of_submission' => date("Y-m-d"),
				'time_submission' => date("H:i"),
				'date_expire' => $this->input->post('doe'),
				'time_expire' => $this->input->post('toe'),
				'delivery_location' => $this->input->post('deliveryLocation'),
				'estimated_price' => $this->input->post('estimated-price'),
				'extra_info' => $this->input->post('extra_info'),
				'tender_status' => 'active'
			);
			// Insert user
			$this->db->insert('tender', $data);
			return $this->db->insert_id();
		}
        
	}