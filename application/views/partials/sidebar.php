<aside class="sidebar">

  <div class="banner-container">
    <img src="<?php echo base_url('assets/img')?>/Medium-Rectangle-300x250.jpg" alt="banner">
  </div>

  <div class="tabbed-sidebar">
    <div class="tabbed-heading">
      <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item"><a class="nav-link active" href="#newest_posts" role="tab" data-toggle="tab">New</a></li>
        <li class="nav-item"><a class="nav-link" href="#authors_list" role="tab" data-toggle="tab">Authors</a></li>
        <li class="nav-item"><a class="nav-link" href="#categories" role="tab" data-toggle="tab">Categories</a></li>
      </ul>
    </div>

    <div class="tab-content">
      <div role="tabpanel" class="tab-pane fade in active show" id="newest_posts">
        <ul class="list-unstyled sidebar-list d-table">
          <?php foreach ($posts as $post) :?>
            <li class="d-table-row">
              <div class="thumbnail d-table-cell">
                <a href="<?php echo base_url('/') . $post->slug; ?>"><img src="<?php echo base_url('assets/img/posts/') . $post->post_image; ?>" alt="<?php echo $post->title; ?>" class="img-thumbnail"></a>
              </div>
              <div class="text d-table-cell">
                <h3><?php echo $post->title; ?></h3>
                <p><?php echo word_limiter($post->description, 7); ?></p>
              </div>
            </li>
          <?php endforeach ?>        
        </ul>
      </div>

      <div role="tabpanel" class="tab-pane fade" id="authors_list">
        <ul class="list-unstyled sidebar-list d-table">
          <?php foreach ($authors as $author) :?>

            <?php $author_image = isset($author->avatar) && $author->avatar !== '' ? $author->avatar : 'default-avatar.png'; ?>

            <li class="d-table-row">
              <div class="thumbnail d-table-cell text-center">
                <a href="<?php echo base_url('/posts/byauthor/') . $author->id; ?>">
                  <img src="<?php echo base_url('assets/img/authors/') . $author_image; ?>" alt="<?php echo $author->first_name . ' ' . $author->last_name; ?>" class="img-thumbnail rounded-circle">
                </a>
              </div>
              <div class="text d-table-cell">
                <h3><?php echo $author->first_name . ' ' . $author->last_name; ?></h3>
                <p><?php echo word_limiter($author->bio, 12); ?></p>
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
    </div>
  </div>

</aside>