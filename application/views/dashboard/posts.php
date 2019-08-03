<div class="container fluid-fixed">
  <div class="content-wrapper">
    <main class="dashboard-content wide-content">
      <div class="row">
        <?php $this->load->view("dashboard/partials/sidebar");?>
        <div class="col-sm-7 col-md-9">
          <div class="card bg-light">
            <h6 class="card-header text-dark">Posts</h6>
            <div class="card-body bg-white p-0">
              <div class="table-responsive">
                <table class="table table-striped table-sm mb-0">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th class="w-50">Title</th>
                      <th>Publication date</th>
                      <th class="text-center">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($posts as $index => $post): ?>
                      <tr data-slug="<?php echo $post->slug; ?>">
                        <td class="text-right"><?php $count = $index + 1; echo $count + $offset; ?></td>
                        <td><?php echo $post->title; ?></td>
                        <td><?php echo nice_date($post->created_at, 'D, M d, Y'); ?></td>
                        <td class="text-center">
                          <div class="btn-group btn-group-sm" role="group">
                            <a href="<?php echo base_url('posts/post/') . $post->slug; ?>" class="btn btn-success"><i class="fa fa-eye"></i> View</a>
                            <?php if(($this->session->userdata('is_logged_in') && $this->session->userdata('user_id') == $post->author_id) || $this->session->userdata('user_is_admin')) : ?>
                              <a href="<?php echo base_url('posts/edit/') . $post->slug; ?>" class="btn btn-success"><i class="fa fa-pencil-square-o"></i> Edit</a>
                              <a href="#" data-slug="<?php echo $post->slug ?>" class="delete-post ajax-btn btn btn-success"><i class="fa fa-trash"></i> Delete</a>
                            <?php else: ?>
                              <a href="#" class="btn btn-success disabled"><i class="fa fa-pencil-square-o"></i> Edit</a>
                              <a href="#" class="btn btn-success disabled"><i class="fa fa-trash"></i> Delete</a>
                            <?php endif; ?>
                          </div>
                        </td>
                      </tr>
                    <?php endforeach ?>
                  </tbody>
                </table>
              </div>
              <div class="card-footer bg-white py-1">
                <?php $this->load->view("partials/pagination");?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</div>