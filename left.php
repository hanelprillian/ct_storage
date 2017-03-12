
<div id="left">
	<div id="menu_vertical">
		<ul>
			<?php
				if($_SESSION['role']=="administrator") {
			?>
		  <li><a href="?mod=administrator"><i class="fa fa-home fa-fw margin10right"></i>Home</a></li>
		  <li><a href="?mod=administrator&page=users_manager"><i class="fa fa-group fa-fw margin10right"></i>Users</a></li>
		  <li><a href="?mod=administrator&page=settings"><i class="fa fa-cogs fa-fw margin10right"></i>Settings</a></li>
		  <?php
		  	} else if($_SESSION['role']=="users") {
		  ?>
		  <li><a href="index.php?mod=users"><i class="fa fa-home fa-fw margin10right"></i>Home</a></li>
		  <li><a href="index.php?mod=users&page=files"><i class="fa fa-file fa-fw margin10right"></i>Files</a></li>
		  <li><a href="index.php?mod=users&page=sharing"><i class="fa fa-share-square-o fa-fw margin10right"></i>Sharing</a></li>
		  <li><a href="index.php?mod=users&page=links"><i class="fa fa-link fa-fw margin10right"></i>Links</a></li>

		  <?php
			} 
		  ?>
		</ul>
	</div>
</div>
<div style="clear:both"></div>