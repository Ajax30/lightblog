<div class="container fluid-fixed">
  <div class="content-wrapper">
    <main class="content">
      <h2 class="post-title display-4"><?php echo $post->title; ?></h2>
      <div class="row post-meta">
        <div class="left-half col-sm-9">
          <span class="author">By <a href="#"><?php echo $post->first_name . " " . $post->last_name; ?></a></span> | <span class="date"><?php echo nice_date($post->created_at, 'M d, Y'); ?></span>
        </div>
        <div class="right-half col-sm-3">
          <?php $comments_count = count($comments); $comments_status = $comments_count > 0 ? $comments_count . ' comments': "No comments"; ?>
          <a class="comments" id="comments_status" href="#" title="<?php echo $comments_status; ?>"><i class="fa fa-comments"></i> <?php echo $comments_status; ?></a>
        </div>
      </div>
      <div class="post-thumbnail">
        <img src="<?php echo base_url('assets/img/posts/') . $post->post_image; ?>" />
      </div>
      <div class="post-content">
        <?php echo $post->content; ?>
      </div>
      
      <?php if($this->session->userdata('is_logged_in') && $this->session->userdata('user_id') == $post->author_id) : ?>
        <div id="actions" class="text-center">
          <hr>
          <div class="btn-group" role="group">
            <a href="<?php echo base_url('posts/delete/') . $post->id; ?>" title="Delete post" class="delete-post btn btn-sm btn-success"><i class="fa fa-trash"></i> Delete</a>
            <a href="<?php echo base_url('posts/edit/') . $post->id; ?>" title="Edit post" class="btn btn-sm btn-success"><i class="fa fa-pencil-square-o"></i> Edit</a>
            <a href="<?php echo base_url('posts/disable/') . $post->id; ?>" title="Disable post" class="btn btn-sm btn-success"><i class="fa fa-ban"></i> Disable</a>
          </div>
        </div>
      <?php endif; ?>

      <?php $this->load->view("partials/comments");?>

    </main>
  </div>

  <?php $this->load->view("partials/sidebar");?>

</div>