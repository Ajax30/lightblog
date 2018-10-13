<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Posts_model extends CI_Model {

	public function get_num_rows() {
		$query = $this->db->get('posts');
		return $query->num_rows(); 
	}

	public function get_posts($limit, $offset) {
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get('posts', $limit, $offset);
		return $query->result();
	}

	public function search_count($expression) {
		$query = $this->db->like('title', $expression)
									->or_like('description', $expression)
									->or_like('content', $expression);
		$query = $this->db->get('posts');
		return $query->num_rows();  
	}

	public function search($expression, $limit, $offset) {
		$query = $this->db->like('title', $expression)
											->or_like('description', $expression)
											->or_like('content', $expression);
		$this->db->order_by('posts.id', 'DESC');
		$query = $this->db->get('posts', $limit, $offset);
		return $query->result();
	}

	public function sidebar_posts($limit, $offset) {
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get('posts', $limit, $offset);
		return $query->result();
	}

	public function get_post($id) {
		$query = $this->db->get_where('posts', array('id' => $id));
		if ($query->num_rows() > 0) {
			$data = $query->row();
      // run separate query for author name
			$author_query = $this->db->get_where('authors', array('id' => $data->author_id));
			if ($author_query->num_rows() == 1) {
				$author = $author_query->row();
				$data->first_name = $author->first_name;
				$data->last_name = $author->last_name;             
			} else {
				$data->first_name = 'Unknown';
				$data->last_name = '';
			}
			return $data;
		}
	}

	public function slug_count($slug){
		$this->db->select('count(*) as slugcount');
		$this->db->from('posts');
		$this->db->where('slug', $slug);
		$query = $this->db->get();
		return $query->row(0)->slugcount;
	}

	public function create_post($post_image, $slug) {
		$data = [
			'title' => $this->input->post('title'),
			'slug' => $slug,
			'description' => $this->input->post('desc'),
			'content' => $this->input->post('body'),
			'post_image' => $post_image,
			'author_id' => $this->session->userdata('user_id'),
			'cat_id' => $this->input->post('category'),
			'created_at' => date('Y-m-d H:i:s')
		];
		return $this->db->insert('posts', $data);
	}

	public function update_post($id, $post_image, $slug) {
		$data = [
			'title' => $this->input->post('title'),
			'slug' => $slug,
			'description' => $this->input->post('desc'),
			'content' => $this->input->post('body'),
			'post_image' => $post_image,
			'cat_id' => $this->input->post('category'),
			'updated_at' => date('Y-m-d H:i:s')
		];

		$this->db->where('id', $id);
		return $this->db->update('posts', $data);
	}

	public function delete_post($id) {
		$this->db->where('id', $id);
		$this->db->delete('posts');
		return true;
	}

	public function get_num_rows_by_category($category_id) { 
		$query = $this->db->get_where('posts', array('cat_id' => $category_id));
		return $query->num_rows(); 
	}

	public function get_posts_by_category($category_id, $limit, $offset) {
		$this->db->select('posts.*');
		$this->db->order_by('posts.id', 'DESC');
		$this->db->limit($limit, $offset);
		$this->db->join('categories', 'categories.id = posts.cat_id');
		$query = $this->db->get_where('posts', array('cat_id' => $category_id));
		return $query->result();
	}

	public function count_posts_in_category($category_id) {
		return $this->db
		->where('cat_id', $category_id)
		->count_all_results('posts');
	}

}