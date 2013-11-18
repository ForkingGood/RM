<!DocType HTML>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- needed for mobile devices -->
	<!-- CORE ITEMS -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/reset.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/main.css" />
	<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/jquery.cookie.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/jquery-ui-1.10.3.custom.min.js"></script>

	<!-- Pop box -->
	<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/PopBox.js"></script>
	<link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/Popbox.css" />

	<!-- Montage -->
	<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/jquery.montage.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/jquery.montage.css" />

	<!-- Auto Grid -->
	<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/autoGrid.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/autoGrid.css" />
	<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/rotate-patch.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/waypoints.min.js"></script>

	<!-- Slim Scroll -->
	<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/jquery.slimscroll.min.js"></script>
</head>
<body>
	<img class="mainBG" src="<?php echo base_url(); ?>asset/img/page-bg.jpg" />
	<header>
		<div class="title">
			<a href="<?=base_url()?>">REDMERCY</a> 
			<?php if (isset($login['username'])) { ?> <a href="<?=base_url()?>Admin/" class="dashboard">DASHBOARD</a> <?php } ?>
		</div>

		<div class="RMnav">
			<?php if (isset($login['username'])) { ?>
			<div style="float: left; margin: -10px 20px 0 0; color: #181818; font-size: 17pt; font-weight: 700;">
				<?=$login['username']?> (<a href="<?=base_url()?>Admin/Logout" style="font-size: 10pt; float: none; display: inline-block; padding: 0 2px 0 5px; position: relative; top: -2px;">Logout</a>)
			</div>
			<?php } ?>

			<div class="socialLinks">
				<a href="https://twitter.com/RedmercyLoL" target="_blank"><div class="twitter"></div><p>Twitter</p></a>
				<a href="https://www.facebook.com/RedmercyLoL" target="_blank"><div class="facebook"></div><p>Facebook</p></a>
				<a href="https://plus.google.com/108349012594556038005/posts" target="_blank"><div class="googlePlus"></div><p>Google+</p></a>
				<a href="http://www.youtube.com/user/Redmercy" target="_blank"><div class="youtube"></div><p>Youtube</p></a>
				<a href="http://www.youtube.com/user/Redmercy" target="_blank"><div class="twitch"><img src="<?=base_url()?>asset/img/twitch_icon.png" style="width: 100%; height: 100%;" /></div><p>Twitch</p></a>
			</div>
			<?=$menu?>
		</div>
		<div style="clear: both;"></div>
	</header>
	<section class="mainContent">
		<?=$content?>
	</section>
	<footer>
		<div class="center">
			<div class="halfColumn">
				<h1>Sponsors / Partners</h1>
				<div class="oneColumn sponsors">
					<img src="<?=base_url()?>asset/img/sponsors/razor.jpg" style="margin-top: 45px;" />
				</div>
				<div class="oneColumn">
					<img src="<?=base_url()?>asset/img/sponsors/machinima.jpg" style="width: 58%;" />
				</div>
				<div class="oneColumn endColumn">
					<img src="<?=base_url()?>asset/img/sponsors/youtube.png" style="margin: 47px 0 0 -22px; width: 70%;" />

				</div>
			</div>
			<div class="halfColumn endColumn">
				<div class="halfColumn">
					<div class="halfColumn sitemap">
						<h1>Sitemap</h1>
						<a href="#">Home</a>
						<a href="#">About</a>
						<a href="#">Store</a>
						<a href="#">Contact</a>
						<a href="#">Submit</a>
					</div>
					<div class="halfColumn endColumn social">
						<h1>Social</h1>
						<a href="#">Twitter</a>
						<a href="#">Facebook</a>
						<a href="#">Google+</a>
						<a href="#">Youtube</a>
						<a href="#">Twitch</a>
					</div>
				</div>
				<div class="halfColumn endColumn">
					<h1>Mission</h1>
					<p>Some kind of mission statement if you really dont' have anything to put in this little spot, because it makes you sound determined to deliver what you promise your viewers you would deliver, and to the best! Thank you!
				</div>
			</div>
			<br clear='all'>
			<div style="text-align: right; border-top: 1px solid #510000;">
				©2013 Redmercy Entertainment, Inc. All rights reserved.
			</div>
		</div>
	</footer>
</body>
</html>