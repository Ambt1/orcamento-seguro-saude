<div class="wrap">
  <h1 class="wp-heading-inline">Lista de planos</h1>
  <a href="<?php echo admin_url('admin.php?page=seguro-saude&action=planos'); ?>" class="page-title-action">Adicionar novo</a>
  <p>Abaixo está listado todos os planos cadastrados. Para editar as informações basta clicar no nome de cada um deles. </p>
  <table class="wp-list-table widefat fixed striped posts">
    <thead>
      <tr>
        <td id="cb" class="manage-column column-cb check-column">
          <label class="screen-reader-text" for="cb-select-all-1">Selecionar todos</label>
          <input id="cb-select-all-1" type="checkbox">
        </td>
        <th scope="col" id="title" class="manage-column column-title column-primary sortable desc">
         <span>Plano</span>
       </th>
       <th scope="col" id="author" class="manage-column">Shortcode</th>
       <th scope="col" id="categories" class="manage-column column-categories">&nbsp;</th>
       <th scope="col" id="date" class="manage-column column-date sortable asc">&nbsp;</th>  
     </tr>
   </thead>

   <tbody id="the-list">
    <?php foreach ($row as $item) : ?>
    <tr id="post-1" class="iedit author-self level-0 post-1 type-post status-publish format-standard hentry category-sem-categoria">
      <th scope="row" class="check-column">
        <input id="cb-select-1" type="checkbox" name="post[]" value="1">
      </th>
      <td class="title column-title has-row-actions column-primary page-title" data-colname="Título">
        <strong>
          <a class="row-title" href="#" aria-label="<?php echo $item->name; ?> (Editar)"><?php echo $item->name; ?></a>
        </strong>
        <div class="row-actions">
          <span class="edit">
            <a href="<?php echo admin_url('admin.php?page=seguro-saude&id='.$item->id) ?>" aria-label="Editar este item">Editar</a> | 
          </span>
          <span class="trash">
            <a href="#" data-section="plan" data-id="<?php echo $item->id; ?>" class="submitdelete" aria-label="Mover este item para a lixeira">Deletar</a>
          </span>
        </div>
      </td>
      <td data-colname="Autor">
        [plano-valores plano="<?php echo sanitize_title($item->name, ''); ?>" color="#000" width="100%|px|em" fontSize="16px"]
      </td>
      <td class="categories column-categories" data-colname="Categorias"></td>
      <td class="tags column-tags" data-colname="Tags"></td>    
    </tr>
    <?php endforeach; ?>
  </tbody>

  <tfoot>
    <tr>
      <td class="manage-column column-cb check-column">
        <label class="screen-reader-text" for="cb-select-all-2">Selecionar todos</label>
        <input id="cb-select-all-2" type="checkbox">
      </td>
      <th scope="col" class="manage-column column-title column-primary sortable desc">
        Plano
      </th>
      <th scope="col" class="manage-column">
        Shortcode
      </th>
      <th scope="col" class="manage-column column-categories">&nbsp;</th>
      <th scope="col" class="manage-column column-date sortable asc">&nbsp;</th> 
    </tr>
  </tfoot>
</table>
</div>