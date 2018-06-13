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
          require('config.php');
          require('config-geral.php');
        }
        if ($_GET['step'] == 2) {
          $tabactive_2 = 'nav-tab-active';
          require('config.php');
          require('config-messages.php'); 
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
                  $table_name_planos.id as 'id',
                  $table_name_planos.name as 'name',
                  $table_name_modalidades.id as 'modalidade_id',
                  $table_name_modalidades.name as 'modalidade',
                  $table_name_age_by_price.id as 'age_id',
                  $table_name_age_by_price.age_min,
                  $table_name_age_by_price.age_max,
                  $table_name_age_by_price.price_cop,
                  $table_name_age_by_price.price_nocop,
                  $table_name_modalidades_has_categories.categorias_id as 'categoria_id'

                  FROM $table_name_planos

                  INNER JOIN $table_name_modalidades ON $table_name_planos.id = $table_name_modalidades.planos_id
                  INNER JOIN $table_name_age_by_price ON $table_name_age_by_price.modalidades_id = $table_name_modalidades.id
                  LEFT JOIN $table_name_modalidades_has_categories ON $table_name_modalidades_has_categories.modalidades_id = $table_name_modalidades.id

                  WHERE $table_name_planos.id = $id";
          
          $item = $wpdb->get_results($sql);
          $tAge = array();
          $prepared = array(
            "id" => $id,
            "name" => $item[0]->name,
            "modalidade" => array(),
            "ages" => array(),
            "ages_demo" => array(),
            "prices" => array(),
            "categories" => array()
          );
            
          /**********************************************
          *
          *    COUNT AGES
          *
          **********************************************/

          $sql = "SELECT DISTINCT
                  $table_name_age_by_price.age_min,
                  $table_name_age_by_price.age_max

                  FROM $table_name_planos

                  INNER JOIN $table_name_modalidades ON $table_name_planos.id = $table_name_modalidades.planos_id
                  INNER JOIN $table_name_age_by_price ON $table_name_age_by_price.modalidades_id = $table_name_modalidades.id
                  LEFT JOIN $table_name_modalidades_has_categories ON $table_name_modalidades_has_categories.modalidades_id = $table_name_modalidades.id

                  WHERE $table_name_planos.id = $id";
          
          $totalAgeResults = count($wpdb->get_results($sql));

          foreach ($item as $key => $value) {
            
            /**********************************************
            *
            *    MODALIDADE BLOCK
            *
            **********************************************/
            $modalidade = array(
              "id" => $value->modalidade_id,
              "value" => $value->modalidade
            );

            if (!in_array($modalidade, $prepared['modalidade'])) {
              array_push($prepared['modalidade'], $modalidade);  
            }

            /**********************************************
            *
            *    AGE BLOCK
            *
            **********************************************/
            
            $ages = array(
              "min" => $item[$key]->age_min,
              "max" => $item[$key]->age_max,
              "id" => array($item[$key]->age_id)
            );

            if (!in_array_r($ages['id'], $prepared['ages_demo'])) {
              array_push($prepared['ages_demo'], $ages);  
            }

            // if (!in_array($ages, $prepared['ages'])) {
            //   array_push($prepared['ages'], $ages);  
            // }

            /**********************************************
            *
            *    PRICE BLOCK
            *
            **********************************************/

            $prices = array(
              "price_cop" => $item[$key]->price_cop,
              "price_nocop" => $item[$key]->price_nocop
            );

            if (!in_array($prices, $prepared['prices'])) {
              array_push($prepared['prices'], $prices);  
            }

            /**********************************************
            *
            *    CATEGOIRES BLOCK
            *
            **********************************************/

            if (!in_array($value->categoria_id, $prepared['categories'])) {
              array_push($prepared['categories'], $value->categoria_id);  
            }
          }

          foreach ($prepared['modalidade'] as $key => $modalidade) {
            $categorias = array();
            foreach ($item as $value) {
              if ($modalidade['value'] == $value->modalidade) {
                if (!in_array($value->categoria_id, $categorias)) {
                  array_push($categorias, $value->categoria_id);
                }
              }
            };
            $prepared['modalidade'][$key]['categorias'] = join($categorias,',');
          }

          /**********************************************
          *
          *    FILTER AGE
          *
          **********************************************/
          // echo '<pre>';
          // var_dump(count($prepared['modalidade']));
          // echo '</pre>';
          // exit();
          foreach ($prepared['ages_demo'] as $key => $age) {
            if (!empty($prepared['ages'])) {
              $nextStep = false;
              $tempIdArr = array();

              foreach ($prepared['ages'] as $tAgeKey => $item) {
                if ($age['min'] == $item['min'] && $age['max'] == $item['max']) {
                  $prepared['ages'][$tAgeKey]['id'][0] = $item['id'][0] . ',' . $age['id'][0];
                } else {
                  $nextStep = true;
                }
              }

              if (!empty($tempIdArr)) {
                array_push($prepared['ages'], $tempIdArr);
              }

              if ($nextStep) {
                array_push($prepared['ages'], $age);
              }

            } else {
              array_push($prepared['ages'], $age);
            }
          }
          // Remove DB return from array
          unset($prepared['ages_demo']);
          // Does POG to slice only the necessary fields
          $prepared['ages'] = array_slice($prepared['ages'], 0, $totalAgeResults);
          // echo '<pre>';
          // var_dump($prepared);
          // echo '</pre>';
          // exit();
          /**********************************************
          *
          *    ANSWER
          *
          **********************************************/

          require('new-plano.php');

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

        $id = $_GET['id'];
        $sql = "SELECT 
                $leads.id,
                $leads.name,
                $leads.email,
                $leads.telefone,
                $leads.created_at,
                $leads.ages_selected,
                $leads.status_id as 'status',
                $leads.obs,
                $categories.name as 'modalidade'
                FROM $leads
                INNER JOIN $categories ON $leads.categorias_id = $categories.id
                WHERE $leads.id = $id";
        $lead = $wpdb->get_row($sql);
        require('leads-details.php');
      } else {
        $sqlLeads = $wpdb->get_results("SELECT COUNT(id) as `total` FROM $leads");
        $totalLeads = intval($sqlLeads[0]->total);
        $currentPage = isset($_GET['pagen']) ? $_GET['pagen'] : 0;
        
        // Random separation for users
        if (current_user_can('author') || current_user_can('editor') || current_user_can('contributor')) {
          $user_id = get_current_user_id();
          $where = 'WHERE responsible = ' . $user_id;
        } else {
          $where = '';
        }

        if ($limit * ($currentPage + 1) >= $totalLeads || $totalLeads * $currentPage == 0) {
          $nextPageUrl = 'admin.php?page=seguro-saude-leads&pagen='.($currentPage + 1);
          $nextPage = true;
        } else {
          $nextPage = false;
        }

        if (($currentPage - 1) <= 0) {
          $previousPageUrl = 'admin.php?page=seguro-saude-leads';
          $previousPage = true;
        } else {
          $previousPage = false;
        }

        $page = $currentPage * $limit;
        $offset = ceil($totalLeads / $limit) - 1;

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
                LIMIT $page, $limit";

        $row = $wpdb->get_results($sql);
        $leadsMessage = nl2br(get_option('ss-amb1-msg-leads'));
        require('leads-list.php');
      }
    break;
    default:
      echo 'peeee';
    break;
  } 
}

function in_array_r($needle, $haystack, $strict = false) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }

    return false;
}