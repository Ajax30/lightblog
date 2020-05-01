<div class="container fluid-fixed">
  <div class="content-wrapper">
    <main class="content">
      <h2 class="page-title display-4"><?php echo $page->title; ?></h2>
      <div class="page-content">
        <?php echo $page->content; ?>
      </div>
    </main>
  </div>
  <?php $this->load->view("partials/sidebar");?>
</div>