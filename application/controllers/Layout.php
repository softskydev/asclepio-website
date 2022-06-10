<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Layout extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->helper('base');
	}

	private $tbl = 'layout';
	private $where =  ['id' => 1];

	private function js_path(){
		return base_url().'assets/backend/js/';
	}

	/* ======  LAYOUT PAGE ====== */
	function index(){

		$data['title'] 	  = 'Layout'; 
		$data['script'][] = $this->js_path().'layout.js';
		
		$page['content']  = $this->load->view('admin/layout/index' , $data , true);
		$this->load->view('admin/template/layout_page', $page);
	}

	function load_layout(){
		$data['status'] = 200;
		$data['data'] = $this->query->get_data_simple('layout' , $this->where )->row();
		echo json_encode($data);

	}

	function process_form(){

		$data_to_update = [
			'address'      => $_POST['l_address'],
			'email'        => $_POST['l_email'],
			'phone'        => $_POST['l_phone'],
			'facebook'     => $_POST['l_facebook'],
			'instagram'    => $_POST['l_instagram'],
			'youtube'      => $_POST['l_youtube'],
			'twitter'      => $_POST['l_twitter'],
		];

		if (isset($_FILES['picture_logo']['tmp_name'])) {

			$config['upload_path']   = './assets/frontend/img/logo/'; 
			$config['allowed_types'] = 'jpg|jpeg|png';
			$config['max_size']      = 1024 * 4;
			$config['encrypt_name'] = true;
			$this->load->library('upload',$config); 
			

			if ($this->upload->do_upload('picture_logo')) {
				$oldimage = $this->query->get_data_simple('layout' , $this->where )->row();
				$path     = './assets/'.$oldimage->logo_picture;
				if (file_exists($path)) {
					unlink($path); 
				}

				$picture = $this->upload->data();
				$data_to_update['logo_picture'] =  $picture['file_name'];
				$msg['msg'] = 'the data is updated';
				

			}else {
				$msg['msg'] = 'the data is save, but the picture not uploaded because: '.$this->upload->display_errors();
			}
		} else {
			$msg['msg'] = 'the data is updated';
		}
		$this->query->insert_for_id($this->tbl , $this->where , $data_to_update);
		$msg['status'] = 200;
		echo json_encode($msg);

	}

	

}
