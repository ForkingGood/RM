<style>
	#showIntro {
		font-family: SlicedAB;
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		z-index: 9999;
	}
	#showIntro .overlay {
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background-color: black;
		opacity: 0.7;
		z-index: -1;
		display: none;
	}

	#showIntro .instructions {
		position: absolute;
		font-family: arial;
		font-size: 15pt;
		color: white;
		cursor: default;
		display: none;
	}

	#showIntro .instructions.step3 {
		width: 300px;
		right: -17px;
		top: 33px;
	}
	#showIntro .instructions.step3 img {
		margin: 0 0 0 160px;
	}

	#showIntro .instructions.step1 {
		width: 700px;
		left: 350px;
		top: 40px;
	}

	#showIntro .instructions.step1 img {
		margin: 0 20px -14px 0;
	}

	#showIntro .instructions.step2 {
		width: 300px;
		left: 650px;
		top: 90px;
	}
	#showIntro .instructions.step2 img {
		margin: 0 0 0 30px;
	}

	#showIntro .gotIt {
		position: absolute;
		bottom: 10px;
		right: 100px;
		color: white;
		font-size: 80pt;
		cursor: pointer;
		display: none;
	}
		#showIntro .gotIt:hover {
			color: red;
		}
		#showIntro .gotIt h1 {
			font-weight: 100;
		}
</style>

<script>
	$(function() {
		if ($.cookie('firstTime') == 'false') {
			$('#showIntro').remove();
		} else {
			$('#showIntro .overlay').fadeIn(300);
			var everythingLoaded = false;

			toggleUpload(true, null, function() { 
				$('#showIntro .instructions.step3').fadeIn(1000);
			});
			toggleLeftBar(true, null, function() { 
				$('#showIntro .instructions.step1').fadeIn(1000);
			});
			toggleOptions(true, null, function() { 
				$('#showIntro .instructions.step2').fadeIn(1000, function() {
					$('#showIntro .gotIt').fadeIn();
					everythingLoaded = true;
				});
			});
		}
		
			


		$('#showIntro').click(function() {
			if (everythingLoaded) {
				$(this).fadeOut(1000, function() { 
					$(this).remove();
				});
				toggleUpload(false, 1500);
				toggleLeftBar(false, 1500);
			} else {
				toggleUpload(true, 0);
				toggleLeftBar(true, 0);
				toggleOptions(true, 0);
				$('#showIntro .instructions.step1').fadeIn(0);
				$('#showIntro .instructions.step2').fadeIn(0);
				$('#showIntro .instructions.step3').fadeIn(0);
				$('#showIntro .gotIt').fadeIn(0);
				everythingLoaded = true;
			}
		});
		$.cookie('firstTime', false, { expires: 365, path: '/' });
	});
</script>

<div id="showIntro">
	<div class="overlay"></div>

	<div class="instructions step1">
		<img src="<?php echo base_url(); ?>asset/img/arrow2.png" />
		Toggle to view my videos
	</div>

	<div class="instructions step2">
		<img src="<?php echo base_url(); ?>asset/img/arrow1.png" /><br />
		Filter option can help you narrow down your search by playlist and search words
	</div>

	<div class="instructions step3">
		<img src="<?php echo base_url(); ?>asset/img/arrow1.png" /><br />
		Use this to submit any T-shirt pictures, videos, or suggestions
	</div>
	<div class="gotIt">
		<h1>Alright, I got it >></h1>
	</div>
</div>