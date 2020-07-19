<div class="wrap">
  <?php if (isset($categoryWarn)) : ?>
    <div class="notice notice-error">
      <p>
        <?php echo $categoryWarn['msg']; ?>
      </p>
    </div>
  <?php endif; ?>
  <?php if (isset($statusWarning)) : ?>
    <div class="notice notice-error">
      <p>
        <?php echo $statusWarning['msg']; ?>
      </p>
    </div>
  <?php endif; ?>
  <form id="frmPlano" action="process.php" method="post" class="add-plano">
    <input type="hidden" name="redirect_url" value="<?php echo admin_url('admin.php?page=seguro-saude'); ?>">
    <input type="hidden" name="plan_id" id="plan_id" value="<?php echo isset($prepared['plano_id']) ? $prepared['plano_id'] : '' ?>">
    <input type="hidden" name="total_ages_edit" id="total_ages_edit" value="<?php echo isset($prepared['ages_list']) ? count($prepared['ages_list']['age_min']) : 0 ?>">
    <div id="icon-options-general" class="icon32"></div>
    <h1><?php echo isset($prepared['plano_id']) ? 'Editar novo plano' : 'Adicionar novo plano' ?></h1>
    <div id="titlediv">
      <div id="titlewrap">
        <input type="text" name="plano_title" size="30" placeholder="Digite o título aqui" value="<?php echo isset($prepared['name']) ? $prepared['name'] : '' ?>" id="title" spellcheck="true" autocomplete="off" required>
      </div>
      <div class="inside">
        <div id="edit-slug-box" class="hide-if-no-js">
        </div>
      </div>
    </div>
    <div id="poststuff">
      <div id="post-body" class="metabox-holder columns-2">
        <div id="post-body-content">
          <div id="step1">
            <div class="postbox">
              <button type="button" class="handlediv" aria-expanded="true">
                <span class="screen-reader-text">Alternar painel: Tags</span>
                <span class="toggle-indicator" aria-hidden="true"></span>
              </button>
              <h2 class="hndle ui-sortable-handle">
                <span>Faixa Etárias</span>
              </h2>
              <div class="inside">
                <div class="item--wrapper">
                  <?php if (isset($prepared)) : foreach ($prepared['ages_list']['age_min'] as $key => $age): ?>
                    <label data-line="<?php echo $key + 1; ?>" class="label--item"> 
                      de
                      <input value="<?php echo $age; ?>" class="small-text" type="number" name="age_range_min[]" placeholder="00" min="0" max="99" required>
                      até
                      <input value="<?php echo $prepared['ages_list']['age_max'][$key]; ?>" class="small-text" type="number" name="age_range_max[]" placeholder="99" min="0" max="99" required>
                      <input class="button-secondary" type="button" name="remove_item" value="apagar" />
                    </label>
                  <?php endforeach; else: ?>
                    <label class="label--item">
                      de
                      <input value="" class="small-text" type="number" name="age_range_min[]" placeholder="00" min="0" max="99" required>
                      até
                      <input value="" class="small-text" type="number" name="age_range_max[]" placeholder="99" min="0" max="99" required>
                      <input class="button-secondary" type="button" name="remove_item" value="apagar" />
                    </label>
                  <?php endif; ?>
                </div>
                <input class="button-primary button-block" type="button" name="add_item" data-section="age" value="Adicionar Novo" />
              </div>
            </div>
            <div class="postbox">
              <button type="button" class="handlediv" aria-expanded="true">
                <span class="screen-reader-text">Alternar painel: Tags</span>
                <span class="toggle-indicator" aria-hidden="true"></span>
              </button>
              <h2 class="hndle ui-sortable-handle">
                <span>Categorias de Plano:</span>
              </h2>
              <div class="inside">
                <div class="item--wrapper">
                  <?php if (isset($prepared)) : foreach ($prepared['modalidade'] as $modalidade): ?>
                    <label class="label--item">
                      <input value="<?php echo $modalidade['name']; ?>" class="large-text" type="text" name="plano_category[<?php echo $modalidade['id']; ?>]" placeholder="Digite o nome da categoria do plano">
                      <input type="hidden" name="plano_category_original" value="<?php echo $modalidade['name']; ?>">
                      <input type="hidden" id="plano_modalidade__<?php echo sanitize_title( $modalidade['name'] ); ?>" name="plano_modalidade__<?php echo sanitize_title( $modalidade['name'] ); ?>" value="<?php echo $modalidade['id']; ?>">
                      <!-- <input type="hidden" id="plano_category_hidden[]" name="plano_category_hidden[]" value="<?php echo $modalidade['categorias']; ?>"> -->
                      <input class="button-secondary" type="button" name="remove_item" value="apagar" />
                    </label>
                  <?php endforeach; else: ?>
                  <label class="label--item">
                    <input class="large-text" type="text" name="plano_category[]" placeholder="Digite o nome da categoria do plano">
                    <input class="button-secondary" type="button" name="remove_item" value="apagar" />
                  </label>
                <?php endif; ?>
              </div>
              <input class="button-primary button-block" type="button" name="add_item" data-section="category" value="Adicionar Novo" />
            </div>
          </div>
      </div>
    </div>
    <div id="postbox-container-1" class="postbox-container">
      <div class="meta-box-sortables">
        <div class="postbox">
          <div class="handlediv" title="Click to toggle"><br></div>
          <h2 class="hndle">
            <span>Informar Valores</span>
          </h2>
          <div class="inside">
            <p>Após informar os dados ao lado, clique aqui para inserir os valores de cada plano e cada categoria.</p>
            <?php submit_button('Adicionar Valores', $type = 'primary', $name = 'submit', $wrap = true); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <br class="clear">
</div>
<input type="hidden" name="action" value="price">
</form>
</div>