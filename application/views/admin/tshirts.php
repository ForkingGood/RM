<style>
	.tShirtPosts {
		position: relative;
		width: 30%;
		float: left;
		margin: 8px 0 8px 2%;
		border: 2px solid gray;
		min-height: 100px;
		color: white;
		background-color: #141414;
	}
	.tShirtPosts.show {
		background-color: #008400;
		border: 2px outset #008400;
		box-shadow: 0 0 30px #008400;
	}
	.tShirtPosts.notViewed {
		border: 2px solid red;
		box-shadow: 0 0 30px #4B0200;
	}
		.tShirtPosts img {
			float: left; 
			max-height: 200px;
			max-width: 100px;
			margin-right: 5px;
		}
		.tShirtPosts h1 {
			margin: 5px;
			font-size: 16pt;
		}
		.tShirtPosts p {
			font-size: 10pt;
		}
		.tShirtPosts .close {
			position: absolute;
			top: -20px;
			right: -20px;
			background-color: #840000;
			padding: 6px 10px;
			border-radius:50%;
			text-decoration: none;
			color: white;
			font-size: 12pt;
			border: 8px solid black;
		}
		.tShirtPosts .overlay {
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
		}
</style>

<script type="text/javascript" src="<?=base_url()?>asset/js/jquery-1.7.1.min.js"></script>

<script>
	$(function() {
		$('div.tShirtPosts .overlay').dblclick(function() {
			var box = $(this).parent();
			$.ajax({
				type: "POST",
				url: "<?=base_url()?>TShirt/ToggleShow/" + $(this).parent().attr('key')
				// data: { state: box.hasClass('show') }
			})
			.done(function(msg) {
				msg == 'show' ? box.addClass(msg) : box.removeClass('show');
			});
		});
		$('div.tShirtPosts .close').click(function(e) {
			e.preventDefault();

			var box = $(this).parent();
			$('.PopBox.confirmDelete input.id').val(box.attr('key'));
			$('.PopBox.confirmDelete p').text('Are you sure you want to delete post by "' + box.children('h1.summonerName').text() + '"?');
			$('.PopBox.confirmDelete input[type="button"].delete').focus();
		});
		$('.PopBox.confirmDelete input[type="button"].delete').click(function() {
			var id = $(this).parent().children('input.id').val();
			$.ajax({
				url: "<?=base_url()?>TShirt/Delete/" + id
			})
			.done(function(msg) {
				$('div.tShirtPosts[key="' + id + '"]').fadeOut(1000, function() { $('div.tShirtPosts[key="' + id + '"]').remove(); });
				closePopBox();
			});
		});

		$('div.tShirtPosts.notViewed').click(function() {

			// Get id, set as read
			var box = $(this);
			$.ajax({
				type: "POST",
				url: "<?=base_url()?>TShirt/ToggleViewed/" + box.attr('key')
				// data: { state: true }
			})
			.done(function(msg) {
				if (msg == 'done') box.removeClass('notViewed');
			});
		});
	});
</script>
<br />
<?php
	foreach ($query as $row) {
		echo "<div class='tShirtPosts".($row->showTShirt ? ' show' : '').($row->viewed ? '' : ' notViewed')."' key='".$row->id."'>".
				"<div class='overlay'></div>".
				"<img src='".base_url()."asset/uploads/t-shirts/".$row->imgPath."' />".
				"<h1 unselectable='on' class='summonerName'>".$row->summonerName."</h1>".
				"<p unselectable='on'>".$row->description."</p>".
				"<a href='#' class='close PopIt' name='confirmDelete'>x</a>".
			 "</div>";
	}
?>
<br clear="all">

<div class="PopBox confirmDelete">
	<input type="hidden" class="id" />
	<p></p>
	<input type="button" value="Delete" class="delete" />
	<input type="button" value="Cancel" class="cancel" />
</div>