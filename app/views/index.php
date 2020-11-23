<?php 
global $wpdb;
if (isset($_GET['page'])) {
 switch ($_GET['page']) {
    case 'seguro-saude':
      if (isset($_GET['action']) && $_GET['action'] == 'planos') {
        /**********************************************
        *
        *    Check If Exitsts Categories already
        *
        **********************************************/
        $table = $wpdb->prefix . 'calc_ss_categories';
        $sql = "SELECT * FROM $table";
        $row = $wpdb->get_results($sql);
        $attrs = null;
        if (count($row) == 0) {
          $attrs = array("disabled" => true);
          $categoryWarn = array("status" => true, "msg" => 'Antes de adicionar um novo plano, é necessário <b><a href="'.admin_url("admin.php?page=seguro-saude&action=categories").'">cadastrar modalidades</a></b>');
        }
        /**********************************************
        *
        *    Check If Exitsts Status already
        *
        **********************************************/
        $table = $wpdb->prefix . 'calc_ss_status';
        $sql = "SELECT * FROM $table";
        $row = $wpdb->get_results($sql);
        $attrs = null;
        if (count($row) == 0) {
          $attrs = array("disabled" => true);
          $statusWarning = array("status" => true, "msg" => 'Antes de adicionar um novo plano, é necessário <b><a href="'.admin_url("admin.php?page=seguro-saude&action=config&step=4").'">cadastrar status</a></b>');
        }
        require('new-plano.php');
      } elseif (isset($_GET['action']) && $_GET['action'] == 'formularios') {
        require('formulario.php');
      } elseif (isset($_GET['action']) && $_GET['action'] == 'categories') {
        $table = $wpdb->prefix . 'calc_ss_categories';
        $row = $wpdb->get_results("SELECT * FROM $table");
        require('category.php');
      } elseif (isset($_GET['action']) && $_GET['action'] == 'config') {
        $currentPage = 'admin.php?'. $_SERVER['QUERY_STRING'];
        $tabactive_1 = '';
        $tabactive_2 = '';
        $tabactive_3 = '';
        $tabactive_4 = '';
        if ($_GET['step'] == 1) {
          $tabactive_1 = 'nav-tab-active';
          $leadsMessage = get_option('ss-amb1-msg-leads');
          $feformMsgSuccess = (get_option('ss-amb1-feform-success')) ? get_option('ss-amb1-feform-success') : '';
          $leadsEmail = join("\n", explode(',', get_option('ss-amb1-sys-emails')));
          $pagesListConfig = get_pages(array('post_status' => 'publish'));
          $postsListConfig = get_posts(array('post_status' => 'publish'));
          $redirectOption = (get_option( 'ss-amb1-redirect' )) ? unserialize(get_option( 'ss-amb1-redirect' )) : null;
          require('config.php');
          require('config-geral.php');
        }
        if ($_GET['step'] == 2) {
          $tabactive_2 = 'nav-tab-active';
          require('config.php');
          require('config-eximport.php'); 
        }
        if ($_GET['step'] == 3) {
          $tabactive_3 = 'nav-tab-active';
          require('config.php');
          if (isset($_GET['sw']) && $_GET['sw'] == "nf") {
            if (isset($_GET['slug'])) {
              $slug = $_GET['slug'];
              $formStyles = unserialize(get_option('ss-amb1-form-styles'));
              $styles = '';
              foreach ($formStyles as $item) {
                if ($item['slug'] == $slug) {
                  $styles = $item;
                }
              }
            }
            require('config-form-new.php');
          } else {
            $formStyles = unserialize(get_option('ss-amb1-form-styles'));
            require('config-form.php');
          }
        }
        if ($_GET['step'] == 4) {
          $table = $wpdb->prefix . 'calc_ss_status';
          $row = $wpdb->get_results("SELECT * FROM $table");
          $tabactive_4 = 'nav-tab-active';
          require('config.php');
          require('config-status.php');
        }
      } else {
        if (isset($_GET['id'])) {
          $id = intval($_GET['id']);
          $result = array();
          $table_name_planos = $wpdb->prefix . 'calc_ss_planos';
          $table_name_modalidades = $wpdb->prefix . 'calc_ss_modalidades';
          $table_name_age_by_price = $wpdb->prefix . 'calc_ss_age_by_price';
          $table_name_modalidades_has_categories = $wpdb->prefix . 'calc_ss_modalidades_has_categories';

          $sql = "SELECT
                  $table_name_planos.id as 'plano_id',
                  $table_name_modalidades.id as 'modalidade_id',
                  $table_name_age_by_price.id as 'age_id',
                  $table_name_modalidades_has_categories.categorias_id as 'categoria_id',
                  $table_name_planos.name as 'name',
                  $table_name_modalidades.name as 'modalidade',
                  $table_name_age_by_price.age_min,
                  $table_name_age_by_price.age_max,
                  $table_name_age_by_price.price_cop,
                  $table_name_age_by_price.price_nocop

                  FROM $table_name_planos

                  INNER JOIN $table_name_modalidades ON $table_name_planos.id = $table_name_modalidades.planos_id
                  INNER JOIN $table_name_age_by_price ON $table_name_age_by_price.modalidades_id = $table_name_modalidades.id
                  LEFT JOIN $table_name_modalidades_has_categories ON $table_name_modalidades_has_categories.modalidades_id = $table_name_modalidades.id

                  WHERE $table_name_planos.id = $id";
          
          $item = $wpdb->get_results($sql);


          // echo "<pre>";
          // var_dump($item);
          // echo "</pre>";


          /////////
          ///
          ///  RHAMSES 2020
          ///
          /////////

          $plan_id = $item[0]->plano_id;
          $modalidade_id = 0;
          $age_id = 0;
          $categoria_id = 0;

          $result = array();

          $result['plano_id'] = $plan_id;
          $result['name'] = $item[0]->name;
          $result['modalidade'] = [];
          $result['categoria'] = [];
          $result['idadepreco'] = [];

          foreach ($item as $key => $row) {
            while ($modalidade_id != $row->modalidade_id) {
              $modalidade_id = $row->modalidade_id;

              $modalidade = array(
                "id" => $row->modalidade_id,
                "name" => $row->modalidade
              );

              array_push($result['modalidade'], $modalidade);
            }

            while ($categoria_id != $row->categoria_id) {
              $categoria_id = $row->categoria_id;

              $categoria = array(
                "id" => $row->categoria_id,
                'modalidade_id' => $modalidade_id
              );

              array_push($result['categoria'], $categoria);
            }

            while ($age_id != $row->age_id) {
              $age_id = $row->age_id;

              $idadepreco = array(
                "id" => $row->age_id,
                "age_max" => $row->age_max,
                "age_min" => $row->age_min,
                "price_cop" => $row->price_cop,
                "price_nocop" => $row->price_nocop,
                'modalidade_id' => $modalidade_id
              );

              array_push($result['idadepreco'], $idadepreco);
            }
          }

          //////////////////////////// 
          // 
          // GET UNIQUE AGE VALUES
          // 
          ////////////////////////////

          $age_min_ctrl = 0;
          $age_max_ctrl = 0;

          $age_min_arr = array();
          $age_max_arr = array();

          foreach ($result['idadepreco'] as $agePreco) {
            if ($agePreco['age_min'] !== $age_min_ctrl) {
              $age_min_ctrl = $agePreco['age_min'];
              array_push($age_min_arr, $agePreco['age_min']);
            }

            if ($agePreco['age_max'] !== $age_max_ctrl) {
              $age_max_ctrl = $agePreco['age_max'];
              array_push($age_max_arr, $agePreco['age_max']);
            }
          }

          $age_min_arr = array_unique($age_min_arr);
          $age_max_arr = array_unique($age_max_arr);

          $result['ages_list']['age_min'] = $age_min_arr;
          $result['ages_list']['age_max'] = $age_max_arr;

          //////////////////////////// 
          // 
          // GET REDIRECT PAGE
          // 
          ////////////////////////////
          if (get_option( 'ss_plan_'.$plan_id.'_post_type' )) {
            $posts = array();
            $result['redirect_type'] = get_option( 'ss_plan_'.$plan_id.'_post_type' );

            $args = array(
              'post_type'   => $result['redirect_type'] ,
              'post_status' => 'publish',
              'posts_per_page'         => 999
            );
            
            $query = new WP_Query( $args );

            if ($query->have_posts()) {
              while ($query->have_posts()) : $query->the_post();
                array_push($posts, array(
                  "id" => get_the_ID(),
                  "title" => get_the_title()
                ));
              endwhile;
            }
            
            $result['redirect_posts'] = $posts;

          }

          if (get_option( 'ss_plan_'.$plan_id.'_redirect_to' )) {
            $result['redirect_to'] = get_post( intval( get_option( 'ss_plan_'.$plan_id.'_redirect_to' ) ) );
          }

          $prepared = $result;

          echo '<script> const __objSS = ' . json_encode($prepared) . '</script>';

          require('new-plano-edit.php');

        } else {
          $table = $wpdb->prefix . 'calc_ss_planos';
          $row = $wpdb->get_results("SELECT * FROM $table");
          require('dashboard.php');
        }
      }
    break;
    case 'seguro-saude-leads':
      $leads = $wpdb->prefix . 'calc_ss_leads';
      $status = $wpdb->prefix . 'calc_ss_status';
      $categories = $wpdb->prefix . 'calc_ss_categories';
      $limit = 10;

      if (isset($_GET['action']) && $_GET['action'] == 'view') {
        $statusSql = "SELECT id, name FROM $status";
        $statusResults = $wpdb->get_results($statusSql);
        $corretores = get_users(array(
          'role' => 'corretor'
        ));
        $id = $_GET['id'];
        $sql = "SELECT 
                $leads.id,
                $leads.name,
                $leads.email,
                $leads.telefone,
                $leads.created_at,
                $leads.ages_selected,
                $leads.status_id as 'status',
                $leads.responsible as 'corretor',
                $leads.obs,
                $categories.name as 'modalidade'
                FROM $leads
                INNER JOIN $categories ON $leads.categorias_id = $categories.id
                WHERE $leads.id = $id";
        $lead = $wpdb->get_row($sql);
        //
        // Checa se o corretor tem permissão pra ver esse lead
        // 
        if (
          user_can( get_current_user_id(), 'manage_options' ) ||
          !user_can( get_current_user_id(), 'manage_options' ) &&
          intval($lead->corretor) === get_current_user_id() 
        ) {
          require('leads-details.php');
        } else {
          echo "Lead não existe mais";
        }
        
      } elseif (isset($_GET['action']) && $_GET['action'] == 'delete'){
        $id = sanitize_key( $_GET['id'] );
        $result = deleteLead($id);
        loadLeadsList($result);
      } else {
        loadLeadsList();
      }
    break;
    default:
      echo 'peeee';
    break;
  } 
}

