<?php
/*
Plugin Name: Contact Form
Plugin URI: 
Description: A general contact form with four fields and a shortcode to be used on page or post. The fields are optional, can be enabled or disabled. The form can also be used as a widget. Also, to enhance the contact form usability, a security code feature is also added and all the form details can be viewed at the admin side.
Version: 1.2
Author: Varsha Rathore
Author URI: http://www.avika.in
*/

session_start();

function CF() {
?>
<!-- Wordpress plugin form tag for displaying and submitting the contact form filled at front end -->
	<form action="#" name="CF" id="CF">
	<div class="CF_title"> <span id="CF_alertmessage"></span> </div>
	<?php 
		/* If condition to check whether 'Your Name' field is enabled */
		if(get_option('CF_On_Name') == 'YES')
		{
	?> 
			<div class="CF_title"> Your Name </div>
			<div class="CF_title">
				<input name="CF_name" class="CFtextbox" type="text" id="CF_name" maxlength="120">
			</div>
	<?php
		}  
		/* If condition to check whether 'Your Email' field is enabled */		
		if(get_option('CF_On_Email') == 'YES') {
	?>
			<div class="CF_title"> Your Email </div>
		  	<div class="CF_title">
				<input name="CF_email" class="CFtextbox" type="text" id="CF_email" maxlength="120">
		  	</div>
	<?php
		}
		/* If condition to check whether 'Enter Subject' field is enabled */		
		if(get_option('CF_On_Subject') == 'YES') {	 
	?>
			<div class="CF_title"> Enter Subject </div>
		 	<div class="CF_title">
				<input name="CF_subject" class="CFtextbox" type="text" id="CF_subject" maxlength="120">
		  	</div>
	<?php
		}
		/* If condition to check whether 'Enter your message' field is enabled */		
		if(get_option('CF_On_Message') == 'YES') {
	?>
			<div class="CF_title"> Enter your message </div>
  			<div class="CF_title">
				<textarea name="CF_message" class="CFtextarea" rows="3" id="CF_message"></textarea>
			</div>
	<?php
		}
		/* If condition to check whether 'Captcha' field is enabled */		
		if(get_option('CF_On_Captcha') == 'YES') {
			$linkss = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)); 
	?>
			<div class="CF_title">
			<label class="contact-label" for="antispam">Captcha<br /><img src="<?php echo $linkss; ?>captcha.php" alt="captcha image"></label>
			<div class="CF_title">
				<input type="text" id="CF_captcha" name="CF_captcha" value="<?php //echo $_SESSION['captcha'] ?>" size="6" maxlength="6"/><?php //echo $_SESSION['captcha'] ?>
	<?php
		}
	?>
	
<!-- Form 'Submit' button; applied javascript onclick attribute -->
		<div class="CF_title">
			<input type="button" name="button" value="Submit" onclick="javascript:CF_submit(this.parentNode,'<?php echo get_option('siteurl');?>/wp-content/plugins/Contact_Form/')">
		</div>
	</form>
<?php
}

/* Shortcode created, which can be used on any page or post */	
add_shortcode('Contact', 'CF');

/* CF_install() will add options in the option database table and set the default values provided against their option 
	Also, in addition to a separate table is also created, which stores the form details submitted */
