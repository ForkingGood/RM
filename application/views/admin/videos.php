<style>
	table.vidTable {
		margin:0 auto;
		background-color: black;
		color: white;
		border-radius: 7px;
		border-spacing: 0;
		overflow: hidden;
	}
		table.vidTable tr {
			color: white; /* #515151; */
		}

		table.vidTable tr:hover {
			color: white;
		}
		table.vidTable tr.notViewed {
			background-color: #095E00;
		}
		table.vidTable th {
			font-family: SlicedAB;
			font-size: 20pt;
			font-weight: 100;
			background-color: #690500;
			padding: 5px 20px;
			color: white;
			cursor: default;
		}
		table.vidTable td {
			padding: 10px;
			max-width: 400px;
			vertical-align: top;
			text-align: center;
		}
			table.vidTable td a.download {
				padding: 2px 10px;
				background-color: #008400;
				color: white;
				text-decoration: none;
				border-radius: 3px;
				outline: none;
				border: 1px outset #00b700;
				font-size: 10pt;
			}
			table.vidTable td a.download:active {
				border: 1px inset #00b700;
			}
			table.vidTable td a.delete {
				padding: 2px 10px;
				background-color: #840000;
				color: white;
				text-decoration: none;
				border-radius: 3px;
				outline: none;
				border: 1px outset #B70000;
				font-size: 10pt;

			}
			table.vidTable td a.delete:active {
				border: 1px inset #B70000;
			}
</style>

<script>
	$(function() {
		$('table.vidTable tr').click(function(e) {
            e.preventDefault();
			if($(e.target).is('a')){
	            return;
	        }
			// Get id, set as read
			var row = $(this);
			$.ajax({
				type: "POST",
				url: "<?=base_url()?>Video/ToggleViewed/" + row.attr('key')
				// data: { state: true }
			})
			.done(function(msg) {
				if (msg == 'notViewed')
					row.addClass('notViewed');
				else
					row.removeClass('notViewed');
			});
		});

		$('table.vidTable tr td a.delete').click(function(e) {
			e.preventDefault();
			var row = $(this).parent().parent();

			$('.PopBox.confirmDelete input.id').val(row.attr('key'));
			$('.PopBox.confirmDelete p').text('Are you sure you want to delete post "' + row.children('td.title').text() + '"?');
			$('.PopBox.confirmDelete input[type="button"].delete').focus();

		});
		$('.PopBox.confirmDelete input[type="button"].delete').click(function() {
			var id = $(this).parent().children('input.id').val();
			$.ajax({
				url: "<?=base_url()?>Video/Delete/" + id
			})
			.done(function(msg) {
				$('tr[key="' + id + '"]').fadeOut(1000, function() { $('tr[key="' + id + '"]').remove(); });
				closePopBox();
			});
		});
	});
</script>

<br />
<section class="mainContent">
	<table class="vidTable">
	<?php if (count($query) > 0) { ?>
		<tr>
			<th>ID</th>
			<th>Date Created</th>
			<th>Title</th>
			<th>Series</th>
			<th style='max-width: 200px;'>Description</th>
			<th>Summoner Name</th>
			<th>Start Time</th>
			<th>End Time</th>
			<th>Link</th>
			<th>Delete</th>
		</tr>
	<?php } ?>
	<?php
		foreach ($query as $row) {
			echo "<tr key='".$row->id."' class='".($row->viewed ? "" : "notViewed")."'>".
					"<td>".$row->id."</td>".
				 	"<td>".date_format(new datetime($row->dateCreated), 'M d, Y <\i>h:ia</\i>')."</td>".
				 	"<td class='title'>".$row->title."</td>".
				 	"<td>".$row->series."</td>".
				 	"<td style='font-size: 10pt; text-align: left;'>".$row->description."</td>".
				 	"<td>".$row->summonerName."</td>".
				 	"<td>".$row->startTime."</td>".
				 	"<td>".$row->endTime."</td>".
				 	"<td><a href='".base_url()."asset/uploads/Videos/".$row->vidPath."' class='download' download>Download</a></td>".
				 	"<td><a href='#' class='delete PopIt' name='confirmDelete'>Delete</a></td>".
				 "</tr>";
		}
	?>
	</table>
</section>

<div class="PopBox confirmDelete">
	<input type="hidden" class="id" />
	<p></p>
	<input type="button" value="Delete" class="delete" />
	<input type="button" value="Cancel" class="cancel" />
</div>