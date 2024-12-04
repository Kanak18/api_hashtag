<!-- BEGIN SIDEBAR -->
<div class="page-sidebar-wrapper">
  <div class="page-sidebar navbar-collapse collapse">
    <ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
      <li class="sidebar-toggler-wrapper">
        <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
        <div class="sidebar-toggler"> </div>
        <!-- END SIDEBAR TOGGLER BUTTON -->
      </li>
      <li class="sidebar-search-wrapper">
        <form class="sidebar-search " action="#" method="POST">
        </form>
        <!-- END RESPONSIVE QUICK SEARCH FORM -->
      </li>      
     <?php
     $files = array('applist.php', 'app.php');
     $class = (!empty($files) && in_array($filename, $files)) ? 'start active open' : '';
     ?>
      <li class="<?php echo $class; ?>"> <a href="applist.php"> <i class="icon-diamond"></i> <span class="title">App Listing</span> <span class="arrow "></span> </a>
        	<ul class="sub-menu">
          		<li> <a href="applist.php"> <i class="icon-user"></i> <span class="title">Manage App</span> <span class="arrow "></span> </a> </li>
 	       </ul>
      </li>
	 <?php
     $files = array('coinlist.php', 'coin.php');
     $class2 = (!empty($files) && in_array($filename, $files)) ? 'start active open' : '';
     ?>
	   <li class="<?php echo $class2; ?>"> <a href="coinlist.php"> <i class="icon-diamond"></i> <span class="title">Coin Link Listing</span> <span class="arrow "></span> </a>
        	<ul class="sub-menu">
          		<li> <a href="coinlist.php"> <i class="icon-user"></i> <span class="title">Manage Coin Link</span> <span class="arrow "></span> </a> </li>
 	       </ul>
      </li>
      <?php
     $files = array('fcmlist.php', 'fcm.php');
     $class2 = (!empty($files) && in_array($filename, $files)) ? 'start active open' : '';
     ?>
     <li class="<?php echo $class2; ?>"> <a href="coinlist.php"> <i class="icon-diamond"></i> <span class="title">FCM Keys</span> <span class="arrow "></span> </a>
          <ul class="sub-menu">
              <li> <a href="fcmlist.php"> <i class="icon-user"></i> <span class="title">Manage FCM Keys</span> <span class="arrow "></span> </a> </li>
         </ul>
      </li>
    </ul>	 
    <!-- END SIDEBAR MENU -->
  </div>
</div>
<!-- END SIDEBAR -->
