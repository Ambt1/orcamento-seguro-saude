<div class="wrap">
  <?php if (isset($_GET['status']) && $_GET['status'] == "imported") : ?>
    <div class="notice notice-success"><p>A importação foi realizada com sucesso.</p></div>  
  <?php endif; ?>
  <?php if (isset($_GET['status']) && $_GET['status'] == "error") : ?>
    <div class="notice notice-error"><p>Houve um erro com a importação. Revise a extensão do arquivo ou tente mais tarde.</p></div>  
  <?php endif; ?>
  <h1 class="wp-heading-inline">Exportar dados do plugin</h1>
  <form id="ss-amb1-config" enctype="multipart/form-data" action="<?php echo admin_url('admin-post.php?action=export_data') ?>" method="POST">
    <p>
      <p>Escolha as opções abaixo se desejar <b>NÃO</b> importar os itens abaixo.</p>
    </p>
    <p>
      <label class="checkbox">
        <input type="checkbox" name="tableOptions[]" value="leads"> Lista de Interessados
      </label>
      <label class="checkbox">
        <input type="checkbox" name="tableOptions[]" value="status"> Lista de Status
      </label>
    </p>
    <?php submit_button('Quero exportar dados', $type = 'primary', $name = 'submit', $wrap = true, $other_attributes = ''); ?>
  </form>
  <hr>
  <h1 class="wp-heading-inline">Importar dados do plugin</h1>
  <p>Selecione um arquivo do tipo <code>.amb1</code> para fazer o upload.</p>
  
  <form id="ss-amb1-config" enctype="multipart/form-data" action="<?php echo admin_url('admin-post.php?action=import_data') ?>" method="POST">
    <input type="hidden" name="action" value="import_data">
    <p>
      <input type="file" name="import_data" accept=".amb1">
    </p>
    <?php submit_button('Importar dados', $type = 'primary', $name = 'submit', $wrap = true, $other_attributes = array("id" => "importbtn")); ?>
  </form>
</div>