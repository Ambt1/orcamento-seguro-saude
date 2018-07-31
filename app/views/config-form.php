<div class="wrap">
  <h1 class="wp-heading-inline">Estilos do Formulários</h1>
  <a href="<?php echo admin_url('admin.php?page=seguro-saude&action=config&step=3&sw=nf'); ?>" class="page-title-action">Adicionar novo template</a>  
  <hr>

  <form id="posts-filter" method="post">
    <table class="wp-list-table widefat fixed striped tags">
      <thead>
        <tr>
          <th scope="col" id="name" class="manage-column column-name column-primary sortable desc">
            <a href="#">
              <span>Nome</span>
            </a>
          </th>
          <th scope="col" id="slug" class="manage-column column-slug sortable desc">
            <a href="#">
              <span>Slug</span>
            </a>
          </th>
        </tr>
      </thead>

      <tbody id="the-list" data-wp-lists="list:tag">
        <?php if(!empty($formStyles)): foreach ($formStyles as $style) : ?>
          <tr id="tag-1">
            <td class="name column-name has-row-actions column-primary" data-colname="Nome">
              <strong>
                <a class="row-title" href="<?php echo admin_url('admin.php?page=seguro-saude&action=config&step=3&sw=nf&slug='.$style['slug']) ?>" aria-label="“Sem categoria” (Editar)">
                  <?php echo $style['name']; ?>
                </a>
              </strong>
              <br>
              <div class="row-actions">
                <span class="edit">
                  <a href="<?php echo admin_url('admin.php?page=seguro-saude&action=config&step=3&sw=nf&slug='.$style['slug']) ?>" aria-label="Editar Item">
                    Editar
                  </a>
                </span> | 
                <span class="trash">
                  <a href="#" data-section="form_style" data-id="<?php echo $style['slug']; ?>"  class="submitdelete" aria-label="Deletar Item">
                    Deletar
                  </a>
                </span>
              </div>
            </td>
            <td class="slug column-slug" data-colname="Slug">
              <?php echo $style['slug']; ?>
            </td>
          </tr>
        <?php endforeach; endif; ?>
      </tbody>

      <tfoot>
        <tr>
          <th scope="col" class="manage-column column-name column-primary sortable desc">
            <a href="#">
              <span>Nome</span>
            </a>
          </th>
          <th scope="col" class="manage-column column-slug sortable desc">
            <a href="#">
              <span>Slug</span>
            </a>
          </th>
        </tr>
      </tfoot>
    </table>
  </form>
  <h1 class="wp-heading-inline">Para Adicionar o Formulário</h1>
  <p>Para adicionar o formulário nas páginas basta inserir a tag abaixo</p>
  <pre>
    <b>[seguro-saude title="Cotação Online DESCONTOS ESPECIAIS!" button="Cálculo Online SH"]</b>
  </pre>
  ou dentro de um arquivo .php
  <pre>
    <b> do_shortcode('seguro-saude') </b>
  </pre>
</div>