if ($_POST['action'] === 'trash') {
  if (array_key_exists('leads', $_POST)) {
    $data = array(
      'table' => 'calc_ss_leads',
      'items' => $_POST['leads']
    );
    bulkDelete($data);
  }
}

function bulkDelete($data) {
  global $wpdb;
  $result = array();
  try {
    if (!array_key_exists('table', $data)) {
      throw new Exception("Faltou campo table", 1);
    }

    if (!array_key_exists('items', $data)) {
      throw new Exception("Faltou campo items", 1);
    }

    $table = $wpdb->prefix . $data['table'];
    $types = array('%d');

    foreach ($data['items'] as $id => $item) {
      $fields = array(
        'id' => $id
      );

      $wpdb->delete($table, $fields, $types);
    }

    return $result = array("status" => true, "msg" => "Item deletado com sucesso");

  } catch (Exception $e) {
    var_dump($e);
  }

}

function deleteLead($id) {
  global $wpdb;
  $result = array();
  $table = $wpdb->prefix . 'calc_ss_leads';
  $fields = array(
    'id' => $id
  );
  $types = array('%d');
  if ($wpdb->delete($table, $fields, $types)) {
    return $result = array("status" => true, "msg" => "Item deletado com sucesso");
  } else {
    return $result = array("status" => false, "msg" => "Houve um erro ao adicionar os dados finais 3");
  }
}

