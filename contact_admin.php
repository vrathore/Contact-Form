<div class="wrap">
	<h2> Contact Form</h2>
	<hr />
	<?php
		global $wpdb, $wp_version;
		
		/* Fetch the values form option table */
		$CF_title = get_option('CF_title');
		$CF_On_Name = get_option('CF_On_Name');
		$CF_On_Email = get_option('CF_On_Email');
		$CF_On_Message = get_option('CF_On_Message');
		$CF_On_Subject = get_option('CF_On_Subject');
		$CF_On_SendEmail = get_option('CF_On_SendEmail');
		$CF_On_MyEmail = get_option('CF_On_MyEmail');
		$CF_On_MySubject = get_option('CF_On_MySubject');
		
		/* Update the option table when the admin form is submitted*/
		if (@$_POST['CF_submit']) 
		{
			$CF_title = stripslashes($_POST['CF_title']);
			$CF_On_Name = stripslashes($_POST['CF_On_Name']);
			$CF_On_Email = stripslashes($_POST['CF_On_Email']);
			$CF_On_Message = stripslashes($_POST['CF_On_Message']);
			$CF_On_Subject = stripslashes($_POST['CF_On_Subject']);
			$CF_On_SendEmail = stripslashes($_POST['CF_On_SendEmail']);
			$CF_On_MyEmail = stripslashes($_POST['CF_On_MyEmail']);
			$CF_On_MySubject = stripslashes($_POST['CF_On_MySubject']);
			
			update_option('CF_title', $CF_title );
			update_option('CF_On_Name', $CF_On_Name );
			update_option('CF_On_Email', $CF_On_Email );
			update_option('CF_On_Message', $CF_On_Message );
			update_option('CF_On_Subject', $CF_On_Subject );
			update_option('CF_On_SendEmail', $CF_On_SendEmail );
			update_option('CF_On_MyEmail', $CF_On_MyEmail );
			update_option('CF_On_MySubject', $CF_On_MySubject );
		}
		?>
		
		<form name="form_CF" method="post" action="">
			<table width="100%" border="0" cellspacing="2" cellpadding="2">
				<tr>
					<td align="left">
						<h3>Contact form display fields</h3>
					</td>
				</tr>
				<tr>
					<td align="left">
						Title:
					</td>
					<td align="left">
						<input  style="width: 300px;" type="text" value="<?php echo $CF_title ?>" name="CF_title" id="CF_title" />
					</td>
				</tr>				
				<tr>
					<td align="left">
						Name:
					</td>
					<td align="left">
						<input type="radio" name="CF_On_Name" <?php if (strtoupper($CF_On_Name) == "YES") echo 'checked="checked"';  ?> value="YES">YES 
						<input type="radio" name="CF_On_Name" <?php if (strtoupper($CF_On_Name) == "NO") echo 'checked="checked"';  ?>value="NO">NO
					</td>
				</tr>				
				<tr>
					<td align="left">
						Email:
					</td>
					<td align="left">
						<input type="radio" name="CF_On_Email" <?php if (strtoupper($CF_On_Email) == "YES") echo 'checked="checked"';  ?> value="YES">YES
						<input type="radio" name="CF_On_Email" <?php if (strtoupper($CF_On_Email) == "NO") echo 'checked="checked"';  ?> value="NO">NO
					</td>
				</tr>				
				<tr>
					<td align="left">
						Subject:
					</td>
					<td align="left">
						<input type="radio" name="CF_On_Subject" <?php if (strtoupper($CF_On_Subject) == "YES") echo 'checked="checked"';  ?> value="YES">YES
						<input type="radio" name="CF_On_Subject" <?php if (strtoupper($CF_On_Subject) == "NO") echo 'checked="checked"';  ?> value="NO">NO
					</td>
				</tr>				
				<tr>
					<td align="left">
						Message:
					</td>
					<td align="left">
						<input type="radio" name="CF_On_Message" <?php if (strtoupper($CF_On_Message) == "YES") echo 'checked="checked"';  ?> value="YES">YES
						<input type="radio" name="CF_On_Message" <?php if (strtoupper($CF_On_Message) == "NO") echo 'checked="checked"';  ?> value="NO">NO
					</td>
				</tr>
				<tr>
					<td>
						<br /><br />
						<h3>Contact form admin details</h3>
					</td>
				</tr>
				<tr>
					<td>
						<p>Enter Email Address:</p>
					</td>
					<td align="left">
						<input  style="width: 300px;" type="text" value="<?php echo $CF_On_MyEmail ?>" name="CF_On_MyEmail" id="CF_On_MyEmail" /> ( Enter your email id to receive emails )
					</td>
				</tr>
				<tr>
					<td align="left">
						Enter Email Subject:
					</td>
					<td align="left">
						<input  style="width: 300px;" type="text" value="<?php echo $CF_On_MySubject ?>" name="CF_On_MySubject" id="CF_On_MySubject" /> ( Email subject)
					</td>
				</tr>
				<tr>
					<td>
						<br />
						<input type="submit" id="CF_submit" name="CF_submit" lang="publish" class="button-primary" value="Update Setting" value="1" />
					</td>
				</tr>
			</table>
		</form>	
	<br />
	<hr />
	<h2>Plugin Information</h2>		
	<h3>Plugin short code for pages/post</h3>
	<div style="padding-top:7px;padding-bottom:7px;">
		<code style="padding:7px;">[Contact] </code>
	</div>
</div>