<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends CI_Controller {

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
		$data['number_of_pages'] = $this->Pages_model->count_pages();
		$data['number_of_posts'] = $this->Posts_model->get_num_rows();
		$data['number_of_comments'] = $this->Comments_model->get_num_rows();
		$data['number_of_categories'] = $this->Categories_model->get_num_rows();

		$this->load->view('partials/header', $data);
		$this->load->view('dashboard/categories');
		$this->load->view('partials/footer');

	}

	public function create() {

		// Only logged in users can create categories
		if (!$this->session->userdata('is_logged_in')) {
			redirect('login');
		}

		$data = $this->Static_model->get_static_data();
		$data['pages'] = $this->Pages_model->get_pages();
		$data['categories'] = $this->Categories_model->get_categories();
		$data['number_of_pages'] = $this->Pages_model->count_pages();
		$data['number_of_posts'] = $this->Posts_model->get_num_rows();
		$data['number_of_comments'] = $this->Comments_model->get_num_rows();
		$data['number_of_categories'] = $this->Categories_model->get_num_rows();
		$data['tagline'] = "Add New Category";

		$this->form_validation->set_rules('category_name', 'Category name', 'required');
		$this->form_validation->set_error_delimiters('<p class="error-message">', '</p>');

		if($this->form_validation->run() === FALSE){
			$this->load->view('partials/header', $data);
			$this->load->view('categories/add');
			$this->load->view('partials/footer');
		} else {
			$this->Categories_model->create_category();
			$this->session->set_flashdata('category_created', 'Your category has been created');
			redirect('dashboard/categories');
		}
		
	}

	public function edit($category_id) {

		// Only logged in users can edit categories
		if (!$this->session->userdata('is_logged_in')) {
			redirect('login');
		}

		$data = $this->Static_model->get_static_data();
		$data['pages'] = $this->Pages_model->get_pages();
		$data['number_of_pages'] = $this->Pages_model->count_pages();
		$data['number_of_posts'] = $this->Posts_model->get_num_rows();
		$data['number_of_comments'] = $this->Comments_model->get_num_rows();
		$data['categories'] = $this->Categories_model->get_categories();
		$data['number_of_categories'] = $this->Categories_model->get_num_rows();
		$data['category'] = $this->Categories_model->get_category($category_id);

		$this->load->view('partials/header', $data);
		$this->load->view('dashboard/editcategory');
		$this->load->view('partials/footer');
		
	}

	public function update() {

		$this->form_validation->set_rules('category_name', 'Category name', 'required');
		$this->form_validation->set_error_delimiters('<p class="error-message">', '</p>');

		$category_id = $this->input->post('category_id');

		if ($this->form_validation->run()) {
			$this->Categories_model->update_category($category_id);
			$this->session->set_flashdata('category_updated', 'The category has been updated');
			redirect('dashboard/categories');
		} else {
			$this->edit($category_id);
		}
	}

	public function delete($category_id) {
		// Only logged in users can delete posts
		if (!$this->session->userdata('is_logged_in')) {
			redirect('login');
		}

		$this->Categories_model->delete_category($category_id);
		$this->session->set_flashdata('category_deleted', 'The category has been deleted');
		redirect('dashboard/categories');
	}

}