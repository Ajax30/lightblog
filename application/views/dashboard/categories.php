<div class="container fluid-fixed">
  <div class="content-wrapper">
    <main class="dashboard-content wide-content">
      <div class="row">
        <?php $this->load->view("dashboard/partials/sidebar");?>
        <div class="col-sm-7 col-md-9">
          <div class="card bg-light">
            <h6 class="card-header text-dark">Categories</h6>
            <div class="card-body bg-white p-0">
              <table class="table table-striped table-sm mb-0">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th class="w-75">Name</th>
                    <th class="text-center">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($categories as $category): ?>
                  <tr id="<?php echo $category->id; ?>">
                    <td><?php echo $category->id; ?></td>
                    <td><?php echo $category->name; ?></td>
                    <td class="text-center">
                      <div class="btn-group btn-group-sm" role="group">
                        <?php if($this->session->userdata('user_is_admin')) : ?>
                        <a href="<?php echo base_url('dashboard/categories/edit/') . $category->id; ?>" class="btn btn-success"><i class="fa fa-pencil-square-o"></i> Edit</a>
                        <a href="<?php echo base_url('dashboard/categories/delete/') . $category->id; ?>" class="delete-category btn btn-success"><i class="fa fa-trash"></i> Delete</a>
                        <?php else: ?>
                        <a href="#" class="btn btn-success disabled">Edit</a>
                        <a href="#" class="btn btn-success disabled">Delete</a>
                        <?php endif; ?>
                      </div>
                    </td>
                  </tr>
                  <?php endforeach ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</div>