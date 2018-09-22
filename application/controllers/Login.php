<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

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

    $this->load->view('partials/header', $data);
    $this->load->view('auth/login');
    $this->load->view('partials/footer');
  }

  public function login() {  
    $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
    $this->form_validation->set_rules('password', 'Password', 'required|trim');
    $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
    if ($this->form_validation->run())
    {
      $email = $this->input->post('email');
      $password = $this->input->post('password');
      $this->load->model('Usermodel');
      $current_user = $this->Usermodel->user_login($email, $password);
        // If we find a user
      if ($current_user) {
        // If the user found is active
        if ($current_user->active == 1) {
          $this->session->set_userdata(
           array(
            'user_id' => $current_user->id,
            'user_email' => $current_user->email,
            'user_first_name' => $current_user->first_name,
            'user_active' => $current_user->active,
            'is_logged_in' => TRUE
            )
           );
          // After login, display flash message
          $this->session->set_flashdata('user_signin', 'You have signed in');
          //and redirect to the posts page
          redirect('posts');  
        } else {
          // If the user found is NOT active
          $this->session->set_flashdata("login_failure_activation", "Your account has not been activated yet.");
          redirect('login'); 
        }
      } else {
        // If we do NOT find a user
        $this->session->set_flashdata("login_failure_incorrect", "Incorrect email or password.");
        redirect('login'); 
      }
    }
    else
    {
     $this->load->view('login');
    }
  }

  public function logout(){
    // Unset the current user's data
    $this->session->unset_userdata('user_id');
    $this->session->unset_userdata('user_email');
    $this->session->unset_userdata('user_first_name');
    $this->session->unset_userdata('is_logged_in');

    $this->session->set_flashdata('user_signout', 'You have signed out');

    /* After user has signed out, redirect him/her to posts page */
    redirect('posts'); 
  }
}