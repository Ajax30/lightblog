<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comments extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function create($post_id){
		$post_id = $this->input->post('postid');
		$data = $this->Static_model->get_static_data();
		$data['post'] = $this->Posts_model->get_post($post_id);
		$data['tagline'] = 'Comment on "' . $data['post']->title . '"';

		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
		$this->form_validation->set_rules('message', 'Comment', 'required');
		$this->form_validation->set_error_delimiters('<p class="error">', '</p>');

		if($this->form_validation->run() === FALSE) {
			$this->load->view('partials/header', $data);
			$this->load->view('post');
			$this->load->view('partials/footer');
		} else {
			$this->Comments_model->create_comment($post_id);
			$this->session->set_flashdata('comment_added', 'Your comment will be published after aproval');
			redirect('posts/post/' . $post_id);
		}
		
	}

}