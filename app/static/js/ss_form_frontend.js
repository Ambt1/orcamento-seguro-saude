jQuery(document).ready(function($) {
  $('form[name="ss-amb1-form"]').on("submit", function(e){
    e.preventDefault();
    const form = $(this);
    const data = {
      action: 'process_form',
      form: $(this).serialize()
    }
    $.ajax({
      url: amb1_ajax.ajax_url ,
      type: 'POST',
      dataType: 'JSON', 
      data: data,
      beforeSend: function(){
        form.append('<div class="loader" id="loader-1"></div>');
      }
    })
    .done(function(response) {
      $(".loader").remove();
      if (response.status) {
        let htmlPriceTable = '';
        for (const plan of response.data) {
          let htmlBody = '';
          for (const modalidade of plan.modalidade) {
            let totalCop = 0;
            let totalNoCop = 0; 
            htmlBody += `<p class="hint">${modalidade.value}</p>
            <div class="features">
            <table class="ss-results--plan-prices" border="0" cellpadding="0" cellspacing="0">
            <thead>
            <tr>
            <th>Faixa Etária</th>
            <th>Coparticipação</th>
            <th>Sem Coparticipação</th>
            </tr>
            </thead><tbody>`;
            for (let [key, age] of modalidade.ages.entries()) {
              if (modalidade.prices[key].price_cop > 0 && modalidade.prices[key].price_nocop > 0) {
                totalCop = modalidade.prices[key].price_cop + totalCop;
                totalNoCop = modalidade.prices[key].price_nocop + totalNoCop;
                htmlBody += `<tr>
                <td>${age.min} - ${age.max}</td>
                <td>R$ ${parseFloat(modalidade.prices[key].price_cop).toFixed(2).replace('.',',')}</td>
                <td>R$ ${parseFloat(modalidade.prices[key].price_nocop).toFixed(2).replace('.',',')}</td>
                </tr>`;
              }
            }
            htmlBody += `</tbody>`;
            htmlBody += `<tfoot class="pt-footer"><tr><td width="100px">Total:</td><td>R$ ${totalCop.toFixed(2).replace('.',',')}</td><td>R$ ${totalNoCop.toFixed(2).replace('.',',')}</td></tr></tfoot>`;
            htmlBody += `</table></div>`;
          }
          htmlPriceTable += `<div id="${plan.slug}" class="ss-results--plan form__response"><div class="title">${plan.name}</div>${htmlBody}</div>`;
        }
        const html = `<div class="ss-amb1--form-results__wrapper"><h2 class="ss-amb1--results__title">Encontramos este(s) plano(s) para você.</h2><p class="ss-amb1--results__msg">${response.msg}</p>${htmlPriceTable}</div>`;
        $(".ss-amb1--form__wrapper").fadeOut('slow', function(){
          $(this).remove();
          $(".ss-amb1--wrapper").append(html);
        });
      } else {
        alert(response.msg);
      }
    })
    .fail(function(a,e) {
      console.log("error",a,e);
    });
    return false;
  });
});