function CF_install() {

	global $wpdb, $wp_version;
	$CF_table = $wpdb->prefix . "CF";
	add_option('CF_table', $CF_table);
	
	/* It checks the non-existance of the table to be created for contact form details */
	if($wpdb->get_var("show tables like '". $CF_table . "'") != $CF_table) 
	{
		$wpdb->query("
			CREATE TABLE IF NOT EXISTS `". $CF_table . "` (
			  `CF_id` int(11) NOT NULL auto_increment,
			  `CF_name` varchar(120) NOT NULL,
			  `CF_email` varchar(120) NOT NULL,
			  `CF_subject` varchar(120) NOT NULL,
			  `CF_message` varchar(1024) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
			  `CF_ip` varchar(50) NOT NULL,
			  `CF_date` datetime NOT NULL default '0000-00-00 00:00:00',
			  PRIMARY KEY  (`CF_id`) )
			");
	}

	add_option('CF_title', "Contact Us");
	add_option('CF_fromemail', "admin@contactform.com");
	add_option('CF_On_Name', "YES");
	add_option('CF_On_Email', "YES");
	add_option('CF_On_Message', "YES");
	add_option('CF_On_Subject', "NO");
	add_option('CF_On_SendEmail', "YES");
	add_option('CF_On_MyEmail', "youremail@contactform.com");
	add_option('CF_On_MySubject', "contact form");
	add_option('CF_On_Captcha', "YES");
}

/* CF_widget() displays the contact form in the widget area */
function CF_widget($args) 
{
		extract($args);
		echo $before_widget . $before_title;
		echo get_option('CF_title');
		echo $after_title;
		CF();
		echo $after_widget;
}

/* CF_widget_init() initializes widget feature for the contact form */
function CF_widget_init()
{
	if(function_exists('wp_register_sidebar_widget')) 
	{
		wp_register_sidebar_widget('Contact Form', 'Contact Form', 'CF_widget');
	}
}

/* conatct_admin() includes the contact_admin.php page, which is the admin panel for the contact form plugin */
function contact_admin() {  
    include('contact_admin.php');
}

function CF_admin(){ 
?>
	<div class="wrap">
		<div class="tool-box">
    	<?php
			global $wpdb;
			$cf_table = get_option('CF_table');
			if(@$_GET["AC"]=="DEL" && @$_GET["DID"] > 0) { 
				$wpdb->get_results("delete from $cf_table where CF_id=".@$_GET["DID"]);
			}
			$data = $wpdb->get_results("select * from $cf_table order by CF_id desc");
			if ( empty($data) ) {
				echo "<div id='message' class='error'><p>In this page you can see the entered contact details.</p></div>";
			}
		?>
			<h3>Records of Contact Form</h3>
			<script language="javascript" type="text/javascript">
				function _dealdelete(id){
					if(confirm("Do you want to delete this record?")){
						document.form.action="options-general.php?page=Contact_Form/index.php&AC=DEL&DID="+id;
						document.form.submit();
					}
				}	
			</script>
			
			<form name="form" method="post">
				<table width="100%" class="widefat" id="straymanage">
					<thead>
						<tr>
							<th width="12%" align="left">Name</th>
							<th width="16%" align="left">Email</th>
							<th width="16%" align="left">Subject</th>
							<th width="34%" align="left">Message</th>
							<th width="7%" align="left">Date</th>
							<th width="15%" align="left">IP</th>
							<th width="2%" align="left"></th>
						</tr>
					<thead>
					<tbody>
						<?php 
							$i = 0;
							foreach ( $data as $data ) { 
								$_date = mysql2date(get_option('date_format'), $data->CF_date);
    					?>
						<tr class="<?php if ($i&1) { echo'alternate'; } else { echo ''; }?>">
							<td align="left"><?php echo(stripslashes($data->CF_name)); ?></td>
							<td align="left"><?php echo(stripslashes($data->CF_email)); ?></td>
							<td align="left"><?php echo(stripslashes($data->CF_subject)); ?></td>
							<td align="left"><?php echo(stripslashes($data->CF_message)); ?></td>
							<td align="left"><?php echo($_date); ?></td>
							<td align="left"><?php echo(stripslashes($data->CF_ip)); ?></td>
							<td align="left"><a title="Delete" onClick="javascript:_dealdelete('<?php echo($data->CF_id); ?>')" href="javascript:void(0);">X</a> </td>
						</tr>
						<?php $i = $i+1; } ?>
					</tbody>
				</table>
			</form>
		</div>
	</div>
	<?php
}
	

/* Add the 'Contact Form' menu and records sub menu on wordpress dashboard */
function CF_add_to_menu() {
	add_menu_page('Contact Form', 'Contact Form', 'manage_options', 'my-top-level-handle', 'contact_admin');
	//add_submenu_page( 'my-top-level-handle', 'Page title', 'Records', 'manage_options', 'my-submenu-handle', 'CF_admin');
}

/* Checks for the admin account and calls the CF_add_to_menu() at the admin side */
if (is_admin()) {
	add_action('admin_menu', 'CF_add_to_menu');
}

/* Checks for the non admin account and includes the javascript file used for validation purpose at the front end */
function CF_add_javascript_files() 
{
	if (!is_admin())
	{
		wp_enqueue_script( 'Contact Form', get_option('siteurl').'/wp-content/plugins/Contact_Form/contact_form.js');
	}
}
add_action('init', 'CF_add_javascript_files');

add_action("plugins_loaded", "CF_widget_init");

register_activation_hook(__FILE__, 'CF_install');

?>