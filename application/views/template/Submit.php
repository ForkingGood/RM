<link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/submit.css" />

<script>
	$(function() {
		$('.btnUpload').click(function(e) {
			e.preventDefault();
			toggleUpload();
		});

		$('#upload .time').keypress(function(e) {
			var theEvent = e || window.event;
			var key = theEvent.keyCode || theEvent.which;
			key = String.fromCharCode( key );
			var regex = /[0-9]|\./;
			if( !regex.test(key) ) {
			    theEvent.returnValue = false;
			    if(theEvent.preventDefault) theEvent.preventDefault();
			}
		});

		$('#upload nav a').click(function(e) {
			e.preventDefault();
			toggleUploadView($(this).text());
		});

		toggleUploadView('T-Shirt');
	});

	function toggleUploadView(type) {
		//	select correct tab in menu
		$('#upload nav a').removeClass('selected');
		$('#upload nav a:contains("' + type + '")').addClass('selected');

		//	Store in form
		$('input[name="uploadSubmissionType"]').val(type);

		//	Remove unwanted fields, and display wanted ones
		$('#upload .formField:not(.' + type + ')').fadeOut(500);
		$('#upload .formField.' + type).fadeIn(500);
	}

	function toggleUpload(state, speed, callback) {
		var openUpload = state != null ? state : !$('.btnUpload').hasClass('selected');
		speed = speed != null ? speed : 500;
		if (openUpload) {
			$('.btnUpload').addClass('selected');
			$('#upload').show(speed, callback);
		} else {
			$('#upload').hide(speed, function() {
				$('.btnUpload').removeClass('selected');
				callback;
			});
		}
	}

	function toggleUploadLoading(state) {

		var showLoading = state != null ? state : $('div.uploadLoading, div.uploadOverlay').css('display') == 'none';

		if (showLoading) {
			$('div.uploadLoading, div.uploadOverlay').slideDown(300);
		} else {
			$('div.uploadLoading, div.uploadOverlay').slideUp('slow');
		}
	}
</script>

<style>
	#upload nav {
		text-align: center;
	}
	#upload nav a {
		position: relative;
		padding: 4px 9px;
		background-color: #08088A;
		color: white;
		margin: -10px 0px 0 15px;
		font-size: 15pt;
		text-decoration: none;
	}
	#upload nav a:before {
		position: absolute;
		content:' ';
		top: 0;
		left: -25px;
		width: 0;
		height: 0;
		border-top: 23px solid #08088A;
		border-left: 25px solid transparent;
	}
	#upload nav a:after {
		position: absolute;
		content:' ';
		top: 0;
		right: -25px;
		width: 0;
		height: 0;
		border-top: 23px solid #08088A;
		border-right: 25px solid transparent;
	}
	#upload nav a.selected {
		z-index: 10;
		background-color: red;
		text-decoration: underline;
	}
	#upload nav a.selected:before, #upload nav a.selected:after {
		z-index: 10;
		border-top-color: red;
	}
</style>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>asset/js/file_uploads.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>asset/js/vpb_email_sender.js"></script>

<div id="upload">
	<nav>
		<a href="#">Video</a>
		<a href="#" class="selected">T-Shirt</a>
		<a href="#">Feedback</a>
	</nav>
	<div id="vpb_mailer_response"></div>
	<br /><br />
	<form id="vasPLUS_Programming_Blog_Form" method="post" action="javascript:void(0);" enctype="multipart/form-data" autocomplete="off">
		<input type="hidden" name="uploadSubmissionType" />
		<label for="uploadFile" class="formField Video T-Shirt"><b>File</b><br /></label>
		<input id="uploadFile" name="attachment_file" class="formField Video T-Shirt" type="file" accept="image/*, .lrf" />
		<label for="uploadTitle" class="formField Video Feedback"><br /><b>Title</b><br /></label>
		<input id="uploadTitle" name="uploadTitle" class="formField Video Feedback" type="text" />
		<label for="uploadSeries" class="formField Video"><br /><b>Series</b><br /></label>
		<input id="uploadSeries" name="uploadSeries" class="formField Video" type="text" />
		<label for="uploadType" class="formField Feedback"><br /><br /><b>Type</b></label>
		<select id="uploadType" name="uploadType" class="formField Feedback">
			<option>Idea</option>
			<option>Complaint</option>
			<option>Appraise</option>
		</select>
		<label for="uploadDescription" class="formField Video T-Shirt Feedback"><br /><b>Description</b><br /></label>
		<textarea id="uploadDescription" name="uploadDescription" class="formField Video T-Shirt Feedback"></textarea>
		<label for="uploadSummonerName" class="formField Video T-Shirt Feedback"><br /><b>Summoner Name</b><br /></label>
		<input id="uploadSummonerName" name="uploadSummonerName" class="formField Video T-Shirt Feedback" type="text" />

		<table class="formField Video">
			<tr>
				<td>
					<label for="uploadStartTimeMin"><b>Start Time</b></label>
				</td>
				<td>

				</td>
				<td>
					<label for="uploadEndTimeMin"><b>End Time</b></label>
				</td>
			</tr>
			<tr>
				<td>
					<input id="uploadStartTimeMin" name="uploadStartTimeMin" class="time" type="text" /><b> :</b>
					<input id="uploadStartTimeSec" name="uploadStartTimeSec" type="text" max="59" class="time" />
				</td>
				<td style="width: 50px;">
					-
				</td>
				<td>
					<input id="uploadEndTimeMin" name="uploadEndTimeMin" class="time" type="text" /><b> :</b>
					<input id="uploadEndTimeSec" name="uploadEndTimeSec" type="text" max="59" class="time" />
				</td>
			</tr>
		</table>
		<br />
		<br />
		<input type="hidden" name="submitted" id="submitted" value="1" />
		<input type="submit" class="vpb_general_button btnSendUpload" value="Send" onclick="vpb_send_email();">
	</form>
	<div class="uploadOverlay"></div>
	<div class="uploadLoading">
		<div class="text"><h1>Please Wait...</h1>while we process your submission</div>
		<img src="<?php echo base_url(); ?>asset/img/loading.gif" />
	</div>
</div>
