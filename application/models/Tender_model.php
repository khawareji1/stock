<?php
	class  Tender_model extends CI_Model{

        public function __construct(){
			$this->load->database();
        }
        
        public function get_tenders($id = FALSE){
		
			$this->db->join('raw_material','raw_material.raw_material_id = tender.raw_material_id');
			
			if($id === FALSE){
				$query = $this->db->get('tender');
				return $query->result_array();
			}

			$this->db->join('manufacturers','manufacturers.m_id = tender.m_id');
			$this->db->join('material_subcat','material_subcat.subcat_id = raw_material.material_subcat_id');
			$query = $this->db->get_where('tender', array('tender_id' => $id));
			return $query->row_array();
		}

		public function get_diffVendorReq($id){
		
			//$this->db->join('tender','diff_vendor_req.tender_id = tender.tender_id');
			$this->db->join('vendors','vendors.v_id = diff_vendor_req.vendor_id');
			$query = $this->db->get_where('diff_vendor_req', array('tender_id' => $id));
			return $query->result_array();
		}

		public function get_transaction($id){
			$this->db->join('diff_vendor_req','diff_vendor_req.request_id = transaction.diff_vendor_reqid');
			$query = $this->db->get_where('transaction', array('tender_created_id' => $id));
			return $query->row_array();
		}

		public function tenderRequest($tenderID){

			// tender request data array
			$data = array(
				'vendor_id' => $this->session->userdata('user_id'),
				'tender_id' => $tenderID,
				'quantity' => $this->input->post('tender_quantity'),
				'quantity_unit' => $this->input->post('tender_quantity_unit'),
				'quoted_price' => $this->input->post('quoted-price'),
				'delivery_date' => $this->input->post('dod'),
				'req_desc' => $this->input->post('extra_info'),
				'req_status' => 'pending'
			);
			// Insert tender request
			return $this->db->insert('diff_vendor_req', $data);
		}


		public function userTenders($passValue , $id = NULL){
			if($id === NULL){
				$id = $this->session->userdata('user_id');
			}
				
			$this->db->join('raw_material','raw_material.raw_material_id = tender.raw_material_id');
			$this->db->where('m_id', $id);
			$query = $this->db->get_where('tender', array('tender_status' => $passValue));
			return $query->result_array();
		
		}

		public function vendorTenders($passValue , $id = NULL){
			
			if($id === NULL){
				$id = $this->session->userdata('user_id');
			}
			
			$this->db->join('diff_vendor_req','diff_vendor_req.tender_id = tender.tender_id');
			$this->db->join('raw_material','raw_material.raw_material_id = tender.raw_material_id');
			$this->db->where('vendor_id', $id);
			$query = $this->db->get_where('tender', array('tender_status' => $passValue));
			return $query->result_array();
		
		}

		public function checkExpiryStatus(){

			$this->db->select('*');
			$this->db->from('tender');
			$query = $this->db->get();

			$tenders = $query->result_array();

			foreach($tenders as $tender){
				if($tender["tender_status"] === "active" ){
					$expdate = $tender['date_expire'];
					$exptime = $tender['time_expire'];
					$exp = date('Y-m-d H:i:s', strtotime("$expdate $exptime "));
					$datetime1 = new DateTime();
					$datetime2 = new DateTime($exp);
					if ( $datetime1 >  $datetime2){
						$data = array(
							'tender_status' => "expired"
						);
						$this->db->update('tender', $data, array('tender_id' => $tender['tender_id']));
					}
				}
			}


		}

		public function acptRequests($reqID){
			$data = array(
				'req_status' => "accepted"
			);
			$this->db->update('diff_vendor_req', $data, array('request_id' => $reqID));

			//convert the active tender to ongoing tender
			$this->db->select('*');
			$this->db->from('diff_vendor_req');
			$this->db->where('request_id', $reqID);
			$query = $this->db->get();
			$tender_id = $query->row_array();

			$data = array(
				'tender_status' => "ongoing"
			);
			$this->db->update('tender', $data, array('tender_id' => $tender_id["tender_id"] ));

			//putting the tender to transaction table
			$data2 = array(
				'tender_created_id' => $tender_id["tender_id"],
				'diff_vendor_reqid' => $reqID,
				'start_date' => date("Y-m-d"),
				'start_time' => date("H:i"),
				'delvy_date' => $tender_id["delivery_date"],
				'delvy_time' => date("H:i"),
				'trans_status' => 'orderConfirmed',
			);
			return $this->db->insert('transaction', $data2);
		}


		public function declRequests($reqID){
			$data = array(
				'req_status' => "declined"
			);
			$this->db->update('diff_vendor_req', $data, array('request_id' => $reqID));
		}

		public function changeStatus($transID){
			$data = array(
				'trans_status' => $this->input->post('trans_status_change'),
				'trans_message' => $this->input->post('message')
			);
			$this->db->update('transaction', $data, array('trans_id' => $transID));


			$this->db->select('tender_created_id');
			$this->db->from('transaction');
			$this->db->where('trans_id', $transID);
			$query = $this->db->get();
			$tender_id = $query->row_array();

			return $tender_id['tender_created_id'];
		}

		public function changeETA($transID){
			$data = array(
				'trans_delay_time' => $this->input->post('trans_delay_time'),
				'trans_delay_unit' => $this->input->post('trans_delay_unit'),
				'trans_message' => $this->input->post('message')
			);
			$this->db->update('transaction', $data, array('trans_id' => $transID));


			$this->db->select('tender_created_id');
			$this->db->from('transaction');
			$this->db->where('trans_id', $transID);
			$query = $this->db->get();
			$tender_id = $query->row_array();

			return $tender_id['tender_created_id'];
		}

		public function cancelTender($tenderID){
			$data = array(
				'tender_status' => 'cancelled'
			);
			return $this->db->update('tender', $data, array('tender_id' => $tenderID));
		}
		
		public function deliveryComplete($tenderID){
			$data = array(
				'tender_status' => 'completed'
			);
			return $this->db->update('tender', $data, array('tender_id' => $tenderID));
		}

		public function deliveryNotGet($transID){
			$data = array(
				'trans_status' => 'dispatched',
				'trans_message' => 'DNR'
			);
			$this->db->update('transaction', $data, array('trans_id' => $transID));


			$this->db->select('tender_created_id');
			$this->db->from('transaction');
			$this->db->where('trans_id', $transID);
			$query = $this->db->get();
			$tender_id = $query->row_array();

			return $tender_id['tender_created_id'];
		}

		public function sendNotificationMessageToOne($toID = NULL, $message = NULL){
			
			$fromID = $this->session->userdata('user_id');

			if($toID != NULL && $message != NULL){
				// messages data
				$data = array(
					'from_id ' => $fromID,
					'to_id ' => $toID,
					'message_body' => $message,
					'message_type' => 'Notification',
				);
				
				// Insert message request
				return $this->db->insert('messages', $data);
			}

		}
		
		public function sendNotificationMessageToMultiple($item_id = NULL , $lastInsertID){
			
			$fromID = $this->session->userdata('user_id');

			if($item_id != NULL){

				$this->db->join('raw_material','raw_material.raw_material_id = vendor_materials.v_raw_material_id');
				$query = $this->db->get_where('vendor_materials', array('v_raw_material_id' => $item_id));
				$results = $query->result_array();

				foreach($results as $result){
					// messages data
					$message = ('A Tender is available for '.$result['rm_name'].'. <a href="'.base_url().'tenders/view/'.$lastInsertID.'">View..</a>');
					$data = array(
						'from_id ' => $fromID,
						'to_id ' => $result['vendor_id'],
						'message_body' => $message,
						'message_type' => 'Notification'
					);
					
					// Insert message request
					$this->db->insert('messages', $data);
				}
			}

		}
        /*
        public function email_send(){
			//$email = $this->input->post('email');
            //$email = $this->db->query("select * from ") 
			//$id = $this->user_model->check_email_exists($email, 1);
            
            
            $qr="Select * from vendors";
            $rn=mysqli_query($conn,$qr);
            
            while($row=mysqli_fetch_assoc($rn))
            {
                echo $row['v_email'];
            }
            
        }
            
			if(!empty($id)){
				
				$seed = str_split('abcdefghijklmnopqrstuvwxyz'
								.'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
								.'0123456789!@#$%^&*()');
				
				// $this->user_model->changePassword($hashpass , $id);
 				$this->send_mail($email, 'tenderpart');

			} else {
				$this->session->set_flashdata('flash-warning', 'Incorrect Email. Please provide an email which is given while registration.');
				redirect('users/login');
			}
    }*/

        
     /*   public send_mail($to, $type = NULL )
        {
            
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
			elseif($type === 'tenderpart'){
				$subject = 'Product Shipped - StockHUB';
				$message = 'Hello Mr. How Do You Do ?';
            
            // $this->email->initialize($config);
				$this->email->from('khawarey16@gmail.com');
				$this->email->to($to);
				$this->email->subject($subject);
				$this->email->message($message);
		
				//Send mail 
				if($this->email->send()){
					$this->session->set_flashdata("flash-success","Email sent successfully.");
					//redirect('users/login');
				}
				else {
					// show_error($this->email->print_debugger());
					$this->session->set_flashdata("flash-danger","Failed to sent Email.");
					redirect('home');
				}
        }

        
	}*/
    }