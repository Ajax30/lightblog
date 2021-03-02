<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Newpassword extends CI_Controller {

  private $hashed_email = '';
  private $token = '';

	public function index($hashed_email, $token) {
		$data = $this->Static_model->get_static_data();
    $data['pages'] = $this->Pages_model->get_pages();
    $data['tagline'] = 'New password';
    $data['categories'] = $this->Categories_model->get_categories();

    if(!$this->form_validation->run()) {
        $this->load->view('partials/header', $data);
        $this->load->view('auth/newpassword');
        $this->load->view('partials/footer');
    } else {
    	$this->add();
    }
	}

  public function add() {
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
      // Encrypt new password
      $enc_password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);

      // Update password column
      $this->Usermodel->set_new_password($this->hashed_email, $this->set_new_password, $enc_password);
    }
  }

}