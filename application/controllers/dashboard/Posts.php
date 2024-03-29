<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Posts extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	private function get_data()
	{
		$data = $this->Static_model->get_static_data();
		$data['pages'] = $this->Pages_model->get_pages();
		$data['categories'] = $this->Categories_model->get_categories();
		$data['number_of_pages'] = $this->Pages_model->count_pages();
		$data['number_of_posts'] = $this->Posts_model->get_num_rows();
		$data['number_of_categories'] = $this->Categories_model->get_num_rows();
		$data['number_of_comments'] = $this->Comments_model->get_num_rows();
		return $data;
	}

	public function index() {
		if (!$this->session->userdata('is_logged_in')) {
			redirect('login');
		}

		//load and configure pagination 
		$this->load->library('pagination');
		$config['base_url'] = base_url("/dashboard/posts");
		$config['query_string_segment'] = 'page';
		$config['total_rows'] =	$this->Posts_model->get_num_rows();
		$config['per_page'] = 10;
		
		if (!isset($_GET[$config['query_string_segment']]) || $_GET[$config['query_string_segment']] < 1) {
			$_GET[$config['query_string_segment']] = 1;
		}
		$limit = $config['per_page'];
		$offset = ($this->input->get($config['query_string_segment']) - 1) * $limit;
		$this->pagination->initialize($config);

		$data = $this->get_data();
		$data['posts'] = $this->Posts_model->get_posts($limit, $offset);
		$data['offset'] = $offset;
		$data['limit'] = $limit;
		$data['total_posts'] = $config['total_rows'];

		$this->load->view('partials/header', $data);
		$this->load->view('dashboard/posts');
		$this->load->view('partials/footer');
	}

	public function create() {
		// Only logged in users can create posts
		if (!$this->session->userdata('is_logged_in')) {
			redirect('login');
		}

		$data = $this->get_data();
		$data['tagline'] = "Add New Post";
		$data['is_ckeditor'] = true;

		if ($data['categories']) {
			foreach ($data['categories'] as &$category) {
				$category->posts_count = $this->Posts_model->count_posts_in_category($category->id);
			}
		}

		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('desc', 'Short description', 'required');
		$this->form_validation->set_rules('body', 'Body', 'required');
		$this->form_validation->set_error_delimiters('<p class="error-message">', '</p>');

		if($this->form_validation->run() === FALSE){
			$this->load->view('partials/header', $data);
			$this->load->view('dashboard/create-post');
			$this->load->view('partials/footer');
		} else {
			// 1) Create slug (from title)
			$slug = url_title(convert_accented_characters($this->input->post('title')), 'dash', TRUE);
			$slugcount = $this->Posts_model->slug_count($slug, null);
			if ($slugcount > 0) {
				$slug = $slug."-".$slugcount;
			}

			// 2) Add post to carousel (if is the case)
			$featured = $this->input->post('featured') ? 1 : 0;

			// 3) Upload image
			$config['upload_path'] = './assets/img/posts';
			$config['allowed_types'] = 'jpg|jpeg|png';
			$config['max_size'] = '2048';

			$this->load->library('upload', $config);

			if(!$this->upload->do_upload()){

				$errors = array('error' => $this->upload->display_errors());

				// Dysplay upload validation errors 
				// only if a file is uploaded and there are errors
				if (empty($_FILES['userfile']['name'])) {
					$errors = [];
				}

				if (empty($errors)) {
					$post_image = 'default.jpg';
				} else {
					$data['upload_errors'] = $errors;
				}
				
			} else {
				$data = array('upload_data' => $this->upload->data());
				$post_image = $_FILES['userfile']['name'];
			}

			if (empty($errors)) {
				$this->Posts_model->create_post($post_image, $slug, $featured);
				$this->session->set_flashdata('post_created', 'Your post has been created');
				redirect('/');
			} else {
				$this->load->view('partials/header', $data);
				$this->load->view('dashboard/create-post');
				$this->load->view('partials/footer');
			}
		}
	}

	public function edit($id) {
		// Only logged in users can edit posts
		if (!$this->session->userdata('is_logged_in')) {
			redirect('login');
		}

		$data = $this->get_data();
		$data['post'] = $this->Posts_model->get_post($id);

		if (($this->session->userdata('user_id') == $data['post']->author_id) || $this->session->userdata('user_is_admin')) {
			$data['tagline'] = 'Edit the post "' . $data['post']->title . '"';
			$data['is_ckeditor'] = true;
			$this->load->view('partials/header', $data);
			$this->load->view('dashboard/edit-post');
			$this->load->view('partials/footer');
		} else {
			/* If the current user is not the author
			of the post do not alow edit */
			redirect('/' . $id);
		}
	}

	public function update() {
		// Form data validation rules
		$this->form_validation->set_rules('title', 'Title', 'required',  array('required' => 'The %s field can not be empty'));
		$this->form_validation->set_rules('desc', 'Short description', 'required',  array('required' => 'The %s field can not be empty'));
		$this->form_validation->set_rules('body', 'Body', 'required',  array('required' => 'The %s field can not be empty'));
		$this->form_validation->set_error_delimiters('<p class="error-message">', '</p>');

		$id = $this->input->post('id');

		// Update slug (from title)
		if ($this->form_validation->run()) {
			$slug = url_title(convert_accented_characters($this->input->post('title')), 'dash', TRUE);
			$slugcount = $this->Posts_model->slug_count($slug, $id);
			if ($slugcount > 0) {
				$slug = $slug."-".$slugcount;
			}
		} else {
			$slug = $this->input->post('slug');
		}

			// 2) Add post to carousel
			$featured = $this->input->post('featured') ? 1 : 0;
		
    // Upload image
		$config['upload_path'] = './assets/img/posts';
		$config['allowed_types'] = 'jpg|jpeg|png';
		$config['max_size'] = '2048';

		$this->load->library('upload', $config);

		if (isset($_FILES['userfile']['name']) && $_FILES['userfile']['name'] != null) {
		    // Use name field in do_upload method
			if (!$this->upload->do_upload('userfile')) {

				$errors = array('error' => $this->upload->display_errors());

				// Display upload validation errors 
				// only if a file is uploaded and there are errors
				if (empty($_FILES['userfile']['name'])) {
					$errors = [];
				}

				if (!empty($errors)) {
					$data['upload_errors'] = $errors;
				}

			} else {
				$data = $this->upload->data();
				$post_image = $data['raw_name'].$data[ 'file_ext'];
			}
		}
		else {
			$post_image = $this->input->post('postimage');
		}

		if ($this->form_validation->run() && empty($errors)) {
			$this->Posts_model->update_post($id, $post_image, $slug, $featured);
			$this->session->set_flashdata('post_updated', 'Your post has been updated');
			redirect('/' . $slug);
		} else {
			$this->form_validation->run();
			$this->session->set_flashdata('errors', validation_errors());
			$this->session->set_flashdata('upload_errors', $errors);
			redirect('/dashboard/posts/edit/' . $slug);
		}
	}

	public function delete($slug) {
		// Only logged in users can delete posts
		if (!$this->session->userdata('is_logged_in')) {
			redirect('login');
		}

		$data['post'] = $this->Posts_model->get_post($slug);
		if (($this->session->userdata('user_id') == $data['post']->author_id) || $this->session->userdata('user_is_admin')) {
			$this->Posts_model->delete_post($slug);
			$this->session->set_flashdata('post_deleted', 'The post has been deleted');
			redirect('/');
		} else {
			/* If the current user is not the author
			of the post do not alow delete */
			$this->session->set_flashdata('no_permission_to_delete_post', 'You are not authorized to delete this post');
			redirect('/' . $slug);
		}
	}

	public function deleteimage($id) {
		$this->load->model('Posts_model');
		$this->Posts_model->delete_post_image($id);
		redirect($this->agent->referrer());
	}

}
