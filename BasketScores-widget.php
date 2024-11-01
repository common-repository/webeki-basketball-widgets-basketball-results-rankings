<?php
/*
Plugin Name: WidgetLab Basketball Widgets: Basketball Results & Rankings
Plugin URI: https://www.widgetlab.net/wordpress-plugins/
Description: Basketball Widgets plugin allows Wordpress users to quickly implement basketball data like various table rankings and match results by competition into their WP posts and pages by using simple shortcodes.
Version: 1.1
Author: WidgetLab.net
Author URI: www.widgetlab.net
*/
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 
class wbs_widget
{
	function install()
	{
		$this->setupTables();
		$this->importCSVLeague();
	}
	function deactivate()
	{
		global $wpdb;
		$table_name = $wpdb->prefix . 'ce_bswidget_leagues';
    	$wpdb->query( "DROP TABLE IF EXISTS $table_name" );

    	$table_name_2 = $wpdb->prefix . 'ce_bswidget_teams';
    	$wpdb->query( "DROP TABLE IF EXISTS $table_name_2" );
	}

	private static function importCSVLeague(){
		global $wpdb;
		$table_name = $wpdb->prefix . 'ce_bswidget_leagues';
		$file_path = plugin_dir_path( __FILE__ ).'BasketLeaguesExport.csv';
		$handle = fopen($file_path, 'r');
		$data = fgetcsv($handle, 1000, ',');
		while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {		
			$inserted = $wpdb->insert($table_name, array(
   		 	'country' => (isset($data[0]) ? $data[0] : ''),
   		 	'LeagueName' => (isset($data[1]) ? $data[1] : ''),
  		 	'LeagueId' => (isset($data[2]) ? $data[2] : ''),
  		 	'isCup' => (isset($data[3]) ? $data[3] : ''), 
  		 	'stageName' => (isset($data[4]) ? $data[4] : ''), 
  		 	'stageId' => (isset($data[5]) ? $data[5] : ''),
  		 	'groupName' => (isset($data[6]) ? $data[6] : ''),
		));
		}

		$table_name_2 = $wpdb->prefix . 'ce_bswidget_teams';
		$file_path = plugin_dir_path( __FILE__ ).'BasketTeams.csv';
		$handle = fopen($file_path, 'r');
		$data = fgetcsv($handle, 1000, ',');
		while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {		
			$inserted = $wpdb->insert($table_name_2, array(
   		 	'country' => $data[0],
   		 	'LeagueName' => $data[1],
  		 	'TeamName' => $data[2], 
  		 	'TeamId' => $data[3]
		));
		}
	}
	private function setupTables(){
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$table_name = $wpdb->prefix . 'ce_bswidget_leagues';
		if($wpdb->get_var("show tables like '$table_name'") != $table_name) 
			{
				$sql = "CREATE TABLE `$table_name` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `country` varchar(60) NOT NULL,
			  `LeagueName` varchar(100) NOT NULL,
			  `LeagueId` varchar(20) NOT NULL,
			  `isCup` varchar(200) NOT NULL,
			  `stageName` varchar(200) NOT NULL,
			  `stageId` varchar(200) NOT NULL,
			  `groupName` varchar(200) NOT NULL,
			  primary key (id)
			) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			 dbDelta($sql);
		}

