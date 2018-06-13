<?php 
/*
Plugin Name: Cálculo Seguro Saúde
Description: Ferramenta para fazer o calculo do plano de saúde do cliente do site. Também envia emails para a equipe de atendimento e estrutura totalmente os leads para contato posterior. 
Version: 1.0.0
Author: Ambiente 1
Author URI: https://ambiente1.com.br
License: Copyright
Text Domain: seguro-saude
*/


define( 'CALC_SS_VERSION', '1.0.0');
define( 'SEGUROSAUDE__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

register_activation_hook( __FILE__, array( 'SeguroSaude', 'plugin_activation' ) );
register_deactivation_hook( __FILE__, array( 'SeguroSaude', 'plugin_deactivation' ) );
add_action( 'init', array( 'SeguroSaude', 'init' ) );

require_once(SEGUROSAUDE__PLUGIN_DIR . 'class.calc-ss.php');