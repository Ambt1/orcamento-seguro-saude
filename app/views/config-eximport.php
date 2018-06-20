<div class="wrap">
  <?php if (isset($_GET['status']) && $_GET['status'] == "imported") : ?>
    <div class="notice notice-success"><p>A importação foi realizada com sucesso.</p></div>  
  <?php endif; ?>
  <?php if (isset($_GET['status']) && $_GET['status'] == "error") : ?>
    <div class="notice notice-error"><p>Houve um erro com a importação. Revise a extensão do arquivo ou tente mais tarde.</p></div>  
  <?php endif; ?>
  <h1 class="wp-heading-inline">Exportar dados do plugin</h1>
  <p>
    <a class="button button-primary" href="<?php echo admin_url('admin-post.php?action=export_data') ?>">Quero exportar dados</a>
  </p>
  <hr>
  <h1 class="wp-heading-inline">Importar dados do plugin</h1>
  <form id="ss-amb1-config" enctype="multipart/form-data" action="<?php echo admin_url('admin-post.php?action=import_data') ?>" method="POST">
    <input type="hidden" name="action" value="import_data">
    <input type="file" name="import_data" accept=".amb1">
    <?php submit_button('Importar dados', $type = 'primary', $name = 'submit', $wrap = true, $other_attributes = array("id" => "importbtn")); ?>
  </form>
</div>