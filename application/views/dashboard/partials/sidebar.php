<div class="col-sm-5 col-md-3 pr-0">
  <div class="card-list-group card bg-light mb-3">
    <h6 class="card-header text-dark">Dashboard</h6>
    <div class="card-body p-0 bg-white">
      <ul class="list-group">
        <a href="<?php echo base_url('dashboard/posts'); ?>" class="list-group-item d-flex justify-content-between align-items-center">
          <span class="text-muted">Posts</span>
          <span id="posts_count" class="badge badge-secondary badge-pill"><?php echo $number_of_posts; ?></span>
        </a>
        <a href="<?php echo base_url('dashboard/pages'); ?>" class="list-group-item d-flex justify-content-between align-items-center">
          <span class="text-muted">Pages</span>
          <span class="badge badge-secondary badge-pill"><?php echo $number_of_pages; ?></span>
        </a>
        <a href="<?php echo base_url('dashboard/categories'); ?>" class="list-group-item d-flex justify-content-between align-items-center">
          <span class="text-muted">Categories</span>
          <span class="badge badge-secondary badge-pill"><?php echo $number_of_categories; ?></span>
        </a>
        <a href="<?php echo base_url('dashboard/comments'); ?>" class="list-group-item d-flex justify-content-between align-items-center">
          <span class="text-muted">Comments</span>
          <span id="comments_count" class="badge badge-secondary badge-pill"><?php echo $number_of_comments; ?></span>
        </a>
      </ul>
    </div>
  </div>
</div>