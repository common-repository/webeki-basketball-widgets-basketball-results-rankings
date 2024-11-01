<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 
function wbs_widget_customization_page(  ) { 
global $wpdb;
$table_name = $wpdb->prefix . 'ce_bswidget_leagues';
$leagues = $wpdb->get_results ( "SELECT DISTINCT LeagueName , LeagueId FROM $table_name");
?>
	<form method='post' id="bswidget-customizer" action="options.php">
		<?php wp_nonce_field('bswidget-customizeoptions'); ?>
		<?php settings_fields( 'ssw-ce-customizesettingB' ); ?>
		<h2>Customization Settings for Basketball Widgets</h2>
		<select name="customizeSettingB" id="customizeSettingB">
			<option <?php echo (get_option('customizeSettingB')==1)?('selected'):(''); ?> value="1">Row Alternate Colors</option>
			<option <?php echo (get_option('customizeSettingB')==2)?('selected'):(''); ?> value="2">Columns Alternate Colors</option>
			<option <?php echo (get_option('customizeSettingB')==3)?('selected'):(''); ?> value="3">First Row/Column Colors</option>
		</select>

		<div id="rowAlternateColor">
			<br>
			<label>Even Row
				<input value="<?php echo esc_attr(get_option('raeven_b')); ?>" type="color" name="raeven_b">
			</label><br><br>
			<label>Odd Row
				<input value="<?php echo esc_attr(get_option('raodd_b')); ?>" type="color" name="raodd_b">
			</label>
		</div>

		<div id="columnAlternateColor">
			<br>
			<label>Even Row
				<input value="<?php echo esc_attr(get_option('caeven_b')); ?>" type="color" name="caeven_b">
			</label><br><br>
			<label>Odd Row
				<input value="<?php echo esc_attr(get_option('caodd_b')); ?>" type="color" name="caodd_b">
			</label>
		</div>

		<div id="fcfr">
			<br>
			<label>First Column
				<input value="<?php echo esc_attr(get_option('fcfrcolumn_b')); ?>" type="color" name="fcfrcolumn_b">
			</label><br><br>
			<label>First Row&nbsp; &nbsp; &nbsp;
				<input value="<?php echo esc_attr(get_option('fcfrrow_b')); ?>" type="color" name="fcfrrow_b">
			</label><br><br>
		</div>
		<br><br>
		<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
		<h2>Preview (hit Save above for preview load)</h2>
		<style type="text/css">
			<?php if(get_option('customizeSettingB')==1){ ?>
				#bswidgetPreview tr:nth-child(odd){background-color:<?php echo esc_attr(get_option('raodd_b')); ?>;}
				#bswidgetPreview tr:nth-child(even){background-color:<?php echo esc_attr(get_option('raeven_b')); ?>;}
			<?php }?>

			<?php if(get_option('customizeSettingB')==2){ ?>
				#bswidgetPreview td:nth-child(odd){background-color:<?php echo esc_attr(get_option('caodd_b')); ?>;}
				#bswidgetPreview td:nth-child(even){background-color:<?php echo esc_attr(get_option('caeven_b')); ?>;}
			<?php }?>

			<?php if(get_option('customizeSettingB')==3){ ?>
				#bswidgetPreview td:nth-child(1){background-color:<?php echo esc_attr(get_option('fcfrcolumn_b')); ?>;}
				#bswidgetPreview th { background-color: <?php echo esc_attr(get_option('fcfrrow_b')); ?>;} 
			<?php }?>
		</style>
		<div id="bswidgetPreview">
			<a href="https://www.basketballstats247.com/competitions/united-kingdom/bbl/" target="_blank">BBL 2022/2023 Regular Season</a><br/><br/><table border="1" width="100%"><tr><th colspan="2"></th><th>Games Played</th><th>Won</th><th>Lost</th><th>%</th><th>Points For</th><th>Points Against</th><th>Points</th><th>Recent Form</th></tr><tr><td width="3%">1</td><td width="27%"><a target="_blank" href="https://www.basketballstats247.com/teams/united-kingdom/london-lions/"/>London Lions</td><td width="7%"><center>30</center></td><td width="7%"><center>27</center></td><td width="7%"><center>3</center></td><td width="7%"><center>0.9</center></td><td width="7%"><center>2629</center></td><td width="7%"><center>2143</center></td><td width="7%"><center>54</center></td><td><center>EEEEE</center></td></tr><tr><td width="3%">2</td><td width="27%"><a target="_blank" href="https://www.basketballstats247.com/teams/united-kingdom/bristol-flyers/"/>Bristol Flyers</td><td width="7%"><center>31</center></td><td width="7%"><center>21</center></td><td width="7%"><center>10</center></td><td width="7%"><center>0.68</center></td><td width="7%"><center>2577</center></td><td width="7%"><center>2493</center></td><td width="7%"><center>42</center></td><td><center>EEEEE</center></td></tr><tr><td width="3%">3</td><td width="27%"><a target="_blank" href="https://www.basketballstats247.com/teams/united-kingdom/leicester-riders/"/>Leicester Riders</td><td width="7%"><center>29</center></td><td width="7%"><center>20</center></td><td width="7%"><center>9</center></td><td width="7%"><center>0.69</center></td><td width="7%"><center>2547</center></td><td width="7%"><center>2383</center></td><td width="7%"><center>40</center></td><td><center>EEEEE</center></td></tr><tr><td width="3%">4</td><td width="27%"><a target="_blank" href="https://www.basketballstats247.com/teams/united-kingdom/manchester-giants/"/>Manchester Giants</td><td width="7%"><center>30</center></td><td width="7%"><center>17</center></td><td width="7%"><center>13</center></td><td width="7%"><center>0.57</center></td><td width="7%"><center>2701</center></td><td width="7%"><center>2665</center></td><td width="7%"><center>34</center></td><td><center>EEEEE</center></td></tr><tr><td width="3%">5</td><td width="27%"><a target="_blank" href="https://www.basketballstats247.com/teams/united-kingdom/caledonia-gladiators/"/>Caledonia Gladiators</td><td width="7%"><center>29</center></td><td width="7%"><center>15</center></td><td width="7%"><center>14</center></td><td width="7%"><center>0.52</center></td><td width="7%"><center>2406</center></td><td width="7%"><center>2390</center></td><td width="7%"><center>30</center></td><td><center>EEEEE</center></td></tr><tr><td width="3%">6</td><td width="27%"><a target="_blank" href="https://www.basketballstats247.com/teams/united-kingdom/glasgow-rocks/"/>Glasgow Rocks</td><td width="7%"><center>0</center></td><td width="7%"><center>0</center></td><td width="7%"><center>0</center></td><td width="7%"><center>-</center></td><td width="7%"><center>0</center></td><td width="7%"><center>0</center></td><td width="7%"><center>0</center></td><td><center>EEEEE</center></td></tr><tr><td width="3%">6</td><td width="27%"><a target="_blank" href="https://www.basketballstats247.com/teams/united-kingdom/cheshire-phoenix/"/>Cheshire Phoenix</td><td width="7%"><center>29</center></td><td width="7%"><center>14</center></td><td width="7%"><center>15</center></td><td width="7%"><center>0.48</center></td><td width="7%"><center>2344</center></td><td width="7%"><center>2346</center></td><td width="7%"><center>28</center></td><td><center>EEEEE</center></td></tr><tr><td width="3%">7</td><td width="27%"><a target="_blank" href="https://www.basketballstats247.com/teams/united-kingdom/sheffield-sharks/"/>Sheffield Sharks</td><td width="7%"><center>30</center></td><td width="7%"><center>14</center></td><td width="7%"><center>16</center></td><td width="7%"><center>0.47</center></td><td width="7%"><center>2196</center></td><td width="7%"><center>2233</center></td><td width="7%"><center>28</center></td><td><center>EEEEE</center></td></tr><tr><td width="3%">8</td><td width="27%"><a target="_blank" href="https://www.basketballstats247.com/teams/united-kingdom/plymouth-city-patriots/"/>Plymouth City Patriots</td><td width="7%"><center>29</center></td><td width="7%"><center>10</center></td><td width="7%"><center>19</center></td><td width="7%"><center>0.34</center></td><td width="7%"><center>2325</center></td><td width="7%"><center>2601</center></td><td width="7%"><center>20</center></td><td><center>EEEEE</center></td></tr><tr><td width="3%">9</td><td width="27%"><a target="_blank" href="https://www.basketballstats247.com/teams/united-kingdom/newcastle-eagles/"/>Newcastle Eagles</td><td width="7%"><center>29</center></td><td width="7%"><center>7</center></td><td width="7%"><center>22</center></td><td width="7%"><center>0.24</center></td><td width="7%"><center>2322</center></td><td width="7%"><center>2475</center></td><td width="7%"><center>14</center></td><td><center>EEEEE</center></td></tr><tr><td width="3%">10</td><td width="27%"><a target="_blank" href="https://www.basketballstats247.com/teams/united-kingdom/surrey-scorchers/"/>Surrey Scorchers</td><td width="7%"><center>30</center></td><td width="7%"><center>3</center></td><td width="7%"><center>27</center></td><td width="7%"><center>0.1</center></td><td width="7%"><center>2264</center></td><td width="7%"><center>2582</center></td><td width="7%"><center>6</center></td><td><center>EEEEE</center></td></tr></table><br/>
		</div>
		<p><strong>Advice:</strong> We do not recommend the implementation of multiple such snippets in a single article as
		it may slow down the load of your page given there will be more data to be transmitted.</p>
		<p><i>Note: Data provided by BasketballStats247.com. More widget possibilities like team stats, results
		or rankings can be generated on the official website in the Widgets Page.</i></p>

	</form>
<?php
}
?>