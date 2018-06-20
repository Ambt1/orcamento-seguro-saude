jQuery(document).ready(function($) {
  let __line_id = '';
  let __modalidades = '';

  $('form:not(#ss-amb1-config)').on("submit", function(e){
    e.preventDefault();
    const action = $('input[name="action"]').val();
    switch (action) {
      case "price":
        addPrices(this);
      break;
      case "new_plan":
        insertPlanToDb(this, action);
      break;
      case "edit_plan":
        insertPlanToDb(this, action);
      break;
      case "new_plan_category":
      if ($('input[name="item_id"]').val().length > 0) {
        editCategoryToDb(this, action);
      } else {
        insertCategoryToDb(this, action);
      }
      break;
      case "new_lead_status":
        if ($('input[name="item_id"]').val().length > 0) {
          editStatusToDb(this, action);
        } else {
          insertStatusToDb(this, action);
        }
      break;
      default:
        console.log('deu ruim');
      break;
    }
    return false;
  });

  $("body").on("click", ".submitdelete", function(){
    if (confirm("Apagando este item, todas as informações dele e relacionadas a ele. serão apagadas")) {
      const id = this.dataset.id;
      const section = this.dataset.section;
      const data = {
        action: 'delete_item',
        id: id,
        section: section
      }
      const line = $(this).parentsUntil("#the-list");
      $.ajax({
        url: ajaxurl ,
        type: 'POST',
        dataType: 'JSON', data: data,
      })
      .done(function(response) {
        if (response.status) {
          line.fadeOut();
        } else {
          alert(response.msg);
        }
      })
      .fail(function(a,e) {
        alert("Houve um problema com a aplicação. Consulte o desenvolvedor");
        console.log("error",a,e);
      });
    }
  });

  $("body").on("click", ".categoryedit", function(){
      const id = this.dataset.id;
      const section = this.dataset.section;
      const data = {
        action: 'edit_item',
        id: id,
        section: section
      }
      __line_id = $(this).parentsUntil("#the-list");
      $.ajax({
        url: ajaxurl ,
        type: 'POST',
        dataType: 'JSON', data: data,
      })
      .done(function(response) {
        if (response) {
          let text = '';

          if (section == "status") {
            text = "Editar Status";
          }

          if (section == "category") {
            text = "Editar Modalidade"; 
          }

          if ($('input[name="action"]').val().length > 0 ) {
            $('input[name="ss-input-name"]').val(response.name);
          }

          $('#submit').val(text);
          $('input[name="item_id"]').val(response.id);
        }
      })
      .fail(function(a,e) {
        alert("Houve um problema com a aplicação. Consulte o desenvolvedor");
        console.log("error",a,e);
      });
  });
  
  /**********************************************
  *
  *    Plan Methods
  *
  **********************************************/

  function makeslug(val, replaceBy) {
    replaceBy = replaceBy || '-';
    var mapaAcentosHex  = { // by @marioluan and @lelotnk
      a : /[\xE0-\xE6]/g,
      A : /[\xC0-\xC6]/g,
      e : /[\xE8-\xEB]/g, // if you're gonna echo this
      E : /[\xC8-\xCB]/g, // JS code through PHP, do
      i : /[\xEC-\xEF]/g, // not forget to escape these
      I : /[\xCC-\xCF]/g, // backslashes (\), by repeating
      o : /[\xF2-\xF6]/g, // them (\\)
      O : /[\xD2-\xD6]/g,
      u : /[\xF9-\xFC]/g,
      U : /[\xD9-\xDC]/g,
      c : /\xE7/g,
      C : /\xC7/g,
      n : /\xF1/g,
      N : /\xD1/g,
    };
    
    for ( var letra in mapaAcentosHex ) {
      var expressaoRegular = mapaAcentosHex[letra];
      val = val.replace( expressaoRegular, letra );
    }
    
    val = val.toLowerCase();
    val = val.replace(/[^a-z0-9\-]/g, " ");
    
    val = val.replace(/ {2,}/g, " ");
      
    val = val.trim();    
    val = val.replace(/\s/g, replaceBy);
    
    return val;
  }

  function addPrices(button){
    const DOMageMin = Array.from(document.querySelectorAll('input[name="age_range_min[]"]').values());
    const DOMageMax = Array.from(document.querySelectorAll('input[name="age_range_max[]"]').values());
    const DOMplans = Array.from(document.querySelectorAll('input[name="plano_category[]"]').values());

    const editAgeMin = document.querySelectorAll('input[name="plan_price_min[]"]').values();
    const editAgeMax = document.querySelectorAll('input[name="plan_price_max[]"]').values();
    const editPlanCategories = document.querySelectorAll('input[name="plano_category_hidden[]"]').values();

    let editItem = 0;
    let formAction = '';
    let submitText = '';

    for (const [key, item] of DOMplans.entries()) {
      let plan = {};
      let range = {};
      plan['name'] = item.value;
      plan['age_range'] = [];

      edtCat = editPlanCategories.next();

      if (edtCat.value) {
        // check if edits
        editItem = 1;
        plan['categories'] = edtCat.value.value.split(',');
      }

      for (let [keyAge, ageMins] of DOMageMin.entries()) {
        edtAgeMN = editAgeMin.next();
        edtAgeMX = editAgeMax.next();
        range = {
          min: ageMins.value,
          max: DOMageMax[keyAge].value,
        }
        if (edtAgeMN.value) {
          range['price_min'] = edtAgeMN.value.value,
          range['price_max'] = edtAgeMX.value.value
        }
        plan.age_range.push(range);
      }

      plan.slug = makeslug(plan.name,'-');

      if (item.nextElementSibling.id.substring(0, 18) == "plano_modalidade__") {
        item.nextElementSibling.id = "plano_modalidade__"+plan.slug;
        item.nextElementSibling.name = "plano_modalidade__"+plan.slug;
      }

      createHTML(plan, (html) => {
        $("#step1").fadeOut('slow', function(){
          $("#post-body-content").append(html);  
        });
      });
    }

    if (editItem == 0) {
      submitText = 'Inserir novo plano de saúde';
      formAction = 'new_plan';
    } else {
      submitText = 'Editar plano de saúde';
      formAction = 'edit_plan';
    }

    $(".postbox__ss").remove();
    $('input[type="submit"]').val(submitText);
    $('input[name="action"]').val(formAction);
    $(button).removeClass("step1");
  }

  function insertPlanToDb(form, action){
    const data = {
      action: action,
      plan: $(form).serialize()
    }
    $.ajax({
      url: ajaxurl,
      type: 'POST',
      dataType: 'JSON', 
      data: data,
    })
    .done(function(response) {
      if (response.status) {
        const url = $('input[name="redirect_url"]').val();
        window.location = url;
      }
    })
    .fail(function(a,e) {
      console.log("error",a,e);
    });
  }

  /**********************************************
  *
  *    Category Methods
  *
  **********************************************/

  function insertCategoryToDb(form, action){
    const data = {
      action: action,
      plan: $(form).serialize()
    }
    $.ajax({
      url: ajaxurl ,
      type: 'POST',
      dataType: 'JSON', data: data,
    })
    .done(function(response) {
      if (response.status) {
        $(form)[0].reset();
        const row = `<tr id="tag-${response.id}">
                <td class="name column-name has-row-actions column-primary" data-colname="Nome">
                  <strong>
                    <a class="row-title" href="#" aria-label="“${response.data.name}” (Editar)">${response.data.name}</a>
                  </strong>
                  <br>
                  <div class="row-actions">
                    <span class="edit">
                      <a href="#" data-section="category" data-id="${response.id}" class="categoryedit" aria-label="Editar Item">
                        Editar
                      </a>
                    </span> | 
                    <span class="trash">
                      <a href="#" data-section="category" data-id="${response.id}" class="submitdelete" aria-label="Deletar Item">
                        Deletar
                      </a>
                    </span>
                  </div>
                </td>
                <td class="slug column-slug" data-colname="Slug">${response.data.slug}</td>
                </tr>`;
        $("#the-list").append(row);
      } else {
        alert("Aconteceu algo errado. Tente novamente.");
      }
    })
    .fail(function(a,e) {
      console.log("error",a,e);
    });
  }

  function editCategoryToDb(form, action){
    const data = {
      action: action,
      plan: $(form).serialize(),
      id: $('input[name="item_id"]').val()
    }
    $.ajax({
      url: ajaxurl ,
      type: 'POST',
      dataType: 'JSON', data: data,
    })
    .done(function(response) {
      if (response.status) {
        $("form")[0].reset();
        $('input[name="item_id"]').val("");
        $('#submit').val("Adicionar Nova Modalidade");
        $(__line_id).find('a.row-title').text(response.data.name);
        $(__line_id).find('td.slug').text(response.data.slug);
      }
    })
    .fail(function(a,e) {
      alert("Houve um problema com a aplicação. Consulte o desenvolvedor");
      console.log("error",a,e);
    });
  }
  
  /**********************************************
  *
  *    Status Methods
  *
  **********************************************/

  function insertStatusToDb(form, action){
    const data = {
      action: action,
      plan: $(form).serialize()
    }
    $.ajax({
      url: ajaxurl ,
      type: 'POST',
      dataType: 'JSON', data: data,
    })
    .done(function(response) {
      if (response.status) {
        $(form)[0].reset();
        const row = `<tr id="tag-${response.id}">
                <td class="name column-name has-row-actions column-primary" data-colname="Nome">
                  <strong>
                    <a class="row-title" href="#" data-section="status" data-id="${response.id}" aria-label="“${response.data.name}” (Editar)">${response.data.name}</a>
                  </strong>
                  <br>
                  <div class="row-actions">
                    <span class="edit">
                      <a href="#" data-section="status" data-id="${response.id}" class="categoryedit" aria-label="Editar Item">
                        Editar
                      </a>
                    </span> | 
                    <span class="trash">
                      <a href="#" data-section="status" data-id="${response.id}" class="submitdelete" aria-label="Deletar Item">
                        Deletar
                      </a>
                    </span>
                  </div>
                </td>
                <td class="slug column-slug" data-colname="Slug">${response.data.slug}</td>
                </tr>`;
        $("#the-list").append(row);
      } else {
        alert("Aconteceu algo errado. Tente novamente.");
      }
    })
    .fail(function(a,e) {
      alert("Houve um problema com a aplicação. Consulte o desenvolvedor");
      console.log("error",a,e);
    });
  }

  function editStatusToDb(form, action){
    const data = {
      action: action,
      plan: $(form).serialize(),
      id: $('input[name="item_id"]').val()
    }
    $.ajax({
      url: ajaxurl ,
      type: 'POST',
      dataType: 'JSON', data: data,
    })
    .done(function(response) {
      if (response.status) {
        $("form")[0].reset();
        $('input[name="item_id"]').val("");
        $('#submit').val("Adicionar Novo Status");
        $(__line_id).find('a.row-title').text(response.data.name);
        $(__line_id).find('td.slug').text(response.data.slug);
      }
    })
    .fail(function(a,e) {
      alert("Houve um problema com a aplicação. Consulte o desenvolvedor");
      console.log("error",a,e);
    });
  }
  /**********************************************
  *
  *    Generic Methods
  *
  **********************************************/

  function createHTML(plan, callback){
    const data = {
      action: 'get_item',
      section: 'category'
    }

    $.ajax({
      url: ajaxurl,
      type: 'POST',
      dataType: 'JSON',
      data: data
    })
    .done(function(response) {
      if (response.status) {
      /**********************************************
      *
      *    Generate Modalidade Box
      *
      **********************************************/
      const modalidades = response.data;
      let htmlModalidades = '';
      let finalBlock = '';
      let checked = false;

      for (modalidade of modalidades) {
        if (typeof(plan.categories) != "undefined") {
          for (category of plan.categories) {
            if (category == modalidade.id) {
              checked = "checked";
              break;
            } else {
              checked = '';
            } 
          }
        }
        htmlModalidades += `<label class="checkbox"><input ${checked} type="checkbox" name="${plan.slug}__plan_category[]" value="${modalidade.id}">${modalidade.name}</label>`;
      }

      /**********************************************
      *
      *    Generate Price Box
      *
      **********************************************/
      let htmlPrices = '';
      for (price of plan.age_range) {
        htmlPrices += `<div class="wrapper--item"><h3 class="ss-category--title">Faixa Etária: <b>${price.min} a ${price.max}</b></h3>
                <div class="ss-category--wrapper ss-category--cop">
                  <h4>Valor com Co Participação</h4>
                  <input value="${(price.price_min) ? price.price_min : ''}" type="text" name="${plan.slug}__${price.min}__${price.max}__coparticipacao__price" class='large-text' placeholder="199,99" required>
                </div>
                <div class="ss-category--wrapper ss-category--nocop">
                  <h4>Valor sem Co Participação</h4>
                  <input value="${(price.price_max) ? price.price_max : ''}" type="text" name="${plan.slug}__${price.min}__${price.max}__participacao__price" class='large-text' placeholder="199,99" required>
                </div></div>`;
      };
      /**********************************************
      *
      *    Generate HTML Box
      *
      **********************************************/
      const html = `<div class="postbox" style="display: block;"><button type="button" class="handlediv" aria-expanded="true">
              <span class="screen-reader-text">Alternar painel: Tags</span>
              <span class="toggle-indicator" aria-hidden="true"></span>
            </button>
            <h2 class="hndle ui-sortable-handle">
              <span>Valor do Plano </span> ${plan.name}
            </h2>
            <div class="inside">${htmlPrices}<h4>Modalidades:</h4>${htmlModalidades}</div></div>`;
      callback(html);
      }
    })
    .fail(function(a,e) {
      console.log("error",a,e);
    });
  }
  
});