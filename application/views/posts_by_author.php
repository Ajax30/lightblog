<?php $posts_count == 1 ? $results = "post" : $results = "posts";?>

<div class="container">
		<h1 class="display-4 results-found">We found <?php echo $posts_count . ' ' . $results; ?> by <?php echo $posts_author->first_name . ' ' . $posts_author->last_name; ?></h1>	
	<?php if ($posts): ?>
		<div class="row posts-grid">
			<?php foreach ($posts as $post) :?>
				<div class="col-xs-12 col-sm-6 col-lg-4 col-xl-3">
					<div class="post">
						<div class="thumbnail">
							<a href="<?php echo base_url('/') . $post->slug; ?>">
								<img src="<?php echo base_url('assets/img/posts/') . $post->post_image; ?>" />
							</a>
						</div>
						<div class="text">
							<p class="post-category">
								<a href="<?php echo base_url('/categories/posts/') . $post->cat_id;?>">
									<?php echo $post->post_category; ?>									
								</a>
							</p>
							<h2 class="card-title">
								<a href="<?php echo base_url('/') . $post->slug; ?>">
									<?php echo $post->title; ?>
								</a>
							</h2>
							<p class="text-muted"><?php echo $post->description; ?></p>
						</div>
						<div class="read-more">
							<a class="btn btn-block btn-sm btn-success" href="<?php echo base_url('/') . $post->slug; ?>">Read more</a>
						</div>
					</div>
				</div>
			<?php endforeach ?>
		</div>
	<?php else: ?>
		<div class="col-xs-12">
			<p class="text-muted" id="no_posts">No posts found.</p>
		</div>
	<?php endif; ?>
	
	<?php //$this->load->view("partials/pagination");?>

</div>