<div class="comments mt-4" id="comments_container">
  <?php if ($comments): ?>
    <?php foreach ($comments as $comment): ?>
      <?php if ($comment->aproved == 1): ?>
        <div class="card bg-light mb-3 comment">
          <h5 class="card-header p-2">
            <span class="row">
              <span class="col-sm-6 text-dark"><?php echo $comment->name; ?> says:</span>
              <span class="col-sm-6 text-dark d-none d-sm-block text-right"><?php echo nice_date($comment->created_at, 'M d, Y'); ?> at <?php echo nice_date($comment->created_at, 'H:i:s'); ?></span>
            </span>
          </h5>
          <div class="card-body bg-white p-2">
            <p><?php echo $comment->comment; ?></p>
          </div>
        </div>
      <?php endif ?>
    <?php endforeach ?>
    <?php else: ?>
      <p>There are no comments yet</p>
    <?php endif ?>
  </div>

  <div class="comment-form-wrapper">
    <h3 class="comment-form-title">Leave a comment</h3>

    <p id="comment_add_msg" class="alert alert-hidden alert-success mb-4"></p>

    <?php echo form_open (base_url('comments/create/') . $post->id, array('id' => 'commentForm', 'class' => 'comment-form ajax-form', 'data-post'  => 'comment')); ?>
    <input type="hidden" name="postid" value="<?php echo $post->id; ?>">
    <input type="hidden" name="slug" value="<?php echo $post->slug; ?>">

    <div class="form-group <?php if(form_error('name')) echo 'has-error';?>">
      <input type="text" name="name" id="name" class="form-control" placeholder="Name" data-rule-required="true">
      <?php if(form_error('name')) echo form_error('name'); ?> 
    </div>

    <div class="form-group <?php if(form_error('email')) echo 'has-error';?>">
      <input type="email" name="email" id="email" class="form-control" placeholder="Email" data-rule-required="true">
      <?php if(form_error('email')) echo form_error('email'); ?> 
    </div>

    <div class="form-group <?php if(form_error('message')) echo 'has-error';?>">
      <textarea name="message" id="message" cols="30" rows="5" class="form-control" placeholder="Comment" data-rule-required="true"></textarea>
      <?php if(form_error('message')) echo form_error('message'); ?> 
    </div>

    <div class="form-group">
      <input type="submit" value="Comment" class="btn btn-block btn-md btn-success">
    </div>
    <?php echo form_close(); ?>
  </div>


