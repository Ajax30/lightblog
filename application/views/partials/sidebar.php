<aside class="sidebar">

  <div class="banner-container">
    <img src="https://ppc.news/wp-content/uploads/2017/08/Medium-Rectangle-300x250.jpg" alt="banner">
  </div>

  <div class="tabbed-sidebar">
    <div class="tabbed-heading">
      <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item"><a class="nav-link active" href="#new" role="tab" data-toggle="tab">New</a></li>
        <li class="nav-item"><a class="nav-link" href="#categories" role="tab" data-toggle="tab">Categories</a></li>
        <li class="nav-item"><a class="nav-link" href="#topcomments" role="tab" data-toggle="tab">Top comments</a></li>
      </ul>
    </div>
    <div class="tab-content">
      <div role="tabpanel" class="tab-pane fade in active show" id="new">
       <ul class="list-unstyled news-list">
        <?php foreach ($posts as $post) :?>
          <li>
            <div class="thumbnail">
              <a href="<?php echo base_url('/') . $post->slug; ?>"><img src="<?php echo base_url('assets/img/posts/') . $post->post_image; ?>" alt="<?php echo $post->title; ?>" class="img-thumbnail"></a>
            </div>
            <div class="text">
              <h3><?php echo $post->title; ?></h3>
              <p><?php echo word_limiter($post->description, 10); ?></p>
            </div>
          </li>
        <?php endforeach ?>        
      </ul>
    </div>
    <div role="tabpanel" class="tab-pane fade" id="categories">
      <div class="list-group">
        <?php foreach ($categories as $category): ?>
          <a href="<?php echo base_url('/categories/posts/'.$category->id); ?>" class="list-group-item list-group-item-action">
            <span class="text-muted"><?php echo $category->name; ?></span>
            <span class="badge badge-secondary badge-pill pull-right"><?php echo $category->posts_count; ?></span>
          </a>
        <?php endforeach; ?>       
      </div>
    </div>
    <div role="tabpanel" class="tab-pane fade" id="topcomments">
      <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
    </div>
  </div>
</div>

</aside>