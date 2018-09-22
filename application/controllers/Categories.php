<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Static_model');
		$this->load->model('Categories_model');
		$this->load->model('Posts_model');
	}

	public function posts($category_id) {
		//load and configure pagination 
		$this->load->library('pagination');
		$config['base_url'] = base_url('/categories/posts/' . $category_id);
		$config['query_string_segment'] = 'page';
		$config['total_rows'] =	$this->Posts_model->get_num_rows_by_category($category_id);
		$config['per_page'] = 12;
		
		if (!isset($_GET[$config['query_string_segment']]) || $_GET[$config['query_string_segment']] < 1) {
			$_GET[$config['query_string_segment']] = 1;
		}
		$limit = $config['per_page'];
		$offset = ($this->input->get($config['query_string_segment']) - 1) * $limit;
		$this->pagination->initialize($config);

		$data = $this->Static_model->get_static_data();
		$data['categories'] = $this->Categories_model->get_categories();
		$data['category_name'] = $this->Categories_model->get_category($category_id)->name;
		$data['posts'] = $this->Posts_model->get_posts_by_category($category_id, $limit, $offset);

		$this->load->view('partials/header', $data);
		$this->load->view('categories/posts');
		$this->load->view('partials/footer');
	}

	public function create() {

		// Only logged in users can create categories
		if (!$this->session->userdata('is_logged_in')) {
			redirect('login');
		}

		$data = $this->Static_model->get_static_data();
		$data['categories'] = $this->Categories_model->get_categories();
		$data['tagline'] = "Add New Category";
		$data['posts'] = $this->Posts_model->sidebar_posts($limit=5, $offset=5);

		if ($data['categories']) {
        foreach ($data['categories'] as &$category) {
         	$category->posts_count = $this->Posts_model->count_posts_in_category($category->id);
        }
    }

		$this->form_validation->set_rules('category_name', 'Category name', 'required');
		$this->form_validation->set_error_delimiters('<p class="error">', '</p>');

		if($this->form_validation->run() === FALSE){
			$this->load->view('partials/header', $data);
			$this->load->view('categories/add');
			$this->load->view('partials/footer');
		} else {
			$this->Categories_model->create_category();
			$this->session->set_flashdata('category_created', 'Your category has been created');
			redirect('posts');
		}
		
	}

}