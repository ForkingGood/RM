<style>
	div.feedbackPosts {
		margin: 10px auto;
		width: 1000px;
		background-color: black;
		color: #D2D2D2;
	}
	div.feedbackPosts.notViewed {
		color: white;
	}
		div.feedbackPosts h1 {
			position: relative;
			background-color: #840000;
			font-family: SlicedAB;
			padding: 5px 10px;
			color: white;
		}
		div.feedbackPosts h1.Idea {
			background-color: #033800;
		}
		div.feedbackPosts h1.Idea.notViewed {
			background-color: #088400;
		}
		div.feedbackPosts h1.Complaint {
			background-color: #850000;
		}
		div.feedbackPosts h1.Complaint.notViewed {
			background-color: #d10000;
		}
		div.feedbackPosts h1.Appraise {
			background-color: #003838;
		}
		div.feedbackPosts h1.Appraise.notViewed {
			background-color: #008484;
		}
			div.feedbackPosts h1 font.timeStamp {
				float: right;
				font-size: 17pt;
				margin-top: 10px;
			}
			div.feedbackPosts h1 a.delete {
				position: absolute;
				top: 0;
				right: -40px;
				background-color: #840000;
				color: white;
				padding: 5px 10px;
				text-decoration: none;
			}
			div.feedbackPosts h1 a.delete:hover {
				background-color: #ab0000;
				text-decoration: underline;
			}
			div.feedbackPosts h1 div.overlay {
				position: absolute;
				top: 0;
				left: 0;
				width: 100%;
				height: 100%;
			}
		div.feedbackPosts p {
			padding: 10px 10px 0 10px;
			font-size: 12pt;
		}
		div.feedbackPosts p.summonerName {
			margin: 0 30px;
			padding-bottom: 10px;
			text-align: right;
		}
</style>

<script>
	$(function() {
		$('div.feedbackPosts h1.notViewed').dblclick(function() {
			var box = $(this).parent();
			var bar = $(this);
			$.ajax({
				type: "POST",
				url: "<?=base_url()?>Feedback/ToggleViewed/" + box.attr('key')
				// data: { state: box.hasClass('show') }
			})
			.done(function(msg) {
				if (msg == 'done') bar.removeClass('notViewed');
			});
		});
		$('div.feedbackPosts h1 a.delete').click(function(e) {
			e.preventDefault();
			var box = $(this).parent().parent();
			$('.PopBox.confirmDelete input.id').val(box.attr('key'));
			$('.PopBox.confirmDelete p').text('Are you sure you want to delete post "' + box.children('h1').children('font.title').text() + '"?');
			$('.PopBox.confirmDelete input[type="button"].delete').focus();
		});
		$('.PopBox.confirmDelete input[type="button"].delete').click(function() {
			var id = $(this).parent().children('input.id').val();
			$.ajax({
				url: "<?=base_url()?>Feedback/Delete/" + id
			})
			.done(function(msg) {
				$('div.feedbackPosts[key="' + id + '"]').fadeOut(1000, function() { $('div.feedbackPosts[key="' + id + '"]').remove(); });
				closePopBox();
			});
		});
	});
</script>

<br />

<?php
	foreach ($query as $row) {
		echo "<div class='feedbackPosts' key='".$row->id."'>".
				"<h1 class='".$row->type.($row->viewed ? '' : ' notViewed')."'><font class='title'>".$row->title."</font>".
					"<font class='timeStamp'>".$row->dateCreated."</font>".
					"<a href='#' class='delete PopIt' name='confirmDelete'>X</a>".
					"<div class='overlay'></div>".
				"</h1>".
				"<p>".$row->description."</p>".
				"<p class='summonerName'>".$row->summonerName."</p>".
			 "</div>";
	}
?>

<div class="PopBox confirmDelete">
	<input type="hidden" class="id" />
	<p></p>
	<input type="button" value="Delete" class="delete" />
	<input type="button" value="Cancel" class="cancel" />
</div>