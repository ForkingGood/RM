  <header>
    <div class="title"><a href="<?=base_url()?>">REDMERCY</a> <a href="<?=base_url()?>Admin/" class="dashboard">DASHBOARD</a></div>

    <div class="RMnav">
            <div style="float: left; margin: 10px 20px 0 0; color: #181818; font-size: 17pt; font-weight: 700;">
        <?=$username?><?php echo 'hi'.$_POST['username']; ?> (<a href="<?=base_url()?>Admin/Logout" style="font-size: 10pt; float: none; display: inline-block; padding: 0 2px 0 5px; position: relative; top: -2px;">Logout</a>)
    </div>
        <a href="<?=base_url()?>Admin/Feedbacks">Feedback</a>
        <a href="<?=base_url()?>Admin/Announcements">Announcements</a>
        <a href="<?=base_url()?>Admin/TShirts">T-Shirts</a>
        <a href="<?=base_url()?>Admin/Videos">Videos</a>
    </div>
    <div style="clear: both;"></div>
  </header>