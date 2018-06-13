<div class="wrap">
  <form id="ss-amb1-config" method="POST" action="<?php echo admin_url('admin-post.php'); ?>" class="validate">
    <input type="hidden" name="action" value="config_step1">
    <input type="hidden" name="redirect" value="<?php echo $currentPage; ?>">
    <h2>Mensagens de aviso dentro do painel de interessados:</h2>
    <p>O conteúdo abaixo será mostrado apenas para usuários não administradores dentro da janela de <b>Lista de Interessados</b></p>
    <textarea name="config-msg-leads" id="config-msg-leads" cols="80" rows="10"><?php echo ($leadsMessage) ? $leadsMessage : ''; ?></textarea>
    <hr>
      <h2>Mensagens do Formulário de Leads:</h2>
      <label>Mensagem de sucesso do formuláro</label>
      <?php 
        $settings = array(
          "media_buttons" => false,

        );
        wp_editor( $feformMsgSuccess, 'config-feform-success', $settings ); 
      ?>
    <hr>
    <h2>Configurações gerais:</h2>
    <div class="form-field form-required">
      <label for="config-email">Endereço de email recipiente (um endereço por linha)</label>
      <textarea required aria=required="true" name="config-email" id="config-email" cols="80" rows="10"><?php echo ($leadsEmail) ? $leadsEmail : ''; ?></textarea>
    </div>
    <?php submit_button( $text = "Editar Dados", $type = 'primary', $name = 'submit', $wrap = true, $other_attributes = null ) ?>
  </form>
</div>