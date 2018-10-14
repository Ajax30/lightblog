<div class="container">
	<div class="col-xs-12">
		
		<?php $posts_count == 1 ? $results = "post" : $results = "posts";?>

		<h1 class="display-4 search-results">We found <?php echo $posts_count . ' ' . $results; ?> containing <span class="quote-inline"><?php echo $expression; ?></span></h1>
	</div>	
	<?php if ($posts): ?>
		<div class="posts-grid">
			<?php foreach ($posts as $post) :?>
				<div class="col-xs-12 col-sm-6 col-lg-4 col-xl-3">
					<div class="post">
						<div class="thumbnail">
							<a href="<?php echo base_url('posts/post/') . $post->slug; ?>">
								<img src="<?php echo base_url('assets/img/posts/') . $post->post_image; ?>" />
							</a>
						</div>
						<div class="text">
							<h2 class="card-title">
								<a href="<?php echo base_url('posts/post/') . $post->slug; ?>">
									<?php echo $post->title; ?>
								</a>
							</h2>
							<p class="text-muted"><?php echo $post->description; ?></p>
						</div>
						<div class="read-more">
							<a class="btn btn-block btn-sm btn-success" href="<?php echo base_url('posts/post/') . $post->slug; ?>">Read more</a>
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
	
	<?php $this->load->view("partials/pagination");?>

</div>