<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Static_model');
		$this->load->model('Posts_model');
		$this->load->model('Categories_model');
		$this->load->model('Comments_model');
	}

	public function index() {

		if (!$this->session->userdata('is_logged_in')) {
			redirect('login');
		}

		$data = $this->Static_model->get_static_data();
		$data['number_of_posts'] = $this->Posts_model->get_num_rows();
		$data['number_of_comments'] = $this->Comments_model->get_num_rows();
		$data['categories'] = $this->Categories_model->get_categories();
		$data['number_of_categories'] = $this->Categories_model->get_num_rows();

		$this->load->view('partials/header', $data);
		$this->load->view('dashboard/categories');
		$this->load->view('partials/footer');

	}

	public function edit($category_id) {

		// Only logged in users can edit categories
		if (!$this->session->userdata('is_logged_in')) {
			redirect('login');
		}

		$data = $this->Static_model->get_static_data();
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
		$this->form_validation->set_error_delimiters('<p class="error">', '</p>');

		$category_id = $this->input->post('category_id');

		if ($this->form_validation->run()) {
			$this->Categories_model->update_category($category_id);
			$this->session->set_flashdata('category_updated', 'The category has been updated');
			redirect('dashboard/categories');
		} else {
			$this->edit($category_id);
		}
	}

}