		$table_name_2 = $wpdb->prefix . 'ce_bswidget_teams';
		if($wpdb->get_var("show tables like '$table_name_2'") != $table_name_2) 
			{
			$sql2 = "CREATE TABLE `$table_name_2` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `country` varchar(60) NOT NULL,
			  `LeagueName` varchar(20) NOT NULL,
			  `TeamName` varchar(20) NOT NULL,
			  `TeamId` varchar(200) NOT NULL,
			  primary key (id)
			) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			 dbDelta($sql2);
		}
	}

	public static function onPluginReady(){
		//do_action('temp_warning',  array('wbs_widget_cronjob','temp_warning' ));
	}

	public function init(){
		$this->load_dependency();
		$this->load_actions();	
		$this->load_shortcodes();	
	}
	private function load_shortcodes(){
		add_shortcode( 'basketstats', array('wbs_widget_shortcode','basketstats_shortcode'));
	}

	private function load_actions(){
		add_action( 'admin_menu', array($this,'wbs_widget_add_admin_menu' ));
		add_action( 'admin_enqueue_scripts', array($this,'admin_enqueue_scripts') );
		add_action( 'admin_enqueue_scripts', array($this,'admin_enqueue_styles') );

		add_action( 'wp_enqueue_scripts', array($this,'frontend_enqueue_script') );

		add_action( 'admin_init', array($this,'register_settings') );
		add_action( 'wp_ajax_ce_bsw_fetchGroup', array($this,'my_ajax_fetchGroup_handler') );
		add_action( 'wp_ajax_ce_bsw_fetchTeams', array($this,'my_ajax_fetchTeams_handler') );
		add_action( 'wp_ajax_ce_bsw_processPreview', array($this,'my_ajax_processPreview_handler') );
	}
	public function frontend_enqueue_script(){
		wp_enqueue_style('ce_bs_widget_css_front', plugins_url('frontend/css/style.css',__FILE__ ));
	}
	public static function register_settings (){
		register_setting( 'ssw-ce-customizesettingB', 'raeven_b' );
		register_setting( 'ssw-ce-customizesettingB', 'raodd_b' );
		register_setting( 'ssw-ce-customizesettingB', 'caeven_b' );
		register_setting( 'ssw-ce-customizesettingB', 'caodd_b' );
		register_setting( 'ssw-ce-customizesettingB', 'fcfrcolumn_b' );
		register_setting( 'ssw-ce-customizesettingB', 'fcfrrow_b' );
		register_setting( 'ssw-ce-customizesettingB', 'customizeSettingB' );
	}
	public static function my_ajax_processPreview_handler(){
		$lang = sanitize_text_field((isset($_POST['Language']) && is_string($_POST['Language']) ? $_POST['Language'] : ''));
		$datatype = sanitize_text_field((isset($_POST['DataType']) && is_numeric($_POST['DataType']) ? $_POST['DataType'] : ''));
		$tournament = sanitize_text_field((isset($_POST['tournament']) && is_numeric($_POST['tournament']) ? $_POST['tournament'] : ''));
		$group = (empty($_POST['Group'])) ? ('') : ('group='.(sanitize_text_field($_POST['Group'])));?>

		<?php echo do_shortcode('[basketstats type='.$datatype.' lang='.$lang.' ranking='.$tournament.' '.$group.']');
		wp_die();
	}

	public static function my_ajax_fetchGroup_handler(){
		global $wpdb;
		$table_name = $wpdb->prefix . 'ce_bswidget_leagues';
		$LeagueId = sanitize_text_field((isset($_POST['leagueID']) && is_numeric($_POST['leagueID']) ? $_POST['leagueID'] : ''));
		if(isset($LeagueId) && !empty($LeagueId)){
			$groups = $wpdb->get_results ( "SELECT * FROM $table_name WHERE LeagueId = $LeagueId");
		}else{
			$groups = $wpdb->get_results ( "SELECT * FROM $table_name");
		}
		
		$count = 0;
		foreach ($groups as $group) {
			if(empty($group->groupName)){
				continue;
			}
			echo '<option>'.esc_html($group->groupName).'</option>';
		}
		wp_die();
	}

	public static function my_ajax_fetchTeams_handler(){
		global $wpdb;
		$table_name = $wpdb->prefix . 'ce_bswidget_leagues';
		$table_name_2 = $wpdb->prefix . 'ce_bswidget_teams';
		$data_type = sanitize_text_field((isset($_POST['data_type']) && is_numeric($_POST['data_type']) ? $_POST['data_type'] : ''));

		if($data_type == 3){
			$teams = $wpdb->get_results ( "SELECT * FROM $table_name_2");
			$count =0;
			foreach ($teams as $team) {
				if(empty($team->TeamName)){
					continue;
				}
				echo '<option value="'.esc_html($team->TeamId).'">'.esc_html($team->country).' - '.esc_html($team->LeagueName).' - '.esc_html($team->TeamName).'</option>';
			}
		}else if ($data_type == 1){
			$leagues = $wpdb->get_results ( "SELECT DISTINCT isCup , LeagueId , country , LeagueName FROM $table_name WHERE isCup=0 ");
			$count =0;
			foreach ($leagues as $league) {
				echo '<option class="isLeague'.esc_html($league->isCup).'" value="'.esc_html($league->LeagueId).'">'.esc_html($league->country).' , '.esc_html($league->LeagueName).'</option>';
			}
		}else{
			$leagues = $wpdb->get_results ( "SELECT DISTINCT isCup , LeagueId , country , LeagueName FROM $table_name");
			$count =0;
			foreach ($leagues as $league) {
				echo '<option class="isLeague'.esc_html($league->isCup).'" value="'.esc_html($league->LeagueId).'">'.esc_html($league->country).' , '.esc_html($league->LeagueName).'</option>';
			}
		}

		wp_die();
	}

	public static function admin_enqueue_scripts($hook){
    	wp_enqueue_script( 'ce_bs_widget_js', plugin_dir_url( __FILE__ ) . 'admin/js/script.js', array(), '1.0' );
	}
	
	public static function admin_enqueue_styles($hook){
		wp_enqueue_style('ce_bs_widget_css', plugins_url('admin/css/style.css',__FILE__ ));
	}
	
	private function load_dependency(){
		require_once('admin/settings.php');
		require_once('admin/customization.php');
		require_once('shortcode/main.php');
	}

	public static function wbs_widget_add_admin_menu(  ) { 
		add_menu_page( 'Basketball Scores', 'Basketball Widgets', 'manage_options', 'wbs-basket-scores-widget', 'wbs_widget_options_page' , plugins_url( 'images/icon.png', __FILE__  ) );
		add_submenu_page('wbs-basket-scores-widget', 'Customization', 'Customization', 'manage_options', 'wbs-widget-customize','wbs_widget_customization_page' );
	}
}
$wbs_widget = new wbs_widget();
register_activation_hook( __FILE__, array( $wbs_widget, 'install' ) );
register_deactivation_hook( __FILE__, array( $wbs_widget, 'deactivate' ) );
$wbs_widget->init();