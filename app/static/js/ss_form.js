jQuery(document).ready(function($) {
  $('input[name="add_item"]').on('click', function(){
    const inputWrapper = $(this).prev();
    let newEl = '';

    if ($(this).data('section') == "age") {
      newEl = '<label class="label--item">\
      de <input class="small-text" type="number" name="age_range_min[]" placeholder="00" min="0" max="99" required>\
      até\
      <input class="small-text" type="number" name="age_range_max[]" placeholder="99" min="0" max="99" required>\
      <input class="button-secondary" type="button" name="remove_item" value="apagar" />\
      </label>'
    }

    if ($(this).data('section') == "category") {
      newEl = '<label class="label--item">\
      <input class="large-text" type="text" name="plano_category[]" placeholder="Digite o nome da modalidade do plano">\
      <input class="button-secondary" type="button" name="remove_item" value="apagar" />\
      </label>';
    }

    $(inputWrapper).append(newEl);
  });
  
  $('body').on('click', 'input[name="remove_item"]', function(){
    $(this).parent().remove();
  });

  $(".preview-form").on("click", function(e){
    e.preventDefault();
    loadPreview();
    return false;
  });

  $("#importbtn").on("click", function(){
    if (!confirm("Ao fazer a importação, todos os dados atuais serão substituídos pelos dados do arquivo. Tem certeza que deseja continuar?")) {
      return false;
    }
  });

  if (getParameterByName('slug')) {
    loadPreview();
  }

  const configEmail = document.querySelector("#config-email");

  if (configEmail) {
    let found = '';
    let re = /(.com[a-z])|(.com\s)|(\.[a-z]{3}\.[a-z]{2})$/ig;
  }

  function loadPreview(){
    const cssForm = $("#formFieldsStyles").val();
    const cssResult = $("#formResultStyles").val();
    const head = document.head || document.getElementsByTagName('head')[0];
    const style = document.createElement('style');

    const css = cssForm + cssResult;

    console.log('css', css);

    style.type = 'text/css';
    style.id = 'formGenerator';

    if (style.styleSheet) {
      style.styleSheet.cssText = css;
    } else {
      style.appendChild(document.createTextNode(css));
    }
    head.appendChild(style);
  }

});

function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}