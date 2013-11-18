  <header>
    <div class="title">
      <a href="<?=base_url()?>">REDMERCY</a>
<?php if (isset($username)) { ?>
      <a href="<?=base_url()?>Admin/" class="dashboard">DASHBOARD</a>
<?php } ?>
    </div>
    
    <div class="RMnav">
        <a href="#" class="btnUpload">Submit</a>
        <a href="#">Contact</a>
    	<!-- <a href="/RM_Forum/">Forum</a> -->
        <a href="/RM_Store/">Store</a>
        <a href="#">About</a>
        <a href="/RM/">Home</a>
    </div>
    <div style="clear: both;"></div>
  </header>
  <div class="adminContent">