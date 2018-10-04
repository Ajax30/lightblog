<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Posts extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index() {

		if (!$this->session->userdata('is_logged_in')) {
			redirect('login');
		}

		//load and configure pagination 
		$this->load->library('pagination');
		$config['base_url'] = base_url("/dashboard/posts");
		$config['query_string_segment'] = 'page';
		$config['total_rows'] =	$this->Posts_model->get_num_rows();
		$config['per_page'] = 10;
		
		if (!isset($_GET[$config['query_string_segment']]) || $_GET[$config['query_string_segment']] < 1) {
			$_GET[$config['query_string_segment']] = 1;
		}
		$limit = $config['per_page'];
		$offset = ($this->input->get($config['query_string_segment']) - 1) * $limit;
		$this->pagination->initialize($config);

		$data = $this->Static_model->get_static_data();
		$data['pages'] = $this->Pages_model->get_pages();
		$data['categories'] = $this->Categories_model->get_categories();
		$data['number_of_pages'] = $this->Pages_model->count_pages();
		$data['number_of_categories'] = $this->Categories_model->get_num_rows();
		$data['number_of_comments'] = $this->Comments_model->get_num_rows();
		$data['posts'] = $this->Posts_model->get_posts($limit, $offset);
		$data['number_of_posts'] = $this->Posts_model->get_num_rows();
		$data['offset'] = $offset;

		$this->load->view('partials/header', $data);
		$this->load->view('dashboard/posts');
		$this->load->view('partials/footer');
	}

}
