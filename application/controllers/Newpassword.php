<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Newpassword extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
    }

    // Sender email
    private $sender_email = "noreply@yourdomain.com";
    // Sender name
    private $sender_name = "Razvan Zamfir";
    

    private $user_email = '';
    private $subject = 'Pasword reset link';
    private $reset_link = '<a href="#">Dummy Reset Link</a>';
    private $body = '';

    public function index() {
        // Display form
        $data = $this->Static_model->get_static_data();
        $data['pages'] = $this->Pages_model->get_pages();
        $data['tagline'] = 'Reset your password';
        $data['categories'] = $this->Categories_model->get_categories();

        // Form validation rules
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_error_delimiters('<p class="error-message">', '</p>');

        if(!$this->form_validation->run()) {
            $this->load->view('partials/header', $data);
            $this->load->view('auth/passwordreset');
            $this->load->view('partials/footer');
        } else {
            if ($this->Usermodel->email_exists()) {
                $this->user_email = $this->input->post('email');
                $this->body = "Your password reset link: $this->reset_link\n\nAfter clicking it you will be redirected to a page on the website where you will be able to set a new pasword.";

                // Send mail and rediect
                $this->sendResetMail();             
            } else {
                $this->session->set_flashdata('email_non_existent', "The email you provided does not exist in our database");
            }
           redirect('newpassword');
        }
    }

    public function sendResetMail() {
        // Loading the Email library
        $config['protocol'] = 'sendmail';
        $config['charset'] = 'utf-8';
        $config['mailtype'] = 'html';

        if($this->load->is_loaded('email')){
            $this->email->initialize($config);
        }
        else{
            $this->load->library('email',$config);
        }

        // Build the body and meta data of the email message
        $this->email->from($this->sender_email, $this->sender_name);
        $this->email->to($this->user_email);
        $this->email->subject($this->subject);
        
        $this->email->message($this->body);

        if($this->email->send()){
            $this->session->set_flashdata('reset_mail_confirm', "A pasword reset link was send to the email address $this->user_email");
        }else{
            $this->session->set_flashdata('reset_mail_fail', "Our atempt to send a pasword reset link to $this->user_email has failed");
        }
    }
}