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




//This function sends all emails
function vpb_send_email() 
{
	//Variables declaration
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	var to = 'cal.au0927@gmail.com';
	var cc = '';//$('#cc').val();
	var bcc = '';//$('#bcc').val();
	var from = 'ad.cal.au0927@gmail.com';
	var subject = 'WEBSITE (' + $('#upload nav a.selected').text() + ')';
	var message = 'Sent by: ' + $('#upload #uploadSummonerName').val();
	var attachedfile = $('#uploadFile').val();
	$("#vpb_mailer_response").html('');
	

	var dataString = "to=" + to + "&cc=" + cc + "&bcc=" + bcc + "&from=" + from + "&subject=" + subject + "&message=" + message + "&attachedfile=" + attachedfile;

	$("#vasPLUS_Programming_Blog_Form").vPB({
		url: 'http://localhost:1234/RM/index.php/mail/?' + dataString,
		beforeSubmit: function() 
		{
			$("#vpb_mailer_response").html('');
			toggleUploadLoading(true);
		},
		success: function(response) 
		{
			var response_brought = response.indexOf('vpb_sent');
			if (response_brought != -1) 
			{
				// Sent properly
				$('#to').val('');
				$('#cc').val('');
				$('#bcc').val('');
				$('#from').val('');
				$('#subject').val('');
				$('#message').val('');
				$("#vpb_mailer_response").css('color', 'green').hide().fadeIn('fast').html(response);
			}
			else
			{
				// Sent with errors?
				$("#vpb_mailer_response").css('color', 'red').hide().fadeIn('fast').html(response);
			}
			toggleUploadLoading(false);
		}
	}).submit();
}