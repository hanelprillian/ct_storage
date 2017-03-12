<?php

  //capacity indicator
  
  /*function show_capacity() {
    global $db;
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
  }

  function delete_file() {
    
  }*/

  //folder function
  function delete_folder($dir) {
    global $dir;
    global $db;

    $folder_share_path=str_replace(STORAGE_DIR.'/', "", $dir);

    $share_table=$db->prepare("SELECT * FROM user_sharing_subscriber where id_user = '$_SESSION[user_id]' and folder_sharing = '$folder_share_path'");
    $share_table->execute();
    $fetch=$share_table->fetch(PDO::FETCH_ASSOC);
    $count=$share_table->rowcount();

    if ($count > 0) {
      $delete_share_folder=TRUE;
    } else {
      $delete_share_folder=FALSE;
    }

    if(is_dir($dir)) {

      chmod($dir, 0755);
      $di = new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS);
      $ri = new RecursiveIteratorIterator($di, RecursiveIteratorIterator::CHILD_FIRST);
      foreach ( $ri as $file ) {
        $file->isDir() ?  rmdir($file) : unlink($file);
      }

      $dir_name=rtrim($dir,"/");
      $dir_name=str_replace(STORAGE_DIR.'/', "", $dir_name);
      $dir_name=end(explode("/", $dir_name));

      $dir_root=str_replace($dir_name.'/', "", $dir);
      $dir_root=str_replace(STORAGE_DIR, ' <i class="fa fa-home"></i>(Home) ', $dir_root);

      $title_log="<b>$dir_name</b> from <b>$dir_root</b>";

      rmdir($dir);

      if ($delete_share_folder) {
        //delete action
        $q_del_share=$db->prepare("DELETE FROM user_sharing_subscriber where id_user = '$_SESSION[user_id]' and folder_sharing = '$folder_share_path'");
          $q_del_share->execute();
      }

      $q_log=$db->prepare("INSERT INTO user_recent_activity SET id_user='$_SESSION[user_id]',date=now(), action='Delete',type='Folder',name='$title_log'");
        $q_log->execute();

    }
  }

  function is_dir_empty($dir) {
    if (!is_readable($dir)) return NULL; 
      $handle = opendir($dir);
      while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != "..") {
          return FALSE;
        }
      }
    return TRUE;
  }

  function formatBytes($bytes, $precision = 2) { 
    $units = array('Bytes', 'KB', 'MB', 'GB', 'TB'); 

    $bytes = max($bytes, 0); 
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
    $pow = min($pow, count($units) - 1); 

    // Uncomment one of the following alternatives
    // $bytes /= pow(1024, $pow);
    $bytes /= (1 << (10 * $pow)); 
    return round($bytes, $precision) . ' ' . $units[$pow]; 
  } 

 
?>