<div class="container">
	<div class="posts-grid">
		<?php foreach ($posts as $post) :?>
			<div class="col-xs-12 col-sm-6 col-lg-4 col-xl-3">
				<div class="post">
					<div class="thumbnail">
						<a href="<?php echo base_url('posts/post/') . $post->id; ?>">
							<img src="<?php echo base_url('assets/img/posts/') . $post->post_image; ?>" />
						</a>
					</div>
					<div class="text">
						<h2 class="card-title">
							<a href="<?php echo base_url('posts/post/') . $post->id; ?>">
								<?php echo $post->title; ?>
							</a>
						</h2>
						<p class="text-muted"><?php echo $post->description; ?></p>
					</div>
					<div class="read-more">
						<a class="btn btn-block btn-sm btn-success" href="<?php echo base_url('posts/post/') . $post->id; ?>">Read more</a>
					</div>
				</div>
			</div>
		<?php endforeach ?>
	</div>

	<?php $this->load->view("partials/pagination");?>

</div>