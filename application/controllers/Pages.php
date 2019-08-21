<?php
	class Pages extends CI_Controller{

		public function view($page = 'home'){
            
            if(!file_exists(APPPATH.'views/pages/'.$page.'.php')){
				show_404();
			}
            
			$data['title'] = ucfirst($page);
			
			if($page === 'home'){
				$data['products'] = $this->material_model->get_products();
			}
            
			$this->load->view('templates/header', $data);
			$this->load->view('pages/'.$page, $data);
			$this->load->view('templates/footer');
		}
		
		
	}