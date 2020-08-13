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
    <hr>
    <h2>Redirecionar formulário para página de sucesso</h2>
    <div class="form-field">
      <div class="field">
        <input id="showPostType" name="showPostType" type="checkbox" <?php ($redirectOption) ? checked( true, true ) : '' ?>>
        <label for="showPostType">
          Habilitar o redirecionamento da página após o processamento do formulário
        </label>
      </div>
      <div id="postListContainerWrapper" class="">
        <h3>Selecione o destino padrão do formulário</h3>
        <span>
          <input type="radio" id="postTypePagina" name="postType" value="pagesList" <?php ($redirectOption) ? checked( $redirectOption['postType'], 'pagesList' ) : '' ?>>
          <label for="postTypePagina">Página</label>
        </span>
        <span>
          <input type="radio" id="postTypePost" name="postType" value="postList" <?php ($redirectOption) ? checked( $redirectOption['postType'], 'postList' ) : '' ?>>
          <label for="postTypePost">Post</label>
        </span>
        <p></p>
        <div class="field">
          <select name="pagesList" class="postListContainer <?php echo ($redirectOption['postType'] == 'pagesList') ? '' : 'hide' ?>" >
            <option value="">Selecione a página</option>
            <?php foreach ($pagesListConfig as $page) : ?>
              <option <?php ($redirectOption['postType'] == 'pagesList') ? selected( $redirectOption['postTypeID'], $page->ID ) : '' ?> value="<?php echo $page->ID; ?>"><?php echo $page->post_title; ?></option>
            <?php endforeach; ?>
          </select>
          <select name="postList" class="postListContainer <?php echo ($redirectOption['postType'] == 'postList') ? '' : 'hide' ?>">
            <option value="">Selecione o post</option>
            <?php foreach ($postsListConfig as $post) : ?>
              <option <?php ($redirectOption['postType'] == 'postList') ? selected( $redirectOption['postTypeID'], $post->ID ) : '' ?> value="<?php echo $post->ID; ?>"><?php echo $post->post_title; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
    </div>
    <?php submit_button( $text = "Editar Dados", $type = 'primary', $name = 'submit', $wrap = true, $other_attributes = null ) ?>
  </form>
</div>