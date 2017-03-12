<?php
session_save_path("temp/sessions");
session_regenerate_id(true);
session_start();
error_reporting(0);
include 'config.php';
include 'assets/function/files.func.php';
$code=trim(htmlentities(htmlspecialchars(addslashes(str_replace('..', '',str_replace('/', '',$_GET['code']))))));
$files=trim(htmlentities(htmlspecialchars(addslashes(str_replace('..', '',str_replace('/', '',$_GET['files']))))));
$msg=trim(htmlentities(htmlspecialchars(addslashes(str_replace('..', '',str_replace('/', '',$_GET['msg']))))));

$q=$db->prepare("SELECT * FROM user_public_links where ref_code = '$code' and file_name = '$files'");
$q->execute();
$count=$q->rowCount();
$fetch=$q->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Links | Portal Upload | CT</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" type="text/css" href="assets/css/style.css"/>
      <link rel="stylesheet" type="text/css" href="assets/css/font.css"/>
      <!-- Loading Bootstrap -->
      <link href="assets/css/bootstrap.css" rel="stylesheet" type="text/css">
      <link href="assets/css/prettify.css" rel="stylesheet" type="text/css">

      <!-- Loading Flat UI -->
          
      <link href="assets/css/font-awesome.min.css" rel="stylesheet" media="screen">
      <script src="assets/js/jquery-1.10.1.min.js"></script>
      <script src="assets/js/bootstrap.min.js"></script>

      <link rel="stylesheet" href="assets/css/jquery-ui-1.10.0.custom.css"type="text/css" media="all"/>
  </head> 
  <body class="bodbgwhite">
    <?php
      $path_file=$fetch['file_path'];
      $file=$fetch['file_name'];
      if(!file_exists($path_file . $file)) {
        die ('<div class="wrap_download">
            <div class="download_content" style="margin-top:200px;">
              <i class="fa fa-search fa-5x" style="margin-left:37%;font-size:100pt;"></i>
              <div class="text" style="font-size:20pt;margin-top:20px;">
                404 FILE NOT FOUND !
              </div>
            </div>
          </div>
        ');
      }
      if($count==0) {
        die ('<div class="wrap_download">
            <div class="download_content" style="margin-top:200px;">
              <i class="fa fa-search fa-5x" style="margin-left:37%;font-size:100pt;"></i>
              <div class="text" style="font-size:20pt;margin-top:20px;">
                404 FILE NOT FOUND !
              </div>
            </div>
          </div>
        ');
      }

      if($_POST['download_file']) {
        $path_file=$fetch['file_path'];
        $file=$fetch['file_name'];
        if(file_exists($path_file . $file)) {
          if (headers_sent()) {
            echo 'HTTP header already sent';
          } else {
            if (!is_file($path_file . $file)) {
                header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found');
                echo 'File not found';
            } else if (!is_readable($path_file.$file)) {
                header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
                echo 'File not readable';
            } else {
                header("Pragma: public");
                header("Content-type: application/x-download");
                header("Content-Length: ".filesize($path_file . $file)); 
                header('Content-Disposition: attachment; filename="'.$file.'"');
                header('Cache-Control: must-revalidate, post-check=0, pre-check=0', false);  
                header('Cache-Control: private', false); // required for certain browsers  
                ob_clean();
                flush();
                readfile($path_file. $file);

                $insert=$db->prepare("UPDATE user_public_links SET downloaded = downloaded + 1 where ref_code = '$code'");
                $insert->execute();
                die();
            }
          }
        }
        die();
      }
    ?>
    <div id="menuatas">
      <div class="logo"><img src="img/2itc.png">Cargando Team</div>
        <ul>
        <?php
          if($_SESSION['role']=="administrator") {
        ?>
          <?php
          $s_user_profile=$db->prepare("SELECT * FROM users where id = '$_SESSION[user_id]'");
          $s_user_profile->execute();
          $f_user_profile=$s_user_profile->fetch(PDO::FETCH_ASSOC);
          ?>
          <li><a href="?mod=administrator&page=profile"><i class="fa fa-user fa-fw margin10right"></i><?=$f_user_profile['fullname']?></a></li>
          <li><a href="logout.php"><i class="fa fa-power-off fa-fw margin10right"></i>Logout</a></li>
        <?php
          } else if($_SESSION['role']=="users") {
        ?>

          <div class="capacity_files_users">
            <?php
              $total_space_used = 0;
              $d = new RecursiveIteratorIterator(
                  new RecursiveDirectoryIterator(ROOT_FILE_STORAGE.'/'.USER_FILE_ROOT), 
                  RecursiveIteratorIterator::SELF_FIRST
              );

              foreach($d as $file){
               $total_space_used += $file->getSize();
              }

              //check space per user
              $space_for_user_q=$db->prepare("SELECT * FROM admin_settings_users_bandwith where id = '1'");
              $space_for_user_q->execute();
              $fetch_space_for_user=$space_for_user_q->fetch(PDO::FETCH_ASSOC);

              if ($fetch_space_for_user['size_by']=="GB") {
                $max_space_per_user=$fetch_space_for_user['space_for_users']*1024*1024*1024;
              } else if ($fetch_space_for_user['size_by']=="MB") {
                $max_space_per_user=$fetch_space_for_user['space_for_users']*1024*1024;
              } else if ($fetch_space_for_user['size_by']=="KB") {
                $max_space_per_user=$fetch_space_for_user['space_for_users']*1024;
              }

              $used=$total_space_used;

              $percentage_count=$max_space_per_user/100;
              $percentage=round($used/$percentage_count,1);

              $total_space_used_in_bytes=$total_space_used;
              $max_space_per_user_in_bytes=$max_space_per_user;

              $total_space_used=formatBytes($total_space_used);
              $max_space_per_user=formatBytes($max_space_per_user);

              $action_for_user=true;
              if($percentage >= 100) {
                $percentage=100;
                $action_for_user=false;
              }
            ?>

            <div class="capacity_files_users_text"><?=$total_space_used?> of <?=$max_space_per_user?> Used</div>
            <div class="progress_wrap">
              <?php
                if ($percentage <= 20) {
                  $background="#27ae60";
                } else if($percentage <= 40) {
                  $background="#2ecc71";
                } else if ($percentage <= 60) {
                  $background="#f39c12";
                } else if ($percentage <= 80) {
                  $background="#e67e22";
                } else if ($percentage <= 100) {
                  $background="#e74c3c";
                }
              ?>
              <div class="progress_bar" style="width:<?=$percentage?>%;background:<?=$background?>">
                <?=$percentage?>%
              </div>
            </div>
          </div>

          <?php
            $s_user_profile=$db->prepare("SELECT * FROM users where id = '$_SESSION[user_id]'");
            $s_user_profile->execute();
            $f_user_profile=$s_user_profile->fetch(PDO::FETCH_ASSOC);
          ?>
          <li><a href="index.php?mod=users&page=profile"><i class="fa fa-user fa-fw margin10right"></i><?=$f_user_profile['fullname']?></a></li>
          <li><a href="logout.php"><i class="fa fa-power-off fa-fw margin10right"></i>Logout</a></li>

        <?php
          }
        ?>
      </ul>
    </div >
    
    <script type="text/javascript">
      $(function(){
      jQuery.fn.center = function ()
      {
          this.css("position","absolute");
          this.css("top", ($(window).height() / 2) - (this.outerHeight() / 2));
          this.css("left", ($(window).width() / 2) - (this.outerWidth() / 2));
          return this;
      }
     
      $('.wrap_download').center();
        $(window).resize(function(){
           $('.wrap_download').center();
        });
    });
    </script>
    <div class="wrap_download">
      <div class="download_content">
        <i class="fa fa-file fa-5x" style="margin-left:41%;font-size:100pt;"></i>
        <div class="text">
          <?=$fetch['file_name']?>
        </div>
        <div class="text_size">
          <?php
            $filesize=formatBytes(filesize($fetch['file_path'].$fetch['file_name']));
          ?>
          Size : <?=$filesize?>
          <br><br>
          <form action="" method="POST">
            <button type="submit" name="download_file" value="<?=$code?>" class="btn btn-primary" style="font-size:20px">
              <i class="fa fa-download fa-fw margin10right"></i>
              DOWNLOAD
            </button>
          </form>
        </div>
      </div>
      <div id="footer">
        Copyright &copy; 2014 CT Upload Portal. All Right Reserved
      </div>
    </div>
  </body>
</html>
