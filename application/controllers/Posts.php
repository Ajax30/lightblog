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

    //call initialization method
		$config = $this->_initPagination("/", $this->Posts_model->get_num_rows());

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
		$this->form_validation->set_rules('search', 'Search term', 'required|trim|min_length[3]',array('min_length' => 'The Search term must be at least 3 characters long.'));
		$this->form_validation->set_error_delimiters('<p class = "error search-error">', '</p>
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

	public function byauthor($authorid){
		$data = $this->Static_model->get_static_data();
		$data['pages'] = $this->Pages_model->get_pages();
		$data['categories'] = $this->Categories_model->get_categories(); 
		$data['posts'] = $this->Posts_model->get_posts_by_author($authorid); 
		$data['posts_count'] = $this->Posts_model->posts_by_author_count($authorid); 
		$data['posts_author'] = $this->Posts_model->posts_author($authorid);

		$this->load->view('partials/header', $data);
		$this->load->view('posts_by_author');
		$this->load->view('partials/footer');
	}

	public function post($slug) {
		$data = $this->Static_model->get_static_data();
		$data['pages'] = $this->Pages_model->get_pages();
		$data['categories'] = $this->Categories_model->get_categories();
		$data['posts'] = $this->Posts_model->sidebar_posts($limit=5, $offset=0);
		$data['post'] = $this->Posts_model->get_post($slug);

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
		$data['posts'] = $this->Posts_model->sidebar_posts($limit=5, $offset=0);

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
			$this->load->view('create-post');
			$this->load->view('partials/footer');
		} else {
			// Create slug (from title)
			$slug = url_title($this->input->post('title'), 'dash', TRUE);
			$slugcount = $this->Posts_model->slug_count($slug);
			if ($slugcount > 0) {
				$slug = $slug."-".$slugcount;
			}

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
			redirect('/');
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
		$data['posts'] = $this->Posts_model->sidebar_posts($limit=5, $offset=0);
		$data['post'] = $this->Posts_model->get_post($id);
		if ($this->session->userdata('user_id') == $data['post']->author_id) {
			$data['tagline'] = 'Edit the post "' . $data['post']->title . '"';
			$this->load->view('partials/header', $data);
			$this->load->view('edit-post');
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
		if (!empty($this->input->post('title'))) {
			$slug = url_title($this->input->post('title'), 'dash', TRUE);
			$slugcount = $this->Posts_model->slug_count($slug);
			if ($slugcount > 0) {
				$slug = $slug."-".$slugcount;
			}
		} else {
			$slug = $this->input->post('slug');
		}
		
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
			redirect('/' . $slug);
		} else {
			$this->form_validation->run();
			$this->session->set_flashdata('errors', validation_errors());
			redirect('/posts/edit/' . $slug);
		}
	}

	public function delete($slug) {
		// Only logged in users can delete posts
		if (!$this->session->userdata('is_logged_in')) {
			redirect('login');
		}

		$data['post'] = $this->Posts_model->get_post($slug);
		if ($this->session->userdata('user_id') == $data['post']->author_id) {
			$this->Posts_model->delete_post($slug);
			$this->session->set_flashdata('post_deleted', 'The post has been deleted');
			redirect('/');
		} else {
			/* If the current user is not the author
			of the post do not alow delete */
			redirect('/' . $slug);
		}
	}

}