<?php
/***********************************************************************************************************
* Send Email with Cc, Bcc and File Attachment using Ajax, Jquery and PHP
* Written by Vasplus Programming Blog
* Website: www.vasplus.info
* Email: info@vasplus.info

**********************************Copyright Information*****************************************************
* This script has been released with the aim that it will be useful.
* Please, do not remove this copyright information from the top of this page 
* If you want the copyright info including the to be removed from the script then you have to buy this script.
* This script must not be used for commercial purpose without the consent of Vasplus Programming Blog.
* This script must not be sold.
* All Copy Rights Reserved by Vasplus Programming Blog
*************************************************************************************************************/


ini_set('error_reporting', 0);

if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
{
	// From Form
	$submissionType = trim(strip_tags($_POST['uploadSubmissionType']));
	$title          = trim(strip_tags($_POST['uploadTitle']));
	$Series         = trim(strip_tags($_POST['uploadSeries']));
	$feedbackType   = trim(strip_tags($_POST['uploadType']));
	$description    = trim(strip_tags($_POST['uploadDescription']));
	$summonerName   = trim(strip_tags($_POST['uploadSummonerName']));
	$startTimeMin   = trim(strip_tags($_POST['uploadStartTimeMin']));
	$startTimeSec   = trim(strip_tags($_POST['uploadStartTimeSec']));
	$endTimeMin     = trim(strip_tags($_POST['uploadEndTimeMin']));
	$endTimeSec     = trim(strip_tags($_POST['uploadEndTimeSec']));



	$to       = 'cal.au0927@gmail.com';
	$cc       = trim(strip_tags($_POST['cc']));
	$bcc      = trim(strip_tags($_POST['bcc']));
	$from     = 'ad.cal.au0927@gmail.com';

	$error = '';

	switch ($submissionType) {
		case 'Video':
			if (!isset($_FILES["attachment_file"]) || $_FILES['attachment_file']['name'] == "" || strtolower(pathinfo($_FILES['attachment_file']['name'], PATHINFO_EXTENSION)) != 'lrf') {
				$error .= '<br clear="all"><div class="info">Please select an lrf file in the <b>FILE</b> field to proceed. Thanks.</div>';
			}
			else if ($title == "") {
				$error .= '<br clear="all"><div class="info">Please enter a general description of your video in the <b>TITLE</b> field to proceed. Thanks.</div>';	
			}
			else if ($Series == "") {
				$error .= '<br clear="all"><div class="info">Please enter the series you think this video applies to in the <b>SERIES</b> field to proceed. Thanks.</div>';		
			}
			else if ($description == "") {
				$error .= '<br clear="all"><div class="info">Please enter a detail description in the <b>DESCRIPTION</b> field to proceed. Thanks.</div>';	
			}
			else if ($summonerName == "") {
				$error .= '<br clear="all"><div class="info">Please enter your summoner name in the <b>SUMMONER NAME</b> field to proceed. Thanks.</div>';	
			}
			else if (is_int($startTimeMin) && is_int($startTimeSec)) {
				$error .= '<br clear="all"><div class="info">Please enter your a valid time in the <b>START TIME</b> field to proceed. Thanks.</div>';	
			}
			else if (is_int($endTimeMin) && is_int($endTimeSec)) {
				$error .= '<br clear="all"><div class="info">Please enter your a valid time in the <b>END TIME</b> field to proceed. Thanks.</div>';	
			}
			$subject 			= 'WEBSITE ('.$submissionType.'): '.$Series;
			$message_to_send 	= 'Title: '.$title.'<br />Series: '.$Series.'<br />Description: '.$description.'<br />Summoner Name: '.$summonerName.'<br />Time Duration: '.$startTimeMin.':'.$startTimeSec.' - '.$endTimeMin.':'.$endTimeSec;
			break;
		case 'T-Shirt':
			if (!isset($_FILES["attachment_file"]) || $_FILES['attachment_file']['name'] == "" || in_array(strtolower(pathinfo($_FILES['attachment_file']['name'], PATHINFO_EXTENSION)), array("jpg","jpeg", "gif","png"))) {
				$error .= '<br clear="all"><div class="info">Please select an image file in the <b>FILE</b> field to proceed. Thanks.</div>';
			}
			else if ($description == "") {
				$error .= '<br clear="all"><div class="info">Please enter a description in the <b>DESCRIPTION</b> field to proceed. Thanks.</div>';	
			}
			else if ($summonerName == "") {
				$error .= '<br clear="all"><div class="info">Please enter your summoner name in the <b>SUMMONER NAME</b> field to proceed. Thanks.</div>';	
			}

			$subject			= 'WEBSITE ('.$submissionType.')';
			$message_to_send 	= 'Description: '.$description.'<br />Summoner Name: '.$summonerName;
			break;
		case 'Feedback':
			if ($title == "") {
				$error .= '<br clear="all"><div class="info">Please enter a general description of your video in the <b>TITLE</b> field to proceed. Thanks.</div>';	
			}
			else if ($description == "") {
				$error .= '<br clear="all"><div class="info">Please enter a detail description in the <b>DESCRIPTION</b> field to proceed. Thanks.</div>';	
			}
			else if ($summonerName == "") {
				$error .= '<br clear="all"><div class="info">Please enter your summoner name in the <b>SUMMONER NAME</b> field to proceed. Thanks.</div>';	
			}

			$subject 			= 'WEBSITE ('.$submissionType.'['.$feedbackType.']): '.$title;
			$message_to_send 	= 'Type: '.$feedbackType.'<br /><br /><br />Title: '.$title.'<br />Description: '.$description.'<br />Summoner Name: '.$summonerName;
			$_FILES['attachment_file']['name'] = '';
			break;
	}

$message_to_send = <<<EOF

  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
   <html xmlns="http://www.w3.org/1999/xhtml">
   <head>
   <title>vasPLUS Programming Blog Mailer</title>
   </head>
   <body>
	<table bgcolor="#FFF" align="left" cellpadding="6" cellspacing="6" width="100%" border="0">
    <tr>
    <td valign="top" colspan="2" align="left">
            
	<p align="left"><font style='font-family:Verdana, Geneva, sans-serif; font-size:12px; color:black;'>$message_to_send</font></p><br /><br />
			
   </td>
  </tr>
  <tr>
  <td colspan="2" align="center">
  <table height="40" width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F6F6F6" style="height:30;padding:0px;border:1px solid #EAEAEA;">
  <tr>
    <td><p align='center'><font style="font-family:Verdana, Geneva, sans-serif; font-size:10px;color:black;">Copyright &copy; $v_year | All Rights Reserved.</font></p></td>
  </tr>
</table>
</td>
</tr>
</table>
      </body>
   </html>
EOF;
	
	//Perform Validation Process
	if ($error != '') {
		echo $error;
	}
	else
	{
		//If the user attaches a file, then proceed with the email sending below with an attachment
		
		if (isset($_FILES["attachment_file"]) && $_FILES['attachment_file']['name'] != "") 
		{
			// Obtain file upload vars
			$attachment_file      = $_FILES['attachment_file']['tmp_name'];
			$attachment_file_type = $_FILES['attachment_file']['type'];
			$attachment_file_name = $_FILES['attachment_file']['name'];
			
			$name = $_FILES['attachment_file']['name'];
			$size = $_FILES['attachment_file']['size'];
			
			//Allowed file types - You may specify more if you wish
			
			function isAllowedExtension($attachmentFile) 
			{
				$allowedExtensions = array("jpg","jpeg", "gif","png","lrf");
				return in_array(strtolower(pathinfo($attachmentFile, PATHINFO_EXTENSION)), $allowedExtensions);
			}
			
			if (!isAllowedExtension($_FILES['attachment_file']['name']) )
			{
				echo '<br clear="all" /><div class="info" align="left">Sorry, you attached an invalid file type. <br>We only accept jpg, jpeg, gif, png and lrf files. Thanks.</div>';
			}
			else
			{
				if($size<(1024*1024))
				{
					$headers = "From: $from";
					$headers .= "\r\nCc: $cc";
					$headers .= "\r\nBcc: $bcc";
					
					if (is_uploaded_file($attachment_file))
					{
						  // Read the file to be attached ('rb' = read binary)
						  $file = fopen($attachment_file,'rb');
						  $data = fread($file,filesize($attachment_file));
						  fclose($file);
						
						  // Generate a boundary string
						  $semi_rand = md5(time());
						  $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
						  
						  // Add the headers for a file attachment
						  $headers .= "\nMIME-Version: 1.0\n" .
									  "Content-Type: multipart/mixed;\n" .
									  " boundary=\"{$mime_boundary}\"";
						
						  // Add a multipart boundary above the plain message
						  $message = "--{$mime_boundary}\n" .
									 "Content-Type: text/html; charset=\"iso-8859-1\"\n" .
									 "Content-Transfer-Encoding: 7bit\n\n" .
									 $message_to_send . "\n\n";
						
						  // Base64 encode the file data
						  $data = chunk_split(base64_encode($data));
						
						  // Add file attachment to the message
						  $message .= "--{$mime_boundary}\n" .
									  "Content-Type: {$attachment_file_type};\n" .
									  " name=\"{$attachment_file_name}\"\n" .
									  //"Content-Disposition: attachment;\n" .
									  //" filename=\"{$attachment_file_name}\"\n" .
									  "Content-Transfer-Encoding: base64\n\n" .
									  $data . "\n\n" .
									  "--{$mime_boundary}--\n";
					}
					// Send the message
					$vasplus_mailer_delivers_greatly = @mail($to, $subject, $message, $headers);
					
					if ($vasplus_mailer_delivers_greatly) 
					 {
						 echo '<font style="font-size:0px;">vpb_sent&</font>';
						  echo "<br clear='all' /><div align='left' class='info'>Congrats, your email message has been sent successfully! Thanks.</div>";
					 } 
					 else 
					 {
						  echo "<br clear='all' /><div align='left' class='info'>Sorry, your email could not be sent at the moment. Please try again or contact this website admin to report this error message if the problem persist (1). Thanks.</div>";
					 }
				}
				else
				{
					echo "<br clear='all' /><div class='info' align='left'>File exceeded 1MB max allowed file size. <br>Please upload a file at 1MB in size to proceed. Thanks.</div>";
				}
				
			}
		}
		//Else if the user did not attach a file above, then proceed with the email sending below - (we will send a HTML type of Email instead)
		else
		  {
			  $v_year = date("Y"); //Set Year for html email sending copyright at the footer
			  
			  //Check to see the email addresses supplied for email sending
			  if(!empty($cc) && !empty($bcc))
			  {
				  $setEmailArray = array($to,$cc,$bcc,$from);
			  }
			  elseif(!empty($cc) && empty($bcc))
			  {
				  $setEmailArray = array($to,$cc,$from);
			  }
			  elseif(empty($cc) && !empty($bcc))
			  {
				  $setEmailArray = array($to,$bcc,$from);
			  }
			  else
			  {
				  $setEmailArray = array($to,$from);
			  }
			  
			  $vpb_htmlmessage = nl2br($message_to_send);
			 
for($i = 0; $i < count($setEmailArray); $i++)
{

/* BEGINNING OF HTML MESSAGE BODY */
$vpb_message_body = <<<EOF

  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
   <html xmlns="http://www.w3.org/1999/xhtml">
   <head>
   <title>vasPLUS Programming Blog Mailer</title>
   </head>
   <body>
	<table bgcolor="#FFF" align="left" cellpadding="6" cellspacing="6" width="100%" border="0">
    <tr>
    <td valign="top" colspan="2" align="left">
            
	<p align="left"><font style='font-family:Verdana, Geneva, sans-serif; font-size:12px; color:black;'>$vpb_htmlmessage</font></p><br /><br />
			
   </td>
  </tr>
  <tr>
  <td colspan="2" align="center">
  <table height="40" width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F6F6F6" style="height:30;padding:0px;border:1px solid #EAEAEA;">
  <tr>
    <td><p align='center'><font style="font-family:Verdana, Geneva, sans-serif; font-size:10px;color:black;">Copyright &copy; $v_year | All Rights Reserved.</font></p></td>
  </tr>
</table>
</td>
</tr>
</table>
      </body>
   </html>
EOF;
/* END OF HTML MESSAGE BODY */
      
     //SET UP THE EMAIL HEADERS
    $headers      = "From: <$from>\r\n";
    $headers   .= "Content-type: text/html; charset=iso-8859-1\r\n";
    $headers   .= "Message-ID: <".time().rand(1,1000)."@".$_SERVER['SERVER_NAME'].">". "\r\n";   
   
   //LETS SEND THE MESSAGE
   $vasplus_mailer_delivers_great_messages = mail($setEmailArray[$i], $subject, $vpb_message_body, $headers);
   if ($vasplus_mailer_delivers_great_messages) 
   {
	   $vpb_sent = '<font style="font-size:0px;">vpb_sent&</font>';
	   $vpb_sent_status = "<br clear='all' /><div align='left' class='info'>Congrats, your email message has been sent successfully! Thanks.</div>";
   } 
   else 
   {
	  $vpb_sent_status = "<br clear='all' /><div align='left' class='info'>Sorry, your email could not be sent at the moment. Please try again or contact this website admin to report this error message if the problem persist (2). Thanks.</div>";
   }
}
echo $vpb_sent.$vpb_sent_status;
		  }
	}
}
?>