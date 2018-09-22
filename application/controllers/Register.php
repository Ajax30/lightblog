<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Static_model');
		$this->load->model('Categories_model');
		$this->load->model('Usermodel');
	}

	public function index() {
		$data = $this->Static_model->get_static_data();
		$data['tagline'] = 'Want to write for ' . $data['site_title'] . '? Create an account.';
		$data['categories'] = $this->Categories_model->get_categories();

		$this->form_validation->set_rules('first_name', 'First name', 'required');
		$this->form_validation->set_rules('last_name', 'Last name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
		$this->form_validation->set_rules('cpassword', 'Confirm password', 'required|matches[password]');
		$this->form_validation->set_error_delimiters('<p class="error">', '</p>');

		// If validation fails
		if ($this->form_validation->run() === FALSE) {
			$this->load->view('partials/header', $data);
			$this->load->view('auth/register');
			$this->load->view('partials/footer');
		} else {
			// If the provided email does not already
			// exist in the authors table, register user
			if (!$this->Usermodel->email_exists()) {
				// Encrypt the password
				$enc_password = md5($this->input->post('password'));
				$this->Usermodel->register_user($enc_password);
				$this->session->set_flashdata('user_registered', 'You are now registered. You can sign in an post.');
				redirect('login');
			} else {
				// The user is already registered
				redirect('login');
			}
		}
	}

}