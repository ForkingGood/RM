<style>	
.tShirtJoinUs h2 {
		float: left;
}
.tShirtJoinUs a {
	float: right;
	background-color: #133AAC;
	padding: 5px 10px;
	border-radius: 7px;
	border: 1px outset #133AAC;
	color: white;
	text-decoration: none;
}
.tShirtJoinUs a:hover {
	color: #03899C;
}
</style>

<script>
	$(function(){
		$('.btnSubmitTShirt').click(function() {
			toggleUploadView('T-Shirt');
			toggleUpload(true);
		});
	});
</script>

<article class="tShirtJoinUs">
	<h2 style="font-family: SlicedAB">Come and be part of our big t-shirt family!</h2>
	<a href="#" class="btnSubmitTShirt">Submit T-Shirt</a>
	<div style="clear: both;"></div>
	<div class="bg"></div>
</article>