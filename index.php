<?php
  if(file_exists('autoload.php')) {
    include 'autoload.php';
  }
  
  if($_SESSION['role']=="") {
  	header('location:login.php');
    exit();
  } 

  include 'header.php';
  include 'left.php';
?>
<style>
  .action2 {
    padding:5px;
    font-size:12px;
    margin-top: -4px;
    margin-right: 2px;
    margin-left: 5px;
  }
</style>
<div id="right">
	<?php
  	if($mod=="" || !file_exists('mod/'.$mod.'/index.php')) 
      include dirname(__FILE__)."/mod/home.php";
  	else if ($page=="" || !file_exists('mod/'.$mod.'/'.$page.'.php')) 
      include dirname(__FILE__)."/mod/$mod/index.php";
  	else if ($act=="" || !file_exists('mod/'.$mod.'/'.$page.'-'.$act.'.php')) 
      include dirname(__FILE__)."/mod/$mod/$page.php";
  	else 
      include dirname(__FILE__)."/mod/$mod/$page-$act.php";
	?>
</div>
<?php
	include 'footer.php';
?>
