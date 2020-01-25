<?php
/**
 * @package simple-date-and-time-xs
 * @version 1.0
 */
/*
Plugin Name: Simple Date and Time
Plugin URI: http://xpertsol.org/simple-date-and-time
Description: Add simple date and and time in text form to your post or page using shortcode. 
Version: 1.0
Author: Xpert Solution
Author URI: http://xpertsol.org/
*/

add_action('admin_menu', 'datxs_datetime_menu');
add_shortcode( 'simple_date_time_xs' , 'datxs_datetime_sc' );

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if (!is_admin()) { add_action("wp_enqueue_scripts", "datxs_jquery_enqueue", 11); }


function datxs_jquery_enqueue() {
    wp_deregister_script('jquery');
    wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js", false, null);
    wp_enqueue_script('jquery');
}



function datxs_datetime_menu(){

add_menu_page( 'Simple Date and Time', 'Simple Date and Time', 'manage_options', 'datxs-simple-date-time', 'datxs_main_pageac');
}





function datxs_main_pageac(){
	if ( !is_admin( ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}

echo datxs_about_plugin();

}




function datxs_datetime_sc($atts)
{

    $a = shortcode_atts( array(
        'timezone' => 'timezone',
        'date' => 'date',
        'time' => 'time'
    ), $atts );
    
    ?>
    <style>

#currentTime_datxs{
	
	font-family:"Open Sans",Arial,sans-serif;
	color:#e54e53 !important;
	
}


</style>
    
    <span id="currentTime_datxs"></span>
    

		<script type="text/javascript">

		function getCurrentTime(){


			$.ajax({
			    url : '<?php echo  plugin_dir_url( __FILE__ ) .'inc_data.php?date='.$a['date'].'&time='.$a['time'].'&timezone='.$a['timezone']; ?>',
			    type : 'GET',
			    success : function (data) {


			    	if(data != '')
			    	{
			    		$('#currentTime_datxs').html(data);			    	
					
			    	}
			    	
			    	
			    }      
			});
								
			
		}

		getCurrentTime();
		</script>
		
    
    
    <?php 

    
}



	
	



function datxs_footer_pages()
{
	?>
   Email us for support.
	<?php
	
	
}


function datxs_tz_list() {
    $zones_array = array();
    $timestamp = time();
    foreach(timezone_identifiers_list() as $key => $zone) {
        date_default_timezone_set($zone);
        $zones_array[$key]['zone'] = $zone;
       // $zones_array[$key]['diff_from_GMT'] = date('P', $timestamp);
    }
    return $zones_array;
}


function datxs_about_plugin()
{
	?>
    <h1>About Simple Date and Time Plugin</h1>
    For any queries contact us @ support@xpertsol.org<br />
 We would appreciate if you report any bugs or send us improvement suggestions.
<br />
    
    <h2>How to Use ?</h2>
    <p>
    - You have to add a shortcode on pages/post you have adult content [simple_date_time_xs timezone=timezone-value date=yes time=yes]<br>
    - Choose a timzone from the list below and replace it with timezone-value in shortcode. <br>
    - Shortcode attributes date or time should be set to "yes" to display. By default both date and time are set to no display.
     </p>
   
    <div>
    <h4>List of all supported timezones</h4>
  <ul>
    <?php foreach(datxs_tz_list() as $t) { ?>
      <li>
        <?php print $t['zone'] ?>
      </li>
    <?php } ?>
 </ul>
</div>

    <?php
	echo datxs_footer_pages();
	
}