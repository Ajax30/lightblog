	<div class="site-footer-wrapper">
		<div class="footer-copyright">
			<p class="text-center">&copy; <?php echo $company_name; ?>. All rights reserved</p>
		</div>
	</div>
</div>
<script src="<?php echo base_url('assets/js/jquery.min.js')?>"></script>
<script src="<?php echo base_url('assets/js/popper.min.js')?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js')?>"></script>
<script src="<?php echo base_url('assets/js/jquery.validate.min.js')?>"></script>
<?php if (isset($post->post_image)): ?>
<script src="<?php echo base_url('assets/js/printThis.js')?>"></script>
<?php endif; ?>
<script src="<?php echo base_url('assets/js/app.js')?>"></script>
<script>CKEDITOR.replace('body');</script>
</body>
</html>