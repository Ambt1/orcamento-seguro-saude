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
    const DOMplans = Array.from(document.querySelectorAll('input[name="plano_category[]"]')).length;
    const agePairs = Array.from(document.querySelectorAll('input[name*="plan_price_"]'));
    const fullAges = parseInt($(this).parent().data("line") * 2);

    // Check if has id

    if (this.previousElementSibling.name.includes('plano_modalidade')) {
      const categoryID = this.previousElementSibling.value;
      const input = document.createElement("input");
      input.type = "hidden";
      input.value = categoryID;
      input.name = "plano_categoria_to_delete[]";
      
      document.querySelector("form").append(input);
    }

    if (fullAges) {
      let numPlan = 1;
      while (numPlan <= DOMplans) {
        $(agePairs).eq((fullAges * numPlan) - 1).remove();
        $(agePairs).eq((fullAges * numPlan) - 2).remove();
        numPlan++;
      }
      $('#total_ages_edit').val(($('#total_ages_edit').val() - 1));
    }

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

  if ($("#showPostType").length > 0) {
    if ($("#showPostType:checked").length === 1) {
      $('#postListContainerWrapper').remove('hide');
    } else {
      $('#postListContainerWrapper').toggleClass('hide');
    }
  }

  $("#showPostType").on("click", function(){
    $('#postListContainerWrapper').toggleClass('hide');
  });

  $('input[name="postType"]').on('click', function(){
    const selectID = $(this).val();
    $('.postListContainer').addClass('hide');
    $(`select[name=${selectID}]`).removeClass('hide');
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