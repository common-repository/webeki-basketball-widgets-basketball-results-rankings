<?php 
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 
	function wbs_widget_options_page(  ) { 
	global $wpdb;
	$table_name = $wpdb->prefix . 'ce_bswidget_leagues';
	$leagues = $wpdb->get_results ( "SELECT DISTINCT isCup , LeagueId , country , LeagueName FROM $table_name");
?>
	<form method='post' id="bswidget-generator">
		<h2>Generate Basketball Widget Shortcode</h2>
			<select name="bswidget_language" id="bswidgetlanguage">
				<option value="0">Select Language</option>
				<option value="1">English</option>
				<option value="2">Romanian</option>
				<option value="3">Spanish</option>
				<option value="4">German</option>
				<option value="5">French</option>
				<option value="6">Dutch</option>
				<option value="7">Italian</option>
				<option value="8">Swedish</option>
				<option value="9">Norwegian</option>
				<option value="10">Danish</option>
				<option value="11">Finnish</option>
				<option value="12">Portuguese</option>
				<option value="13">Polish</option>
				<option value="14">Hungarian</option>
				<option value="15">Czech</option>
				<option value="16">Greek</option>
			</select>
	
			<select name="bswidget_data_type" id="bswidgetdatatype">
				<option value="0">Select Data Type</option>
				<option value="1">Rankings</option>
				<option value="2">Match Results</option>
				<option value="3">Team Stats</option>

			</select>

			<select name="bswidget_tournament" id="bswidgettournament">
				<option value="0">Select competition</option>
				<?php foreach($leagues as $league){
					echo '<option class="isLeague'.esc_html($league->isCup).'" value="'.esc_html($league->LeagueId).'">'.esc_html($league->country).' , '.esc_html($league->LeagueName).'</option>';
				}?>
			</select>	
			<select name="bswidget_group" id="bswidgetgroup" style="display: none;">
			</select>

			<h2>Use Shortcode</h2>
			<code id="ShortcodePrev">Please Select The Required Fields</code>
			<h2>Preview</h2>
			<div id="bswidgetPreviewDemo"></div>
			<p><strong>Advice:</strong> We do not recommend the implementation of multiple such snippets in a single article as
			it may slow down the load of your page given there will be more data to be transmitted.</p>
			<p><i>Note: Data provided by BasketballStats247.com. More widget possibilities like team stats, results
			or rankings can be generated on the official website in the Widgets Page.</i></p>
		</form>
	<?php

}
?>