<?php if ($is_featured == true && count($featured) > 1): ?>
	<div class="container carousel-container">
		<div id="demo" class="carousel slide" data-ride="carousel">
			<div class="carousel-inner">
				<?php $count = 0?>
				<?php foreach ($featured as $p) :?>
				<?php $count=$count + 1?>
				<div class="carousel-item <?php if ($count == 1): ?>active<?php endif; ?>">
					<div class="row">
						<a class="col-sm-6 col-md-7 col-lg-8 image-container p-0" href="<?php echo base_url('/') . $p->slug; ?>">
							<img src="<?php echo base_url('assets/img/posts/') . $p->post_image; ?>" alt="<?php echo $p->title; ?>" class="img-fluid" />
						</a>
						<div class="col-sm-6 col-md-5 col-lg-4 text-container bg-light">
							<div class="my-auto py-2 text-center">
								<h2 class="display-4"><?php echo $p->title; ?></h2>
								<p><?php echo $p->description; ?></p>
								<div class="mb-1">
									<a href="<?php echo base_url('/') . $p->slug; ?>" class="btn btn-md btn-success">Read more</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
			<!-- Left and right controls -->
			<a class="carousel-control carousel-control-prev" href="#demo" data-slide="prev">
				<i class="fa fa-arrow-left"></i>
			</a>
				<a class="carousel-control carousel-control-next" href="#demo" data-slide="next">
				<i class="fa fa-arrow-right"></i>
			</a>
		</div>
	</div>
<?php endif; ?>