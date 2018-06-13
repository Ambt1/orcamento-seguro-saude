<div class="wrap">
  <h1 class="wp-heading-inline">Dados do Interessado</h1>
  <a href="#" onclick="print()" class="page-title-action print-page">Imprimir</a>
  <form id="ss-amb1-config" action="<?php echo admin_url('admin-post.php'); ?>" method="POST">
    <input type="hidden" name="action" value="edit_leads">
    <input type="hidden" name="item_id" value="<?php echo $lead->id; ?>">
    <div id="col-container">
      <div id="col-left">
        <div class="col-wrap">
          <dl class="form--details__list">
            <dt>Nome:</dt>
            <dd><?php echo $lead->name; ?></dd>
            <dt>Email:</dt>
            <dd><?php echo $lead->email; ?></dd>
            <dt>Telefone:</dt>
            <dd><?php echo $lead->telefone; ?></dd>
            <dt>Modalidade Interessada:</dt>
            <dd><?php echo $lead->modalidade; ?></dd>
            <dt>Data do Cadastro:</dt>
            <dd><?php echo date('d-m-Y H:m:s', strtotime($lead->created_at)); ?></dd>
            <dt>Status:</dt>
            <dd>
              <select name="lead-status" id="lead-status" required> 
                <option value="" selected>Selecionar</option>
                <?php foreach ($statusResults as $status) : 
                  var_dump($lead->status);
                  if (!is_null($lead->status) && intval($lead->status) === intval($status->id) ) {
                    $selected = "selected";
                  } else {
                    $selected = "";
                  } 
                ?>
                  <option <?php echo $selected; ?> value="<?php echo $status->id ?>"><?php echo $status->name ?></option>
                <?php endforeach; ?>
              </select>
            </dd>
            <dt>Observações</dt>
            <dd>
              <textarea name="lead-obs" id="lead-obs" cols="80"><?php echo isset($lead->obs) ? $lead->obs : ''; ?></textarea>
            </dd>
          </dl>
        </div>
      </div>
      <div id="col-right">
        <div class="col-wrap">
          <dl class="form--details__list">
            <dt>Faixa Etárias Selecionadas:</dt>
          </dl>
          <table class="widefat" border="0" cellpadding="0" cellspacing="0">
            <thead>
              <tr>
                <th>Faixa Etária</th>
                <th>Idades</th>
              </tr>
            </thead>
            <tbody>
              <?php $ages = unserialize($lead->ages_selected); foreach ($ages as $age => $qtd) : ?>
              <tr>
                <td><?php echo $age; ?></td>
                <td><?php echo $qtd; ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="clear">
    <br>
    <?php submit_button('Editar Interessado', $type = 'primary', $name = 'submit', $wrap = true, $other_attributes = ''); ?>
  </div>
</form>
</div>