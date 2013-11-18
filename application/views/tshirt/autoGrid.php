
  

	<!-- <ul class="category-navbar"><li class="select"><a>All</a></li><li class=""><a>Category 1</a></li><li class=""><a>Category 2</a></li><li class=""><a>Category 3</a></li></ul> -->
	<style>
		div.autoGridScroll {
			padding-right: 4px;
		}
	</style>
<div class="autoGridScroll">
<div id="grid" data-directory="gallery">
<?php
	foreach ($query as $row) {
		echo '<div class="gbox" data-category="Shirt">'.
				 '<img src="asset/uploads/T-shirts/'.$row->imgPath.'" data-lightbox="asset/uploads/T-shirts/'.$row->imgPath.'" />'.
				 '<div class="image-caption"><h3>'.$row->summonerName.'</h3><h5>'.$row->description.'</h5></div>'.
				 '<div class="lightbox-text"><h3>'.$row->summonerName.'</h3><h5>'.$row->description.'</h5></div>'.
			 '</div>';
	}
?>
</div>
</div>





	<script>
	$(function(){

		$('#grid').grid({
					captionType: 'grid',
					columnWidth: 108,
					lazyLoad: true,
					showNavBar:true,
					smartNavBar:false,
					imagesToLoadStart: 15, //The number of images to load when it first loads the grid
    				imagesToLoad: 5
				});
		$('div.autoGridScroll').slimscroll({ 
			height: '316px',
			color: '#840000'
		});
	});
	</script>