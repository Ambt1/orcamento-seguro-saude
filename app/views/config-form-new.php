<div class="wrap">
  <h1 class="wp-heading-inline">Novo Tema Formulário</h1>
  <p>Desça até o fim da página para editar o código.</p>
  <div id="col-container" class="wp-clearfix">
    <div id="col-left" style="width: 45%;">
      <div class="col-wrap">
        <h2>Exemplo de Visualização:</h2>
        <?php echo do_shortcode('[seguro-saude title="Cotação Online DESCONTOS ESPECIAIS!" button="Cálculo Online SH"]'); ?>
      </div>
    </div>
    <div id="col-right" style="width: 55%;">
      <div class="col-wrap">
        <h2>Exemplo de Visualização:</h2>
        <div class="ss-amb1--wrapper">
          <div class="ss-amb1--form-results__wrapper">
            <h2 class="ss-amb1--results__title">Encontramos este(s) plano(s) para você.</h2>
            <p class="ss-amb1--results__msg">Podemos ou não ter mais opções. Fale com a gente pelo email contato@example.com ou pelo telefone (15)9999-9999</p>
            <div id="amil" class="ss-results--plan form__response">
              <div class="title">Amil</div>
              <p class="hint">Amil 200 Regional QP</p>
              <div class="features">
                <table class="ss-results--plan-prices" border="0" cellpadding="0" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Faixa Etária</th>
                      <th>Coparticipação</th>
                      <th>Sem Coparticipação</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>0 - 18</td>
                      <td>R$ 0,00</td>
                      <td>R$ 200,00</td>
                    </tr>
                    <tr>
                      <td>19 - 22</td>
                      <td>R$ 0,00</td>
                      <td>R$ 400,00</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="pt-footer">&nbsp;</div>
            </div>
            <div id="unimed" class="ss-results--plan form__response">
              <div class="title">Unimed</div>
              <p class="hint">Plano 2</p>
              <div class="features">
                <table class="ss-results--plan-prices" border="0" cellpadding="0" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Faixa Etária</th>
                      <th>Coparticipação</th>
                      <th>Sem Coparticipação</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>30 - 50</td>
                      <td>R$ 500,00</td>
                      <td>R$ 600,00</td>
                    </tr>
                    <tr>
                      <td>60 - 90</td>
                      <td>R$ 0,00</td>
                      <td>R$ 800,00</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="pt-footer">&nbsp;</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <hr>
  <form name="ss-amb1-config" id="ss-amb1-config" action="<?php echo admin_url('admin-post.php'); ?>" method="POST">
    <input type="hidden" name="old_slug" value="<?php echo isset($styles['slug']) ? $styles['slug'] : ''; ?>">
    <input type="hidden" name="action" value="save_form_styles">
    <input type="hidden" name="redirect" value="admin.php?page=seguro-saude&action=config&step=3">
    <h1 class="wp-heading-inline">Estilos do Formulários</h1>
    <div id="titlediv">
      <div id="titlewrap">
        <input type="text" name="style_title" size="30" placeholder="Digite o título aqui" id="title" autocomplete="off" <?php echo isset($styles['name']) ? 'value="'.$styles['name'].'"' : '' ?> required>
      </div>
      <div class="inside">
        <div id="edit-slug-box" class="hide-if-no-js">
        </div>
      </div>
    </div>
    <div id="col-container" class="wp-clearfix">
      <div id="col-left" style="width: 45%;">
        <div class="col-wrap">
          <div class="form-wrap">
            <h2>Estilo Css</h2>
            <textarea name="formFieldsStyles" id="formFieldsStyles" class="form--adm--config">
<?php echo isset($styles['formStyle']) ? $styles['formStyle'] :'
.ss-amb1--form__wrapper,
.ss-amb1--form-results__wrapper {
  background-color: #fff;
}

.ss-amb1-legend,
.ss-amb1--results__title {
  background-color: #686868;
  color: #fff;
  text-align: center;
}

.ss-amb1--form__wrapper .button-primary {
  background-color: #686868;
  border:  none;
  color: #fff;
  text-transform: uppercase;

  border-radius: 0;
  box-shadow: none;
  text-shadow: none;
  line-height: 1;
  height: auto;
}

.ss-amb1--form__wrapper .button-primary:hover {
  background-color: #686868;
}' ?>
            </textarea>
          </div>
        </div>
      </div>
      <div id="col-right" style="width: 55%;">
        <div class="col-wrap">
          <div class="form-wrap">
            <h2>Estilo Css</h2>
            <textarea name="formResultStyles" id="formResultStyles" class="form--adm--config">
<?php echo isset($styles['resultStyle']) ? $styles['resultStyle'] :'
.form__response .title{
  background: #78CFBF;    
}

.form__response .content,
.form__response .hint,
.form__response .pt-footer{
  background: #82DACA;
  color: #fff;
}

.form__response .hint:after{ 
  border-top-color: #82DACA;  
}

.form__response .pt-footer:after{
  border-top-color: #FFFFFF;
}' ?>
            </textarea>
          </div>
        </div>
      </div>
    </div>
    <p>
      <button class="preview-form" type="button" class="button-secondary">Visualizar Mudanças</button>
    </p>
    <?php submit_button('Salvar Estilos', 'primary', 'submit', true, $attrs = array("id" => "rs") ); ?>
  </form>
</div>