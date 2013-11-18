<style>
article div.announcements {
	border: 2px dotted #840000;
	padding: 5px;
	background-color: black;
	margin: 0 0 10px 0;
}
	article div.announcements:hover {
		border-style: solid;
		box-shadow: 0 0 40px #510000;
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
		article div.announcements div.info i {
			font-size: 9pt;
		}
</style>

<article>
	<h1>Announcements</h1>
	<?php
		foreach ($query as $row) {
			echo "<div class='announcements'>".
					"<h2>".$row->title."</h2>".
					"<div class='info'>".date_format(new datetime($row->dateCreated), 'M d, Y').' <i>'.date_format(new datetime($row->dateCreated), 'h:ia')."</i></div>".
					"<p>".$row->description."</p>".
				 "</div>";

		}
	?>

	<div class="bg"></div>
</article>