<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Newpasword extends CI_Controller {

	public function index($email, $token) {
		$data = $this->Static_model->get_static_data();
    $data['pages'] = $this->Pages_model->get_pages();
    $data['tagline'] = 'New password';
    $data['categories'] = $this->Categories_model->get_categories();

    // Form validation rules
    $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
		$this->form_validation->set_rules('cpassword', 'Confirm password', 'required|matches[password]');
    $this->form_validation->set_error_delimiters('<p class="error-message">', '</p>');

    if(!$this->form_validation->run()) {
        $this->load->view('partials/header', $data);
        $this->load->view('auth/newpassword');
        $this->load->view('partials/footer');
    } else {
    	$this->Usermodel->set_new_password($email, $token);
    }
	}
}