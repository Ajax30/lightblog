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
		} else {
			// Admin ONLY area!
			if (!$this->session->userdata('user_is_admin')) {
				redirect($this->agent->referrer());
			}
		}

		$data = $this->Static_model->get_static_data();
		$data['pages'] = $this->Pages_model->get_pages();
		$data['categories'] = $this->Categories_model->get_categories();
		$data['authors'] = $this->Usermodel->getAuthors();

		$this->load->view('partials/header', $data);
		$this->load->view('dashboard/authors');
		$this->load->view('partials/footer');
		
	}

	public function edit($id) {
		// Only logged in users can edit user profiles
		if (!$this->session->userdata('is_logged_in')) {
			redirect('login');
		}

		$data = $this->Static_model->get_static_data();
		$data['pages'] = $this->Pages_model->get_pages();
		$data['categories'] = $this->Categories_model->get_categories();
		$data['author'] = $this->Usermodel->editAuthor($id);

		/*echo '<pre>'; print_r($data['author']); echo '</pre>';*/

		$this->load->view('partials/header', $data);
		$this->load->view('dashboard/edit-author');
		$this->load->view('partials/footer');
		
	}

	public function delete($id) {
		$this->load->model('Usermodel');
		if ($this->Usermodel->deleteAuthor($id)) {
			$this->session->set_flashdata('author_delete', "The author was deleted");
		} else {
			$this->session->set_flashdata('author_delete', "Failed to delete author");
		}
		redirect('dashboard/users');
	}

	public function activate($id) {
		$this->load->model('Usermodel');
		$author = $this->Usermodel->activateAuthor($id);
		redirect($this->agent->referrer());
	}

	public function deactivate($id) {
		$this->load->model('Usermodel');
		$author = $this->Usermodel->deactivateAuthor($id);
		redirect($this->agent->referrer());
	}

}