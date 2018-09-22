<div class="container fluid-fixed">
  <div class="content-wrapper">
    <main class="content">
      <div class="card bg-light">
        <div class="card-header bg-light">New Category</div>
        <div class="card-body">
          <?php echo form_open(base_url('categories/create')); ?>
            <div class="form-group <?php if(form_error('title')) echo 'has-error';?>">
             <input type="text" name="category_name" id="category_name" class="form-control" placeholder="Category name">
            <?php if(form_error('category_name')) echo form_error('category_name'); ?> 
          </div>
          <div class="form-group">
            <input type="submit" value="Add category" class="btn btn-block btn-md btn-success">
          </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </main>
</div>
<?php $this->load->view("partials/sidebar");?>
</div>