<style>
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
	});
</script>

<article class="tShirtGallery">
	<h1>T-Shirt FrenZy!</h1>
	<ul id="tShirtSlider">
<?php
	foreach ($query as $row) {
		// if ($row->showTShirt) {
			echo "<li>".
				 	"<img src='".base_url()."asset/uploads/T-shirts/".$row->imgPath."' alt='T-shirt Pictures from fan \"".$row->summonerName."\"' />".
				 	"<h2>".$row->summonerName."</h2>".
				 	"<p>".$row->description."</p>".
				 "</li>";
		// }
	}
?>
		</ul>
	<div class="bg"></div>
</article>