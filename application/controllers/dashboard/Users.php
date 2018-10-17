<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index() {

		if (!$this->session->userdata('is_logged_in')) {
			redirect('login');
		}

		$data = $this->Static_model->get_static_data();
		$data['pages'] = $this->Pages_model->get_pages();
		$data['categories'] = $this->Categories_model->get_categories();

		$data['authors'] = $this->Usermodel->getAuthors();

		$this->load->view('partials/header', $data);
		$this->load->view('dashboard/authors');
		$this->load->view('partials/footer');

	}

}