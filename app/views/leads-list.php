<?php if($result): ?>
  <div class="notice notice-success">
    <p><?php echo $result['msg']; ?></p>
  </div>
<?php endif; ?>
<?php if($leadsMessage): ?>
  <div class="notice notice-success">
    <p><?php echo $leadsMessage; ?></p>
  </div>
<?php endif; ?>
<div class="wrap">
  <h1 class="wp-heading-inline">Lista de Interessados</h1>
  <?php if (current_user_can('administrator')): ?>
    <a target="_blank" href="<?php echo admin_url('admin-post.php?action=export_leads'); ?>" class="page-title-action export-button">Exportar lista</a>  
  <?php endif ?>
  <p>Abaixo está listado todos os interessados cadastrados. Para visualizar as informações basta clicar no nome de cada um deles. </p>
  <form action="<?php echo admin_url('admin.php?page=seguro-saude-leads'); ?>" method="POST" class="noajax">
  <table class="wp-list-table widefat fixed striped posts fix-responsive">
    <thead>
      <tr>
        <td id="cb" class="manage-column column-cb check-column">
          <label class="screen-reader-text" for="cb-select-all-1">Selecionar todos</label>
          <input id="cb-select-all-1" type="checkbox">
        </td>
        <th>
          id
        </th>
        <th scope="col" id="title" class="manage-column column-title column-primary sortable desc">
         <span>Nome</span>
       </th>
       <th scope="col" id="author" class="manage-column">Email</th>
       <th scope="col" id="categories" class="manage-column column-categories">Modalidade</th>
       <th scope="col" id="author" class="manage-column">Status</th>
       <?php if (current_user_can('administrator')): ?>
         <th scope="col" id="author" class="manage-column">Responsável</th>
       <?php endif; ?>
       <th scope="col" id="date" class="manage-column column-date sortable asc">Data</th>  
     </tr>
   </thead>
   <tbody id="the-list">
    <?php foreach ($row as $item) : ?>
      <tr id="post-1" class="<?php echo (array_key_exists($item->id, $_POST['leads'])) ? 'hide' : ''; ?>">
        <th scope="row" class="check-column">     
          <input id="cb-select-1" type="checkbox" name="leads[<?php echo $item->id; ?>]" value="1">
        </th>
        <td>
          <?php echo $item->id; ?>
        </td>
        <td class="" data-colname="Título">
          <strong>
            <a class="row-title" href="<?php echo admin_url('admin.php?page=seguro-saude-leads&action=view&id='.$item->id) ?>" aria-label="<?php echo $item->name; ?> (Editar)"><?php echo $item->name; ?></a>
          </strong>
          <div class="row-actions">
            <span class="edit">
              <a href="<?php echo admin_url('admin.php?page=seguro-saude-leads&action=view&id='.$item->id) ?>" aria-label="Editar este item">Visualizar</a>
            </span>
          </div>
        </td>
        <td class="" data-colname="Email"><?php echo $item->email; ?></td>
        <td class="" data-colname="Modalidade"><?php echo $item->modalidade; ?></td>   
        <td class="" data-colname="Email"><?php echo $item->status; ?></td>
        <?php if (current_user_can('administrator')): ?>
          <td class=""><?php echo get_user_by( 'id', $item->responsible )->user_nicename; ?></td>
        <?php endif; ?> 
        <td class="" data-colname="Data"><?php echo date('d/m/Y', strtotime($item->created_at)); ?></td>    
      </tr>
    <?php endforeach; ?>
  </tbody>
  <tfoot>
    <tr>
      <td id="cb" class="manage-column column-cb check-column">
        <label class="screen-reader-text" for="cb-select-all-1">Selecionar todos</label>
        <input id="cb-select-all-1" type="checkbox">
      </td>
      <th scope="col" id="title" class="manage-column column-title column-primary sortable desc">
       <span>Nome</span>
     </th>
     <th scope="col">Email</th>
     <th scope="col">Modalidade</th>
     <th scope="col">Status</th>
     <?php if (current_user_can('administrator')): ?>
       <th scope="col">Responsável</th>
     <?php endif; ?>
     <th scope="col">Data</th>  
   </tr>
 </tfoot>
</table>
<div class="tablenav bottom">
  <?php if (current_user_can( 'manage_options' ) ): ?>
    <div class="alignleft actions bulkactions">
      <label for="bulk-action-selector-bottom" class="screen-reader-text">Selecionar ação em massa</label><select name="action" id="bulk-action-selector-bottom">
        <option value="-1">Ações em massa</option>
        <option value="trash">Apagar todos os dados</option>
      </select>
      <button type="submit" class="button action">Aplicar</button>
    </div>
  <?php endif; ?>
  <?php if ($totalLeads > 10): ?>
    <div class="tablenav-pages">
      <span class="displaying-num"><?php echo $totalLeads; ?> itens</span>
      <span class="pagination-links">
        <a class="first-page button" <?php echo ($firstPage) ? '' : 'disabled' ?> href="<?php echo admin_url("$firstPageUrl"); ?>">
          <span class="screen-reader-text">Primeira página</span>
          <span aria-hidden="true">«</span>
        </a>
        <a class="last-page button" href="<?php echo admin_url("$previousPageUrl"); ?>" <?php echo ($previousPage) ? '' : 'disabled' ?>>
          <span class="screen-reader-text">Página Anterior</span>
          <span aria-hidden="true">‹</span>
        </a>
        <span class="screen-reader-text">Página atual</span>
        <span id="table-paging" class="paging-input">
          <span class="tablenav-paging-text"><?php echo $currentPage; ?> de 
            <span class="total-pages"><?php echo $totalPages; ?></span>
          </span>
        </span>
        <a class="next-page button" <?php echo ($nextPage) ? '' : 'disabled' ?> href="<?php echo admin_url("$nextPageUrl"); ?>">
          <span class="screen-reader-text">Próxima página</span>
          <span aria-hidden="true">›</span>
        </a>
        <a class="last-page button" <?php echo ($lastPage) ? '' : 'disabled' ?> href="<?php echo admin_url("$lastPageUrl"); ?>">
          <span class="screen-reader-text">Última página</span>
          <span aria-hidden="true">»</span>
        </a>
      </span>
    </div>
  <?php endif ?>
</div>
</form>
</div>