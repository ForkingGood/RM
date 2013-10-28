<style>
	article .bg {
		position: absolute;
		top: 0;
		left: 0;
		height: 100%;
		width: 100%;
		background-color: black;
		opacity: 0.7;
		border-radius: 7px;
		z-index: -1;
	}
	article.tShirtJoinUs h2 {
		float: left;
	}
	article.tShirtJoinUs a {
		float: right;
		background-color: #133AAC;
		padding: 5px 10px;
		border-radius: 7px;
		border: 1px outset #133AAC;
		color: white;
		text-decoration: none;
	}
	article.tShirtJoinUs a:hover {
		color: #03899C;
	}
	article div.announcements {
		border: 1px solid gray;
		padding: 5px;
		background-color: black;
		margin: 0 0 10px 0;

	}
		article div.announcements h2 {
			font-family: SlicedAB;
			float: left;
		}
		article div.announcements p {
			font-size: 10pt;
			clear: both;
		}
		article div.announcements div.info {
			margin: 3px 5px;
			color: gray;
			letter-spacing: 2px;
			font-size: 12pt;
			float: right;
		}
	#tShirtSlider li {
		position: relative;
		width: 200px;
	}
	#tShirtSlider li div.mb-inside {
		position: relative;
		background-color: #740000;
	}
	#tShirtSlider li img {
		position: relative;
		width: 100%;
		opacity: 1;
		z-index: 2;
		transition: opacity 1s;
		-webkit-transition: opacity 1s;
	}
	#tShirtSlider li img:hover {
		opacity: 0.2;
	}
	#tShirtSlider h2 {
		width: 100%;
		color: white;
  		font-family: SlicedAB;
	}
	#tShirtSlider p {
		position: absolute;
		top: 0;
		left: 0;
		margin: 15px 15px 45px 15px;
		color: white;
		font-size: 10pt;
	}
</style>

<link href="<?php echo base_url(); ?>asset/css/movingboxes.css" rel="stylesheet">
<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/jquery.movingboxes.min.js"></script>
<script>
	$(function(){

		$('#tShirtSlider').movingBoxes({
			/* width and panelWidth options deprecated, but still work to keep the plugin backwards compatible
			width: 500,
			panelWidth: 0.5,
			*/
			startPanel   : 1,      // start with this panel
			wrap         : true,  // if true, the panel will infinitely loop
			buildNav     : true,   // if true, navigation links will be added
			navFormatter : function(){ return "&#9679;"; } // function which returns the navigation text for each panel
		});

		$('.btnSubmitTShirt').click(function() {
			toggleUploadView('T-Shirt');
			toggleUpload(true);
		});
	});
</script>
<br />

<article class="tShirtGallery">
	<h1>T-Shirt FrenZy!</h1>
	<ul id="tShirtSlider">

			<li>
				<img src="http://localhost:1234/RM/asset/img/T-shirts/1.jpg" alt="picture">
				<h2>p4ndajai</h2>
				<p>This is some description which I would like to talk about with you while i'm here and alive.  This is my description homies and you better read it everytime you are on the page.</p>
			</li>
			<li>
				<img src="http://localhost:1234/RM/asset/img/T-shirts/2.jpg" alt="picture">
				<h2>p4ndajai</h2>
				<p>This is some description which I would like to talk about with you while i'm here and alive.  This is my description homies and you better read it everytime you are on the page.</p>
			</li>
			<li>
				<img src="http://localhost:1234/RM/asset/img/T-shirts/3.jpg" alt="picture">
				<h2>p4ndajai</h2>
				<p>This is some description which I would like to talk about with you while i'm here and alive.  This is my description homies and you better read it everytime you are on the page.</p>
			</li>
			<li>
				<img src="http://localhost:1234/RM/asset/img/T-shirts/4.jpg" alt="picture">
				<h2>p4ndajai</h2>
				<p>This is some description which I would like to talk about with you while i'm here and alive.  This is my description homies and you better read it everytime you are on the page.</p>
			</li>
			<li>
				<img src="http://localhost:1234/RM/asset/img/T-shirts/5.jpg" alt="picture">
				<h2>p4ndajai</h2>
				<p>This is some description which I would like to talk about with you while i'm here and alive.  This is my description homies and you better read it everytime you are on the page.</p>
			</li>
			<li>
				<img src="http://localhost:1234/RM/asset/img/T-shirts/6.jpg" alt="picture">
				<h2>p4ndajai</h2>
				<p>This is some description which I would like to talk about with you while i'm here and alive.  This is my description homies and you better read it everytime you are on the page.</p>
			</li>
			<li>
				<img src="http://localhost:1234/RM/asset/img/T-shirts/7.jpg" alt="picture">
				<h2>p4ndajai</h2>
				<p>This is some description which I would like to talk about with you while i'm here and alive.  This is my description homies and you better read it everytime you are on the page.</p>
			</li>
			<li>
				<img src="http://localhost:1234/RM/asset/img/T-shirts/8.jpg" alt="picture">
				<h2>p4ndajai</h2>
				<p>This is some description which I would like to talk about with you while i'm here and alive.  This is my description homies and you better read it everytime you are on the page.</p>
			</li>
			<li>
				<img src="http://localhost:1234/RM/asset/img/T-shirts/9.jpg" alt="picture">
				<h2>p4ndajai</h2>
				<p>This is some description which I would like to talk about with you while i'm here and alive.  This is my description homies and you better read it everytime you are on the page.</p>
			</li>
			<li>
				<img src="http://localhost:1234/RM/asset/img/T-shirts/10.jpg" alt="picture">
				<h2>p4ndajai</h2>
				<p>This is some description which I would like to talk about with you while i'm here and alive.  This is my description homies and you better read it everytime you are on the page.</p>
			</li>
			<li>
				<img src="http://localhost:1234/RM/asset/img/T-shirts/11.jpg" alt="picture">
				<h2>p4ndajai</h2>
				<p>This is some description which I would like to talk about with you while i'm here and alive.  This is my description homies and you better read it everytime you are on the page.</p>
			</li>
			<li>
				<img src="http://localhost:1234/RM/asset/img/T-shirts/12.jpg" alt="picture">
				<h2>p4ndajai</h2>
				<p>This is some description which I would like to talk about with you while i'm here and alive.  This is my description homies and you better read it everytime you are on the page.</p>
			</li>
		</ul>
	<div class="bg"></div>
</article>
<article class="tShirtJoinUs">
	<h2 style="font-family: SlicedAB">Come and be part of our big t-shirt family!</h2>
	<a href="#" class="btnSubmitTShirt">Submit T-Shirt</a>
	<div style="clear: both;"></div>
	<div class="bg"></div>
</article>