<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.min.css')?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css')?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/css/style.css')?>">
	<script src="<?php echo base_url('assets/lib/ckeditor/ckeditor.js')?>"></script>
	<title><?php echo $site_title . " | " . $tagline; ?></title>
</head>
<body>
	<div class="site-wrapper">
		<nav class="navbar sticky-top navbar-dark bg-dark flex-wrap2 flex-md-nowrap p-0 py-md-1">
			<a class="navbar-brand col-auto mr-0 px-2 pl-md-1" href="<?php echo base_url(); ?>">
				<?php echo $site_title ?>
			</a>
			<button class="navbar-toggler d-md-none mt-1 mr-2" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<?php echo form_open(base_url('posts/search'), ['id' => 'search_form', 'class' => 'w-100 py-1 px-2 px-md-3 px-lg-5']); ?>
			<div class="input-group <?php if(form_error('search')) echo 'has-error';?>">
				<input class="form-control form-control-dark" type="text" name="search" placeholder="Search posts..." aria-label="Search">
				<?php if(form_error('search')) echo form_error('search'); ?> 
				<div class="input-group-append">
					<button class="btn btn-success" type="submit"><i class="fa fa-search"></i></button>
				</div>
			</div>
			<?php echo form_close(); ?>
			<div class="navbar-nav navbar-expand-md">
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav mr-auto px-2 pl-md-1 pr-md-2 text-nowrap">
						<li class="nav-item dropdown my-1">
							<a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="fa fa-folder-open" aria-hidden="true"></i> Categories
							</a>
							<div class="dropdown-menu">
								<?php foreach ($categories as $category): ?>
									<a class="dropdown-item" href="<?php echo base_url('/categories/posts/'.$category->id); ?>"><?php echo $category->name; ?></a>
								<?php endforeach; ?>
							</div>
						</li>
						<?php if($this->session->userdata('is_logged_in')) : ?>
							<li class="nav-item dropdown my-1">
								<a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<i class="fa fa-user-circle-o" aria-hidden="true"></i> Welcome, <?php echo $this->session->userdata('user_first_name'); ?></a>
									<div class="dropdown-menu">
										<a class="dropdown-item" href="<?php echo base_url('dashboard') ?>">Dashboard</a>
										<a class="dropdown-item" href="<?php echo base_url('posts/create') ?>">Add post</a>
										<a class="dropdown-item" href="<?php echo base_url('categories/create') ?>">Add category</a>
									</div>
								</li>
								<li class="nav-item my-1">
									<a href="<?php echo base_url('login/logout'); ?>" class="nav-link btn btn-outline-success"><i class="fa fa-sign-out"></i> Logout</a>
								</li>
								<?php else: ?>
									<li class="nav-item my-1">
										<a href="<?php echo base_url('login'); ?>" class="nav-link btn btn-outline-success"><i class="fa fa-sign-in"></i> Login</a>
									</li>
									<li class="nav-item my-1 ml-1">
										<a href="<?php echo base_url('register'); ?>" class="nav-link btn btn-outline-success"><i class="fa fa-user-plus"></i> Register</a>
									</li>
								<?php endif; ?>
							</ul>
						</div>
					</div>
				</nav>

				<div id="flash_messages" class="container text-center mt-3">

					<?php if($this->session->flashdata('user_registered')): ?>
						<?php echo '<p class="alert alert-success">'. $this->session->flashdata('user_registered') . '</p>'; ?>
					<?php endif; ?>

					<?php if($this->session->flashdata('post_created')): ?>
						<?php echo '<p class="alert alert-success">' . $this->session->flashdata('post_created') . '</p>'; ?>
					<?php endif; ?>

					<?php if($this->session->flashdata('post_updated')): ?>
						<?php echo '<p class="alert alert-success">' . $this->session->flashdata('post_updated') . '</p>'; ?>
					<?php endif; ?>

					<?php if($this->session->flashdata('post_deleted')): ?>
						<?php echo '<p class="alert alert-success">' . $this->session->flashdata('post_deleted') . '</p>'; ?>
					<?php endif; ?>

					<?php if($this->session->flashdata('comment_added')): ?>
						<?php echo '<p class="alert alert-success">'. $this->session->flashdata('comment_added') . '</p>'; ?>
					<?php endif; ?>

					<?php if($this->session->flashdata('category_created')): ?>
						<?php echo '<p class="alert alert-success">' . $this->session->flashdata('category_created') . '</p>'; ?>
					<?php endif; ?>

					<?php if($this->session->flashdata('category_updated')): ?>
						<?php echo '<p class="alert alert-success">' . $this->session->flashdata('category_updated') . '</p>'; ?>
					<?php endif; ?>

					<?php if($this->session->flashdata('login_failure_incorrect')): ?>
						<?php echo '<p class="alert alert-danger">' . $this->session->flashdata('login_failure_incorrect') . '</p>'; ?>
					<?php endif; ?>

					<?php if($this->session->flashdata('login_failure_activation')): ?>
						<?php echo '<p class="alert alert-danger">' . $this->session->flashdata('login_failure_activation') . '</p>'; ?>
					<?php endif; ?>

					<?php if($this->session->flashdata('user_signin')): ?>
						<?php echo '<p class="alert alert-success">'.$this->session->flashdata('user_signin').'</p>'; ?>
					<?php endif; ?>

					<?php if($this->session->flashdata('user_signout')): ?>
						<?php echo '<p class="alert alert-success">' . $this->session->flashdata('user_signout') . '</p>'; ?>
					<?php endif; ?>

					<!-- Ajax delete messages -->

					<p id="post_delete_msg" class="alert alert-hidden alert-success"></p>

					<p id="comment_delete_msg" class="alert alert-hidden alert-success"></p>

				</div>