function loadLeadsList($result = null)
{
  global $wpdb;

  $leads = $wpdb->prefix . 'calc_ss_leads';
  $status = $wpdb->prefix . 'calc_ss_status';
  $categories = $wpdb->prefix . 'calc_ss_categories';
  $limit = 10;

  $sqlLeads = $wpdb->get_results("SELECT COUNT(id) as `total` FROM $leads");
        $totalLeads = intval($sqlLeads[0]->total);
        $totalPages = ceil($totalLeads / $limit);
        $currentPage = isset($_GET['pagen']) ? $_GET['pagen'] : 1;
        
        // Random separation for users
        if (
            current_user_can('corretor') || 
            current_user_can('author') || 
            current_user_can('editor') || 
            current_user_can('contributor')) {
          $user_id = get_current_user_id();
          $where = 'WHERE responsible = ' . $user_id;
        } else {
          $where = '';
        }

        if ($currentPage - 1 <= 0) {
          $firstPage = false;
          $firstPageUrl = '#';

          $lastPage = true;
          $lastPageUrl = 'admin.php?page=seguro-saude-leads&pagen='.$totalPages;

          $nextPage = true;
          $nextPageUrl = 'admin.php?page=seguro-saude-leads&pagen='.($currentPage + 1);

          $previousPage = false;
          $previousPageUrl = '#';
        } elseif ($currentPage == $totalPages) {
          $firstPage = true;
          $firstPageUrl = 'admin.php?page=seguro-saude-leads';
          
          $lastPage = false;
          $lastPageUrl = '#';

          $nextPage = false;
          $nextPageUrl = '#';

          $previousPage = true;
          $previousPageUrl = 'admin.php?page=seguro-saude-leads&pagen='.($currentPage - 1);
        } else {
          $firstPage = true;
          $firstPageUrl = 'admin.php?page=seguro-saude-leads';

          $lastPage = true;
          $lastPageUrl = 'admin.php?page=seguro-saude-leads&pagen='.$totalPages;

          $nextPageUrl = 'admin.php?page=seguro-saude-leads&pagen='.($currentPage + 1);
          $nextPage = true;

          $previousPage = true;
          $previousPageUrl = 'admin.php?page=seguro-saude-leads&pagen='.($currentPage - 1);
        }

        $page = ($currentPage - 1) * $limit;

        $sql = "SELECT 
                $leads.id,
                $leads.name,
                $leads.email,
                $leads.telefone,
                $leads.created_at,
                $leads.responsible,
                $categories.name as 'modalidade',
                $status.name as 'status'
                FROM $leads
                INNER JOIN $categories ON $leads.categorias_id = $categories.id
                LEFT JOIN $status ON $leads.status_id = $status.id
                $where
                ORDER BY created_at DESC
                LIMIT $page, $limit";

        $row = $wpdb->get_results($sql);
        $leadsMessage = nl2br(get_option('ss-amb1-msg-leads'));
        require('leads-list.php');
}

function in_array_r($needle, $haystack, $strict = false) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }

    return false;
}
