<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/amazingSlider.js"></script>

<article class='noWrapper' style="margin-top: -5px;">
	<div id="amazingSlider">
		<ul class="amazingslider-slides" style="display: none;">
            <li><img src="asset/img/amazingSlider/1.jpg" alt="Tulip and Sky"></li>
            <li><img src="asset/img/amazingSlider/2.jpg" alt="Swan"></li>
            <li><img src="asset/img/amazingSlider/3.jpg" alt="Big Buck Bunny">
                <video preload="none" src="http://www.youtube.com/embed/YE7VzlLtp-4"></video>
            </li>
            <li><img src="asset/img/amazingSlider/4.jpg" alt="Elephants Dream">
                <video preload="none" src="http://www.youtube.com/embed/TLkA0RELQ1g"></video>
            </li>
            <li><img src="asset/img/amazingSlider/5.jpg" alt="Forest"></li>
        </ul>
	</div>
</article>
<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/initSlider.js"></script>


<br clear="all">
<br />

<style>
	article.submission article {
		cursor: pointer;
		border: 2px solid #510000;
		background-color: #050000;
		transition: box-shadow 0.3s;
	}
	article.submission article:hover {
		box-shadow: 0 0 40px #510000;
		/*background-color: #510000;*/
	}
	article.submission img {
		width: 100%;
		height: 100px;
	}
	article.submission p {
		font-family: SlicedAB;
	}
</style>

<script>
	$(function() {
		$('article.submission article').click(function() {
			toggleUploadView($(this).attr('name'));
			toggleUpload(true);
		});
	});
</script>

<article class="submission">
	<h1>Submission</h1>
	<article class="oneColumn" name="Video">
		Video
		<img src="" />
		<p>Some description about uploading the video to help them in a way even though it is actually helping yourself!</p>
		<div class="bg"></div>
	</article>
	<article class="oneColumn" name="T-Shirt">
		T-shirt
		<img src="" />
		<p>T-shirt is always good! Gimme some! We post good pic up! ye! INSTANT NOODLE FTW!</p>
		<div class="bg"></div>
	</article>
	<article class="oneColumn endColumn" name="Feedback">
		Feedback
		<img src="" />
		<p>I'm here, i'm active, I'm willing to talk to my viewers, fans, whatever you call urself.  So please, Act like you care!</p>
		<div class="bg"></div>
	</article>
	<br clear="all">
	<div class="bg"></div>
</article>
<br />


<article>
	<h1>Recent Videos</h1>
	<?=$recentVideo?>
	<div class="bg"></div>
</article>
<br />

<article class='tshirt halfColumn'>
	<?=$tshirt?>
	<div class='bg'></div>
</article>

<article class='announcement noWrapper halfColumn endColumn'>
	<?=$announcement?>
</article>
<br clear="all">