jQuery(document).ready(function($) {
  $('form[name="ss-amb1-form"] .ss-amb1-field__label').on('click', function(){
    if (!$(this).parent('.ss-amb1-field__wrapper').hasClass('is-active')) {
      $(this).parent('.ss-amb1-field__wrapper').addClass('is-active');
      $(this).next().focus();
    }
  });

  $('form[name="ss-amb1-form"] input')
  .on("focus", function(){
    if (!$(this).parent('.ss-amb1-field__wrapper').hasClass('is-active')) {
      $(this).parent('.ss-amb1-field__wrapper').addClass('is-active');
    }
  })
  .on("blur", function(){
    if ($(this).val().length == 0) {
      $(this).parent('.ss-amb1-field__wrapper').removeClass('is-active');
    }
  });

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
        if ($('form[name="ss-amb1-form"] input[name="ss_amb1_redirect_page"]').length > 0) {
          let page = new URL($('form[name="ss-amb1-form"] input[name="ss_amb1_redirect_page"]').val());
          let pageQueryString = page.searchParams;
          const urlObj = {
            table: response.data,
            msg: response.msg
          };
          pageQueryString.set('ss_amb1', btoa(JSON.stringify(urlObj)));
          page.search = pageQueryString.toString();
          page = page.toString();
          window.location = response.redirect;
        } else {
          const html = buildResultPage(response.data, response.msg);
          $(".ss-amb1--form__wrapper").fadeOut('slow', function(){
            $(this).remove();
            $(".ss-amb1--wrapper").append(html);
          });
        }
      } else {
        alert(response.msg);
      }
    })
    .fail(function(a,e) {
      console.log("error",a,e);
    });
    return false;
  });

  if ($('.ss-amb1-results-page').length > 0) {
    const resultsTable = JSON.parse(atob(new URL(window.location.href).searchParams.get('ss_amb1')));
    const html = buildResultPage(resultsTable.table, resultsTable.msg);
    $('.ss-amb1-results-page').append(html);
  }

  function buildResultPage(data, msg) {
    let htmlPriceTable = '';
    for (const plan of data) {
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

    return `<div class="ss-amb1--form-results__wrapper"><h2 class="ss-amb1--results__title">Encontramos este(s) plano(s) para você.</h2><p class="ss-amb1--results__msg">${msg}</p>${htmlPriceTable}</div>`;
  }
});
