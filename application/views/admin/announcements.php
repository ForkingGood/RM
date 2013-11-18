

<style>
div.announcements {
	position: relative;
	border: 1px solid gray;
	padding: 5px;
	background-color: black;
	margin: 10px auto;
	color: white;
	width: 900px;
	min-height: 64px;
}
div.announcements h2 {
	font-family: SlicedAB;
	float: left;
}
div.announcements p {
	font-size: 10pt;
	clear: both;
}
div.announcements div.info {
	margin: 3px 5px;
	color: gray;
	letter-spacing: 2px;
	font-size: 12pt;
	float: right;
}
div.announcements a.edit {
	position: absolute;
	top: 0;
	right: -33px;
	background-color: #008400;
	padding: 5px 10px;
	border-radius: 0 7px 7px 0;
	color: white;
	text-decoration: none;
	font-size: 15pt;
}
div.announcements a.delete {
	position: absolute;
	top: 40px;
	right: -33px;
	background-color: #B70000;
	padding: 5px 10px 5px 7px;
	border-radius: 0 7px 7px 0;
	color: white;
	text-decoration: none;
	font-size: 15pt;
}

a.openAdd {
	text-decoration: none;
	color: white;
	background-color: blue;
	padding: 5px 15px;

	transition: padding-left 0.5s;
	-webkit-transition: padding-left 0.5s; /* Safari */
}
a.openAdd:hover {
	padding-left: 30px;
}
</style>

<script>
$(function() {
	$('div.announcements a.delete').click(function(e) {
		e.preventDefault();
		$('.PopBox.confirmDelete input.id').val($(this).parent().attr('key'));
		$('.PopBox.confirmDelete p').text('Are you sure you want to delete post "' + $(this).parent().children('h2.title').text() + '"?');
		$('.PopBox.confirmDelete input[type="button"].delete').focus();
	});
	$('.PopBox.confirmDelete input[type="button"].delete').click(function() {
		var id = $(this).parent().children('input.id').val();
		$.ajax({
			url: "<?=base_url()?>Announcement/Delete/" + id
		})
		.done(function(msg) {
			$('div.announcements[key="' + id + '"]').fadeOut(1000, function() { $('div.announcements[key="' + id + '"]').remove(); });
			closePopBox();
		});
	});

	$('a.edit').click(function(e) {
		e.preventDefault();

		$('#addID').val($(this).parent().attr('key'));
		$('#addTitle').val($(this).parent().children('.title').text());
		$('#addDescription').text($(this).parent().children('.description').text());
		$('#addButton').val('Update');
	});

	$('a.openAdd').click(function() {
		$('#addID').val('');
		$('#addTitle').val('');
		$('#addDescription').text('');
		$('#addButton').val('Add');
	});

	$('div.add input#addButton').click(function() {
		if ($(this).val() == 'Add') {
			$.ajax({
				type: "POST",
				url: "<?=base_url()?>Announcement/Add/",
				data: { title: $('#addTitle').val(), description: $('#addDescription').val() }
			})
			.done(function(msg) {
				try {
					var obj = $.parseJSON(msg);
					var container = "<div class='announcements' key='" + obj.id + "' style='display: none;'>" + 
										"<h2 class='title'>" + obj.title + "</h2>" + 
										"<div class='info'>" + obj.dateCreated + "</div>" + 
										"<p class='description'>" + obj.description + "</p>" + 
										"<a href='#' class='edit PopIt' name='add'>E</a>" + 
										"<a href='#' class='delete'>D</a>" + 
									"</div>";
					$('div.posts').prepend(container);
					$('div.announcements[key="' + obj.id + '"]').fadeIn(1000);
					closePopBox();
				} catch (e) {
					$('div.add div.response').html(msg);
				}
			});
		} else {

		}
	});
});
</script>

<br />
<a href="#" class='openAdd PopIt' name='add'>Add</a>
<div class="posts">
<?php
foreach ($query as $row) {
	echo "<div class='announcements' key='".$row->id."'>".
	"<h2 class='title'>".$row->title."</h2>".
	"<div class='info'>".date_format(new datetime($row->dateCreated), 'M d, Y | h:ia')."</div>".
	"<p class='description'>".$row->description."</p>".
	"<a href='#' class='edit PopIt' name='add'>E</a>".
	"<a href='#' class='delete PopIt' name='confirmDelete'>D</a>".
	"</div>";
}
?>
</div>

<div class="PopBox add">
	<input type="hidden" id='addID' />
	<table>
		<tr>
			<th></th>
			<td>
				<div class="response"></div>
			</td>
		</tr>
		<tr>
			<th>Title:</th>
			<td><input type='text' id='addTitle' value='hi' /></td>
		</tr>
		<tr>
			<th>Description:</th>
			<td><textarea id='addDescription'></textarea></td>
		</tr>
		<tr>
			<th></th>
			<td><input id='addButton' type="button" value="Add" /></td>
		</tr>
	</table>
</div>

<div class="PopBox confirmDelete">
	<input type="hidden" class="id" />
	<p></p>
	<input type="button" value="Delete" class="delete" />
	<input type="button" value="Cancel" class="cancel" />
</div>