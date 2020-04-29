<div class="container fluid-fixed">
  <div class="content-wrapper">
    <main class="content" id="post_content">
      <h2 class="post-title display-4"><?php echo $post->title; ?></h2>
      <div class="row post-meta">
        <div class="left-half col-sm-8">
          
          <?php $author_image = isset($post->avatar) && $post->avatar !== '' ? $post->avatar : 'default-avatar.png'; ?>

          <span class="author">
            <a href="<?php echo base_url('posts/byauthor/') . $post->author_id; ?>">
              <img src="<?php echo base_url('assets/img/authors/') . $author_image; ?>" alt="<?php echo $post->first_name . ' ' . $post->last_name; ?>" class="rounded-circle">
              <span class="pl-1"><?php echo $post->first_name . " " . $post->last_name; ?></span>
            </a>
            </span> <strong>&#183;</strong> <span class="date"><?php echo nice_date($post->created_at, 'M d, Y'); ?></span>
        </div>
        <div class="right-half col-sm-4">
          <?php $comments_count = count($comments); $comments_status = $comments_count > 0 ? $comments_count . ' comments': "No comments"; ?>
          <a class="comments" id="comments_status" href="#" title="<?php echo $comments_status; ?>"><i class="fa fa-comments"></i> <?php echo $comments_status; ?></a> <strong>&#183;</strong>
          <a href="#" id="print_post"><i class="fa fa-print"></i> Print</a>
        </div>
      </div>
      <div class="post-thumbnail">
        <img src="<?php echo base_url('assets/img/posts/') . $post->post_image; ?>" alt="<?php echo $post->title; ?>" />
      </div>
      <div class="post-content">
        <?php echo $post->content; ?>
      </div>

      <?php if($this->session->userdata('is_logged_in') && $this->session->userdata('user_id') == $post->author_id) : ?>
      <div id="actions" class="text-center">
        <hr>
        <div class="btn-group" role="group">
          <a href="<?php echo base_url('dashboard/posts/delete/') . $post->slug; ?>" title="Delete post" class="delete-post btn btn-sm btn-success"><i class="fa fa-trash"></i> Delete</a>
          <a href="<?php echo base_url('dashboard/posts/edit/') . $post->slug; ?>" title="Edit post" class="btn btn-sm btn-success"><i class="fa fa-pencil-square-o"></i> Edit</a>
        </div>
      </div>
      <?php else: ?>
       <div class="text-center pt-2">
         <div class="fb-share-button" data-href="<?php echo base_url('/') . $post->slug; ?>" data-layout="button_count" data-size="large"></div>
       </div>
     <?php endif; ?>

     <?php $this->load->view("partials/comments");?>

   </main>
 </div>

 <?php $this->load->view("partials/sidebar");?>

</div>