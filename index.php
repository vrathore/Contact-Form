<?php
/*
Plugin Name: Contact Form
Plugin URI: 
Description: A general contact form with four fields and a shortcode to be used on page or post. The fields are optional, can be enabled or disabled.
Version: 1.0
Author: Varsha Rathore
Author URI: http://www.avika.in
*/
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
	<?php }
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

/* CF_install() will add options in the option database table and set the default values provided against their option */
function CF_install() {
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

/* conatct_admin() includes the contact_admin.php page, which is the admin panel for the contact form plugin */
function contact_admin() {  
    include('contact_admin.php');
	}

/* Add the 'Contact Form' menu on wordpress dashboard */
function CF_add_to_menu() {
	add_menu_page('Contact Form', 'Contact Form', 'manage_options', 'my-top-level-handle', 'contact_admin');
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

register_activation_hook(__FILE__, 'CF_install');

?>