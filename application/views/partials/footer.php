	<div class="site-footer-wrapper">
		<div class="container-fluid bg-dark">
			<footer class="site-footer row">
				<div class="col-sm-6 col-md-3">
					<h3>Company</h3>
					<ul class="list-unstyled">
						<li><a href="#">About Us</a></li>
						<li><a href="#">Careers</a></li>
					</ul>
				</div>
				<div class="col-sm-6 col-md-3">
					<h3>Support</h3>
					<ul class="list-unstyled">
						<li><a href="#">Contact</a></li>
						<li><a href="#">Feedback</a></li>
					</ul>
				</div>
				<div class="col-sm-6 col-md-3">
					<h3>Legal</h3>
					<ul class="list-unstyled">
						<?php foreach ($pages as $page): ?>
							<li><a href="<?php echo base_url('pages/page/') . $page->id; ?>"><?php echo $page->title; ?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>
				<div class="col-sm-6 col-md-3">
					<h3>My account</h3>
					<ul class="list-unstyled">
						<li><a href="<?php echo base_url('login'); ?>">Signin</a></li>
						<li><a href="<?php echo base_url('register'); ?>">Signup</a></li>
					</ul>
				</div>
			</footer>
		</div>
		<div class="footer-copyright">
			<p class="text-center">&copy; <?php echo $company_name; ?>. All rights reserved</p>
		</div>
	</div>
</div>
<script src="<?php echo base_url('assets/js/jquery.min.js')?>"></script>
<script src="<?php echo base_url('assets/js/popper.min.js')?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js')?>"></script>
<script src="<?php echo base_url('assets/js/jquery.validate.min.js')?>"></script>
<script src="<?php echo base_url('assets/js/app.js')?>"></script>
<script>CKEDITOR.replace('body');</script>
</body>
</html>