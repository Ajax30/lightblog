<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Posts extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	private function _initPagination($path, $totalRows, $query_string_segment = 'page') {
    //load and configure pagination 
		$this->load->library('pagination');
		$config['base_url'] = base_url($path);
		$config['query_string_segment'] = $query_string_segment; 
		$config['enable_query_strings'] =TRUE;
		$config['reuse_query_string'] =TRUE;
		$config['total_rows'] = $totalRows;
		$config['per_page'] = 12;
		if (!isset($_GET[$config['query_string_segment']]) || $_GET[$config['query_string_segment']] < 1) {
			$_GET[$config['query_string_segment']] = 1;
		}
		$this->pagination->initialize($config);

		$limit = $config['per_page'];
		$offset = ($this->input->get($config['query_string_segment']) - 1) * $limit;

		return ['limit' => $limit, 'offset' => $offset];
	}

	public function index() {

		// Create all the database tables if there are none
		// by redirecting to the Migrations controller
		if (count($this->db->list_tables()) == 0) {
		    redirect('migrate');
		}

    //call initialization method
		$config = $this->_initPagination("/posts", $this->Posts_model->get_num_rows());

		$data = $this->Static_model->get_static_data();
		$data['pages'] = $this->Pages_model->get_pages();
		$data['categories'] = $this->Categories_model->get_categories();  

    //use limit and offset returned by _initPaginator method
		$data['posts'] = $this->Posts_model->get_posts($config['limit'], $config['offset']);
		$this->load->view('partials/header', $data);
		$this->load->view('posts');
		$this->load->view('partials/footer');
	}

	public function search() {
   // Force validation since the form's method is GET
		$this->form_validation->set_data($this->input->get());
		$this->form_validation->set_rules('search', 'Search term', 'required|trim|min_length[3]');
		$this->form_validation->set_error_delimiters('<p class = "error search-error"> ', ' </p>
			');
 		// If search fails
		if ($this->form_validation->run() === FALSE) {
			return $this->index();
		} else {
			$expression = $this->input->get('search');
			$posts_count = $this->Posts_model->search_count($expression);
			$query_string_segment = 'page';
			$config = $this->_initPagination("/posts/search", $posts_count, $query_string_segment);
			$data = $this->Static_model->get_static_data();
			$data['pages'] = $this->Pages_model->get_pages();
			$data['categories'] = $this->Categories_model->get_categories();
      //use limit and offset returned by _initPaginator method
			$data['posts'] = $this->Posts_model->search($expression, $config['limit'], $config['offset']);
			$data['expression'] = $expression;
			$data['posts_count'] = $posts_count;
			$this->load->view('partials/header', $data);
			$this->load->view('search');
			$this->load->view('partials/footer');
		}
	} 

	public function post($id) {
		$data = $this->Static_model->get_static_data();
		$data['pages'] = $this->Pages_model->get_pages();
		$data['categories'] = $this->Categories_model->get_categories();
		$data['posts'] = $this->Posts_model->sidebar_posts($limit=5, $offset=5);
		$data['post'] = $this->Posts_model->get_post($id);

		if ($data['categories']) {
			foreach ($data['categories'] as &$category) {
				$category->posts_count = $this->Posts_model->count_posts_in_category($category->id);
			}
		}

		if (!empty($data['post'])) {
			// Overwrite the default tagline with the post title
			$data['tagline'] = $data['post']->title;

			// Get post comments
			$post_id = $data['post']->id;
			$data['comments'] = $this->Comments_model->get_comments($post_id);

			$this->load->view('partials/header', $data);
			$this->load->view('post');
		} else {
			$data['tagline'] = "Page not found";
			$this->load->view('partials/header', $data);
			$this->load->view('404');
		}
		$this->load->view('partials/footer');
	}

	public function create() {

		// Only logged in users can create posts
		if (!$this->session->userdata('is_logged_in')) {
			redirect('login');
		}

		$data = $this->Static_model->get_static_data();
		$data['pages'] = $this->Pages_model->get_pages();
		$data['tagline'] = "Add New Post";
		$data['categories'] = $this->Categories_model->get_categories();
		$data['posts'] = $this->Posts_model->sidebar_posts($limit=5, $offset=5);

		if ($data['categories']) {
			foreach ($data['categories'] as &$category) {
				$category->posts_count = $this->Posts_model->count_posts_in_category($category->id);
			}
		}

		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('desc', 'Short description', 'required');
		$this->form_validation->set_rules('body', 'Body', 'required');
		$this->form_validation->set_error_delimiters('<p class="error">', '</p>');

		if($this->form_validation->run() === FALSE){
			$this->load->view('partials/header', $data);
			$this->load->view('create-post');
			$this->load->view('partials/footer');
		} else {
			// Create slug (from title)
			$slug = url_title($this->input->post('title'), 'dash', TRUE);

			// Upload image
			$config['upload_path'] = './assets/img/posts';
			$config['allowed_types'] = 'jpg|png';
			$config['max_size'] = '2048';

			$this->load->library('upload', $config);

			if(!$this->upload->do_upload()){
				$errors = array('error' => $this->upload->display_errors());
				$post_image = 'default.jpg';
			} else {
				$data = array('upload_data' => $this->upload->data());
				$post_image = $_FILES['userfile']['name'];
			}

			$this->Posts_model->create_post($post_image, $slug);
			$this->session->set_flashdata('post_created', 'Your post has been created');
			redirect('posts');
		}
	}

	public function edit($id) {

		// Only logged in users can edit posts
		if (!$this->session->userdata('is_logged_in')) {
			redirect('login');
		}

		$data = $this->Static_model->get_static_data();
		$data['pages'] = $this->Pages_model->get_pages();
		$data['categories'] = $this->Categories_model->get_categories();
		$data['posts'] = $this->Posts_model->sidebar_posts($limit=5, $offset=5);
		$data['post'] = $this->Posts_model->get_post($id);
		if ($this->session->userdata('user_id') == $data['post']->author_id) {
			$data['tagline'] = 'Edit the post "' . $data['post']->title . '"';
			$this->load->view('partials/header', $data);
			$this->load->view('edit-post');
			$this->load->view('partials/footer');
		} else {
			/* If the current user is not the author
			of the post do not alow edit */
			redirect('posts/post/' . $id);
		}
		
	}

	public function update() {
		// Form data validation rules
		$this->form_validation->set_rules('title', 'Title', 'required',  array('required' => 'The %s field can not be empty'));
		$this->form_validation->set_rules('desc', 'Short description', 'required',  array('required' => 'The %s field can not be empty'));
		$this->form_validation->set_rules('body', 'Body', 'required',  array('required' => 'The %s field can not be empty'));
		$this->form_validation->set_error_delimiters('<p class="error">', '</p>');

		$id = $this->input->post('id');

		// Update slug (from title)
		$slug = url_title($this->input->post('title'), 'dash', TRUE);

    // Upload image
		$config['upload_path'] = './assets/img/posts';
		$config['allowed_types'] = 'jpg|png';
		$config['max_size'] = '2048';

		$this->load->library('upload', $config);

		if(!$this->upload->do_upload()){
			$errors = array('error' => $this->upload->display_errors());
			$post_image = $this->input->post('postimage');
		} else {
			$data = array('upload_data' => $this->upload->data());
			$post_image = $_FILES['userfile']['name'];
		}

		if ($this->form_validation->run()) {
			$this->Posts_model->update_post($id, $post_image, $slug);
			$this->session->set_flashdata('post_updated', 'Your post has been updated');
			redirect('posts/post/' . $id);
		} else {
			$this->edit($id);
		}
	}

	public function delete($id) {
		// Only logged in users can delete posts
		if (!$this->session->userdata('is_logged_in')) {
			redirect('login');
		}

		$data['post'] = $this->Posts_model->get_post($id);
		if ($this->session->userdata('user_id') == $data['post']->author_id) {
			$this->Posts_model->delete_post($id);
			$this->session->set_flashdata('post_deleted', 'The post has been deleted');
			redirect('posts');
		} else {
			/* If the current user is not the author
			of the post do not alow delete */
			redirect('posts/post/' . $id);
		}
	}

}