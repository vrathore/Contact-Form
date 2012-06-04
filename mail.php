<?php 
	/* To determine the home path of the wordpress wp-config.php file */
	$CF_abspath = dirname(__FILE__);
	$CF_abspath_1 = str_replace('wp-content/plugins/Contact_Form', '', $CF_abspath);
	$CF_abspath_1 = str_replace('wp-content\plugins\Contact_Form', '', $CF_abspath_1);
	
	/* Using the wp-config.php file, so as to use built in wordpress functions */
	require_once($CF_abspath_1 .'wp-config.php');

	/* Storing the values as passed on form submission */
	$CF_name = $_POST['CF_name'];
	$CF_email = $_POST['CF_email'];
	$CF_subject = $_POST['CF_subject'];
	$CF_message = $_POST['CF_message'];

	/* Fetching the values from option table */
	$CF_On_SendEmail = get_option('CF_On_SendEmail');
	$CF_On_MyEmail = get_option('CF_On_MyEmail');
	$CF_title = get_option('CF_title');
	$CF_On_Subject = get_option('CF_On_Subject');

	/* Check whether the admin email is updated or not */
	if($CF_On_MyEmail <> "youremail@simplecontactform.com") {
		/* The below code is for sending the mail to admin with the requisite details */
		$sender_email = mysql_real_escape_string(trim($CF_email));
		$subject = $CF_On_Subject;
		$subject = $CF_title;
		$subject = $subject." - ".$CF_subject;
		$message = $CF_message;				
		
		$message = preg_replace('|&[^a][^m][^p].{0,3};|', '', $message);
		$message = preg_replace('|&amp;|', '&', $message);
		$mailtext = wordwrap(strip_tags($message), 80, "\n");
				
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
		$headers .= "From: \"$sender_name\" <$sender_email>\n";
		$headers .= "Return-Path: <" . mysql_real_escape_string(trim($CF_email)) . ">\n";
		$headers .= "Reply-To: \"" . mysql_real_escape_string(trim($CF_name)) . "\" <" . mysql_real_escape_string(trim($CF_email)) . ">\n";
		$headers .= "To: \"" . $CF_On_MyEmail . "\" <" . $CF_On_MyEmail . ">\n";
		$mailtext = str_replace("\r\n", "<br />", $mailtext);
		if(wp_mail($CF_On_MyEmail, $subject, $mailtext, $headers))
			echo "Message sent successfully.";
		else
			echo "The message was not sent. Please try again.";
	}		
	else
		echo "The admin email id is not updated."
?>