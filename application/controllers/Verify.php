<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Partners extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('base');
	}

	private $tbl = 'partners';

	private function js_path()
	{
		return base_url() . 'assets/backend/js/';
	}

	function index()
	{

		$data['title'] 	  = 'Partner';
		$data['script'][] = $this->js_path() . 'partner.js';
		$page['content']  = $this->load->view('admin/partner/index', $data, true);
		$this->load->view('admin/template/layout_page', $page);
	}

}
