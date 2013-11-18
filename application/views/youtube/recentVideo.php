<script>
    var url = 'http://gdata.youtube.com/feeds/api/users/redmercy/uploads?alt=json&v=2&start-index=1&max-results=4';
	$(function() {
		$.getJSON(url, function(data) {
        	var json = data;
			if (json.feed.entry != undefined) {
	          	var count = 0;
	          	$.each(json.feed.entry, function(key, val) {
	          		$('div.recentVideo').append(
	          			'<a href="#" name="' + val.media$group.yt$videoid.$t + '" key="' + count++ + '">' + 
	          				'<img src="' + val.media$group.media$thumbnail[1].url + '" alt="' + val.media$group.media$title.$t + '" />' + 
	          			'</a>'
	          		);
	          	});
	      	}

			$('div.recentVideo a').click(function(e) {
				e.preventDefault();
				setPlaylist('');
				setFilterTxt('');
				// resetPlaylist();
				nextVideo($(this).attr('name'));
				toggleLeftBar(true);
			});
		});
	});
</script>
<style>
	div.recentVideo {
	}
	div.recentVideo img {
		border: 3px solid #840000;
		width: 200px;
		margin: 0 18px;
		transition: box-shadow 0.3s;
	}
	div.recentVideo img:hover {
		box-shadow: 0 0 40px #840000;
	}
	div.recentVideo a {
	}
</style>

<div class="recentVideo">

</div>