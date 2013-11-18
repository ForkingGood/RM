
<div style="width:800px;height:300px;overflow-y:scroll; margin:40px auto;">
	<div class="am-container" id="am-container">
<?php
	foreach ($query as $row) {
		echo '<a href="#"><img src="'.base_url().'asset/uploads/T-shirts/'.$row->imgPath.'"></img></a>';
	}
?>
	</div>
</div>

<script>
	$(function() {
		var $container 	= $('#am-container'),
			$imgs		= $container.find('img').hide(),
			totalImgs	= $imgs.length,
			cnt			= 0;
		
		$imgs.each(function(i) {
			var $img	= $(this);
			$('<img/>').load(function() {
				++cnt;
				if( cnt === totalImgs ) {
					$imgs.show();
					$container.montage({
						liquid 	: false,
						fillLastRow : true
					});
					
					/* 
					 * just for this demo:
					 */
					$('#overlay').fadeIn(500);
				}
			}).attr('src',$img.attr('src'));
		});	
	});
</script>