<div class="container">
  <main class="wide-content">
    <div class="col-sm-10 col-md-8 col-lg-6 mx-auto my-4 px-1">
        <div class="card bg-light">
          <div class="card-header bg-light">Edit your account information</div>
          <div class="card-body">
            <?php echo form_open(base_url('dashboard/users/update')); ?>

            <input type="hidden" name="id" id="uid" value="<?php echo $author->id; ?>">

            <div class="form-group <?php if(form_error('first_name')) echo 'has-error';?>">
              <input type="text" name="first_name" id="first_name" class="form-control" value="<?php echo $author->first_name;?>" placeholder="First name">
              <?php if(form_error('first_name')) echo form_error('first_name'); ?> 
            </div>

            <div class="form-group <?php if(form_error('last_name')) echo 'has-error';?>">
              <input type="text" name="last_name" id="last_name" class="form-control" value="<?php echo $author->last_name;?>" placeholder="Last name">
              <?php if(form_error('last_name')) echo form_error('last_name'); ?> 
            </div>

            <div class="form-group <?php if(form_error('email')) echo 'has-error';?>">
              <input type="text" name="email" id="email" class="form-control" value="<?php echo $author->email;?>" placeholder="Email">
              <?php if(form_error('email')) echo form_error('email'); ?> 
            </div>

            <div class="form-group <?php if(form_error('bio')) echo 'has-error';?>">
              <textarea name="bio" id="bio" cols="30" rows="5" class="form-control" placeholder="Add a short bio"><?php echo $author->bio; ?></textarea>
              <?php if(form_error('bio')) echo form_error('bio'); ?> 
            </div>

            <div class="form-group">
              <input type="submit" value="Save" class="btn btn-block btn-md btn-success">
            </div>            
            <?php echo form_close(); ?>
          </div>
        </div>
      </div>
  </main>
</div>