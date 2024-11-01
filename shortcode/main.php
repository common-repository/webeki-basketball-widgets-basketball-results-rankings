<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 
class wbs_widget_shortcode 
{
	public static function basketstats_shortcode( $atts ) {

		$atts = shortcode_atts(
			array(
				'ranking' => '',
				'lang' => '',
				'type' => '',
				'group' => '',
			),
			$atts
		);

		switch ($atts['type']) {
			case '1':
				$url = 'https://www.basketballstats247.com/RankingsRssWidget.aspx?langId='.esc_html($atts['lang']).'&leagueId='.esc_html($atts['ranking']).'&stageId='.esc_html($atts['ranking']).'&groupName='.esc_html($atts['group']);
				break;
			case '2':
				$url= 'https://www.basketballstats247.com/MatchResultsRssWidget.aspx?langId='.esc_html($atts['lang']).'&leagueId='.esc_html($atts['ranking']).'&groupName='.esc_html($atts['group']);
				break;
			case '3':
				$url = 'https://www.basketballstats247.com/TeamStatsRssWidget.aspx?langId='.esc_html($atts['lang']).'&teamId='.esc_html($atts['ranking']);
				break;
			default:
				$url= 0;
				break;
		}

		if($url != 0 ){ ?>
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
			<div>
				<?php 
					$html = '<div id="bswidgetPreview">'; 
					$xml = simplexml_load_file($url);
					foreach($xml->channel->item as $item){
						$html .= ($item->description);
						$html .= "<hr />";
					}
					$html .= '</div>';
					return  $html; 
				?>
			</div>
		<?php }
		else{
			return 'No Preview Availble';
		}
	}
}
