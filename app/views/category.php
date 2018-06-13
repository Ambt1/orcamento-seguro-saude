<div class="wrap">
  <h1 class="wp-heading-inline">Modalidades</h1>
  <div id="col-container" class="wp-clearfix">
    <div id="col-left">
      <div class="col-wrap">
        <div class="form-wrap">
          <h2>Adicionar nova categoria</h2>
          <form id="new_plan_category" method="post" class="validate">
            <input type="hidden" name="action" value="new_plan_category">
            <input type="hidden" name="item_id">
            <div class="form-field form-required term-name-wrap">
              <label for="plan-category-name">Nome</label>
              <input name="ss-input-name" id="ss-input-name" type="text" value="" aria-required="true">
            </div>
            <?php submit_button('Adicionar nova modalidade', $type = 'primary', $name = 'submit', $wrap = true, $other_attributes = NULL); ?>
          </form>
        </div>
      </div>
    </div>

    <div id="col-right">
      <div class="col-wrap">
        <form id="posts-filter" method="post">
          <h2 class="screen-reader-text">Lista de categorias</h2>
          <table class="wp-list-table widefat fixed striped tags">
            <thead>
              <tr>
                <th scope="col" id="name" class="manage-column column-name column-primary sortable desc">
                  <a href="#">
                    <span>Nome</span>
                    <span class="sorting-indicator">
                    </span>
                  </a>
                </th>
                <th scope="col" id="slug" class="manage-column column-slug sortable desc">
                  <a href="#">
                    <span>Slug</span>
                    <span class="sorting-indicator">
                    </span>
                  </a>
                </th>
              </tr>
            </thead>

            <tbody id="the-list" data-wp-lists="list:tag">
              <?php foreach ($row as $item) : ?>
              <tr id="tag-1">
                <td class="name column-name has-row-actions column-primary" data-colname="Nome">
                  <strong>
                    <a class="row-title" href="#" aria-label="“Sem categoria” (Editar)">
                      <?php echo $item->name ?>
                    </a>
                  </strong>
                  <br>
                  <div class="row-actions">
                    <span class="edit">
                      <a href="#" data-section="category" data-id="<?php echo $item->id; ?>" class="categoryedit" aria-label="Editar Item">
                        Editar
                      </a>
                    </span> | 
                    <span class="trash">
                      <a href="#" data-section="category" data-id="<?php echo $item->id; ?>" class="submitdelete" aria-label="Deletar Item">
                        Deletar
                      </a>
                    </span>
                  </div>
                </td>
                <td class="slug column-slug" data-colname="Slug">
                  <?php echo $item->slug; ?>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>

            <tfoot>
              <tr>
                <th scope="col" class="manage-column column-name column-primary sortable desc">
                  <a href="http://localhost:8080/wp-admin/edit-tags.php?taxonomy=category&amp;orderby=name&amp;order=asc">
                    <span>Nome</span>
                    <span class="sorting-indicator">
                    </span>
                  </a>
                </th>
                <th scope="col" class="manage-column column-slug sortable desc">
                  <a href="http://localhost:8080/wp-admin/edit-tags.php?taxonomy=category&amp;orderby=slug&amp;order=asc">
                    <span>Slug</span>
                    <span class="sorting-indicator">
                    </span>
                  </a>
                </th>
              </tr>
            </tfoot>
          </table>
        </form>
      </div>
    </div>
  </div>
</div>