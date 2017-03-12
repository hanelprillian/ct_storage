<?php
error_reporting(0);
session_start();
if(!isset($_SESSION['role'])) die ("<h1>Not Found</h1>
<p>The requested URL $_SERVER[PHP_SELF] was not found on this server.</p>");
if($_SESSION['role']!="users") {
  header('location:login.php');
  exit();
}

$includeurl = false; // termasuk url apa tidak

$folders_=trim(htmlentities(htmlspecialchars(addslashes($_GET['folders']))));
$user=trim(htmlentities(htmlspecialchars(addslashes($_GET['user']))));

//setting share

$setting_share=$db->prepare("SELECT * FROM user_sharing_subscriber where id_subscriber = '$_SESSION[user_id]' and folder_sharing = '$folders_' and root_user = '$user' and status = '1'");
$setting_share->execute();
$fetch_setting_share=$setting_share->fetch(PDO::FETCH_ASSOC);
$count_setting_share=$setting_share->rowCount();

if($count_setting_share==1) {
  $root=$fetch_setting_share['root_user'];
  $folders=$fetch_setting_share['folder_sharing'];
  $startdir ='root_storage_file/users/'.$root.'/'.$folders; // root home direktori user
} else {
  die("Not Found");
}

//user who share
$user_share=$db->prepare("SELECT * FROM users where username = '$user'");
$user_share->execute();
$fetch_user_share=$user_share->fetch(PDO::FETCH_ASSOC);


// directory settings
  $showdirs=true;
// directory settings


// download settings
  $forcedownloads=true;
// download settings

// upload settings
if ($fetch_setting_share['permission']=="rw") { 
  $allowuploads=true;
} else {
  $allowuploads=false;
}
// upload settings

// overwrite settings
  $overwrite=false;
// overwrite settings


$hide = array(
        'dlf',
        'index.php',
        'Thumbs',
        '.htaccess',
        '.htpasswd',
        '.php'
      );
$showtypes = array(
          'jpg',
          'pdf',
          'doc',
          'php',
          'css',
          'png',
          'gif',
          'zip',
          'txt',
          'docx',
          'jpeg',
          'rar'
        );    
$displayindex = false;
$indexfiles = array (
        'index.html',
        'index.htm',
        'default.htm',
        'default.html'
      );
// start include url coding
if($includeurl)
{
  $includeurl = preg_replace("/^\//", "${1}", $includeurl);
  if(substr($includeurl, strrpos($includeurl, '/')) != '/') $includeurl.='/';
}
// end include url coding

error_reporting(0);

// start directory settings coding
if($startdir) $startdir = preg_replace("/^\//", "${1}", $startdir);
$leadon = $startdir;
if($leadon=='.') $leadon = '';
if((substr($leadon, -1, 1)!='/') && $leadon!='') $leadon = $leadon . '/';
$startdir = $leadon;

if($_GET['dir']) {
  //check this is okay.
  if(!file_exists($startdir.'/'.$_GET['dir'])) $error=true;
  if(substr($_GET['dir'], -1, 1)!='/') {
    $_GET['dir'] = strip_tags($_GET['dir']) . '/';
  }
  
  $dirok = true;
  $dirnames = split('/', strip_tags($_GET['dir']));
  for($di=0; $di<sizeof($dirnames); $di++) {
    
    if($di<(sizeof($dirnames)-2)) {
      $dotdotdir = $dotdotdir . $dirnames[$di] . '/';
    }
    
    if($dirnames[$di] == '..') {
      $dirok = false;
    }
  }
  
  if(substr($_GET['dir'], 0, 1)=='/') {
    $dirok = false;
  }
  
  if($dirok) {
     $leadon = $leadon . strip_tags($_GET['dir']);
  } else {
    echo "not found";
  }
}
// end directory settings coding


// start download settings coding
if (headers_sent()) {
    echo 'HTTP header already sent';
    die();
}
if($_GET['download'] && $forcedownloads) {
  $file = str_replace('/', '', $_GET['download']);
  $file = str_replace('..', '', $file);

  if(file_exists($includeurl . $leadon . $file)) {
    if (headers_sent()) {
      echo 'HTTP header already sent';
    } else {
        if (!is_file($includeurl . $leadon . $file)) {
            header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found');
            echo 'File not found';
        } else if (!is_readable($includeurl . $leadon . $file)) {
            header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
            echo 'File not readable';
        } else {
            header("Pragma: public");
            header("Content-type: application/x-download");
            header("Content-Length: ".filesize($includeurl . $leadon . $file)); 
            header('Content-Disposition: attachment; filename="'.$file.'"');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0', false);  
            header('Cache-Control: private', false); // required for certain browsers  
            ob_clean();
            flush();
            readfile($includeurl . $leadon . $file);
            die();
        }
    }
  }
  die();
}

// start upload settings coding
if ($fetch_setting_share['permission']=="rw") {
  if($_POST['upload']) {
    if($allowuploads && $_FILES['file']) {
      $upload = true;
      if(!$overwrite) {
        if(file_exists($leadon.$_FILES['file']['name'])) {
          $upload = false;
        }
      }
      //which file types are allowed seperated by comma
      for($j=0; $j < count($_FILES["file"]['name']); $j++) { 
        $img_type=$_FILES["file"]['type']["$j"];

        $allowtype=array();
        $allowext=array();

        $q=$db->prepare("SELECT ext_name, ext_mime_type FROM admin_settings_extensions where status = 1");
        $q->execute();

        while($r=$q->fetch(PDO::FETCH_ASSOC)) {
          $allowtype[]=$r['ext_mime_type'];
          $allowext[]=$r['ext_name'];
        }

        $ex_file=end(explode(".",$_FILES["file"]['name']["$j"]));

        if(in_array($img_type, $allowtype) && in_array($ex_file,$allowext)){
            $upload = true;
        } else {
          $upload = false;
          echo'<div class="alert alert-block alert-danger fade in">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            <p align="center">File extension is Invalid!</p>
          </div>';
        }

        if($upload) {
           //loop the uploaded file array
           $filen = $_FILES["file"]['name']["$j"]; //file name
           $path = $includeurl.$leadon.$filen; //generate the destination path
           move_uploaded_file($_FILES["file"]['tmp_name']["$j"],$path);
        }
      }
    }
  }
}
// end upload settings coding

// start create folder setting
if ($fetch_setting_share['permission']=="rw") {
  if($_POST['createfolder']) {
    $the_path=$includeurl.$leadon;
    $name_folder=trim(htmlentities(htmlspecialchars(addslashes(str_replace('..', '',str_replace('/', '',$_POST['namefolder']))))));

    mkdir($the_path.$name_folder,0755);

    header('location:'.$_SERVER['PHP_SELF'].'?mod=users&page=sharing&user='.$root.'&folders='.$folders.'&dir='.urlencode(str_replace($startdir,'',$leadon)).'');
    exit();
  }
}
// end create folder setting

// start directory handle coding
$opendir = $includeurl.$leadon;
if(!$leadon) $opendir = '.';
if(!file_exists($opendir)) {
  $opendir = '.';
  $leadon = $startdir;
}

clearstatcache();
if ($handle = opendir($opendir)) {
  while (false !== ($file = readdir($handle))) { 
    //first see if this file is required in the listing
    if ($file == "." || $file == "..")  continue;
    $discard = false;
    for($hi=0;$hi<sizeof($hide);$hi++) {
      if(strpos($file, $hide[$hi])!==false) {
        $discard = true;
      }
    }
    
    if($discard) continue;
    if (@filetype($includeurl.$leadon.$file) == "dir") {
      if(!$showdirs) continue;
    
      $n++;
      if($_GET['sort']=="date") {
        $key = @filemtime($includeurl.$leadon.$file) . ".$n";
      }
      else {
        $key = $n;
      }
      $dirs[$key] = $file . "/";
    }
    else {
      $n++;
      if($_GET['sort']=="date") {
        $key = @filemtime($includeurl.$leadon.$file) . ".$n";
      }
      elseif($_GET['sort']=="size") {
        $key = @filesize($includeurl.$leadon.$file) . ".$n";
      }
      else {
        $key = $n;
      }
      
      if($showtypes && !in_array(substr($file, strpos($file, '.')+1, strlen($file)), $showtypes)) unset($file);
      if($file) $files[$key] = $file;
      
      if($displayindex) {
        if(in_array(strtolower($file), $indexfiles)) {
          header("Location: $leadon$file");
          die();
        }
      }
    }
  }
  closedir($handle); 
}
// end directory handle coding


// start sort settings coding
if($_GET['sort']=="date") {
  @ksort($dirs, SORT_NUMERIC);
  @ksort($files, SORT_NUMERIC);
}
elseif($_GET['sort']=="size") {
  @natcasesort($dirs); 
  @ksort($files, SORT_NUMERIC);
}
else {
  @natcasesort($dirs); 
  @natcasesort($files);
}
// end sort settings coding


//order correctly
if($_GET['order']=="desc" && $_GET['sort']!="size") {$dirs = @array_reverse($dirs);}
if($_GET['order']=="desc") {$files = @array_reverse($files);}
$dirs = @array_values($dirs); $files = @array_values($files);

  if($error) {
    echo 'Folder atau file /'.$_GET['dir'].'Tidak ditemukan';
    die();
  }
?>


<?php
//start action module
  if($_POST['delete']) {

    include 'files-delete.php';

    header('location:'.$_POST['websiteurl'].'');
    exit();

  } else if($_POST['deletefile']){

    $file=$_POST['deletefile'];
    $file_only_path=$_POST['filepath'];
    $file_name=str_replace($file_only_path, "", $file);

    $user_public_links_table=$db->prepare("SELECT * FROM user_public_links where id_user = '$_SESSION[user_id]' and file_path = '$file_only_path' and file_name='$file_name'");
    $user_public_links_table->execute();
    $fetch=$user_public_links_table->fetch(PDO::FETCH_ASSOC);
    $count=$user_public_links_table->rowcount();

    if ($count > 0) {
      $delete_user_public_links=TRUE;
    } else {
      $delete_user_public_links=FALSE;
    }

    $file_name=end(explode("/", $file));
    $file_root=str_replace($file_name, "", $file);
    $file_root=str_replace(STORAGE_DIR, ' <i class="fa fa-home"></i>(Home) ', $file_root);

    $title_log="<b>$file_name</b> from <b>$file_root</b>";

    unlink($file);

    if ($delete_user_public_links) {
      //delete action
      $q_delete_user_public_links=$db->prepare("DELETE FROM user_public_links where ref_code='$fetch[ref_code]'");
        $q_delete_user_public_links->execute();
    }

    $q_log=$db->prepare("INSERT INTO user_recent_activity SET id_user='$_SESSION[user_id]',date=now(), action='Delete',type='File',name='$title_log'");
    $q_log->execute();

    header('location:'.$_POST['websiteurl'].'');
    exit();

    } else if($_POST['deletefolder']) {

      $dir=$_POST['deletefolder'];
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

    header('location:'.$_POST['websiteurl'].'');
    exit();

  } else if($_POST['renamefile']) {
    include 'files-rename.php';
  } else if($_POST['renamefolder']) {
    include 'folder-rename.php';
  } else if($_POST['copyfile']) {
    include 'files-copy.php';
  } else if($_POST['copyfolder']) {
    include 'folder-copy.php';
  } else {
?>

  <script type="text/javascript">
  $(document).ready(function () {
      $('input[type=text]').keyup(function() {
          var $th = $(this);
          $th.val( $th.val().replace(/[^a-zA-Z0-9_ ]/g, function(str) { alert('Input Invalid'); return ''; } ) );
      });
  });
  </script>

  <table class="table table-hover table-background table-bordered" width="100%">
    <tr>
      <td width="20%">Share by</td>
      <td width="80%"><?=$fetch_user_share['fullname']?></td>
    </tr>

    <tr>
      <td width="20%">Permission</td>
      <td width="80%">
        <?php
          if ($fetch_setting_share['permission']=="r") {
            echo "Only Read";
          } else if ($fetch_setting_share['permission']=="rw") {
            echo "Read/Write/Edit/Delete";
          }
        ?>
      </td>
    </tr>

    <tr>
      <td width="20%">Folder Name</td>
      <td width="80%">
        <?php
          echo "<strong>$fetch_setting_share[folder_name]</strong>";
        ?>
      </td>
    </tr>
  </table>

  <?php
    if ($fetch_setting_share['permission']=="rw") {
  ?>
  <table width="100%" class="table table-hover table-background table-bordered">
    <form action="<?php echo strip_tags($_SERVER['PHP_SELF']);?>?mod=users&amp;page=sharing&user=<?=$root?>&folders=<?=$folders?>&dir=<?php echo urlencode(str_replace($startdir,'',$leadon));?>" method="POST" role="form" name="form">
      <input type="hidden" name="weburl" value="<?=$_POST['websiteurl']?>"/>
      <tbody>
        <tr>
          <td width="20%"><label for="name"><strong>Create New Folder</strong></label></td>
          <td width="60%">
            <div class="input-group" style="width:100%">
              <input type="text" name="namefolder" style="color:black;font-weight:bold" class="form-control" id="name" placeholder="Insert folder name"/>         
            </div>
          </td>
          <td colspan="2" width="20%">
          <input type="submit" name="createfolder" class="btn btn-primary" style="width:100%" value="Create"/>
          </td>
        </tr>
      </tbody>
    </form>
  </table>
  <?php

    } else {

    }

  if (is_dir_empty($startdir)) {
    echo '<div class="alert alert-block alert-danger fade in">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            <p align="center">Folder or file is EMPTY!</p>
          </div>'; 
  } 
  ?>
  <form action="" method="post" name="checkboxlistfile" id="checkbox">

  <input type="hidden" name="type_access" value="share">
  <input type="hidden" name="root_user_share" value="<?=$root?>">
  <input type="hidden" name="root_folders_share" value="<?=$folders?>">


  <ol class="breadcrumb breadcrumb-arrow-square breadcrumb-arrow" style="margin-bottom: 5px;">
    <li> <a href="<?php echo $url.'?mod=users&page=sharing&user='.$root.'&folders='.$folders.'&dir=';?>">Home</a> </li>
    <?php
     $breadcrumbs = split('/', str_replace($startdir, '', $leadon));
      if(($bsize = sizeof($breadcrumbs))>0) {
        $sofar = '';
        for($bi=0;$bi<($bsize-1);$bi++) {
        $sofar = $sofar . $breadcrumbs[$bi] . '/';
        echo '<li><a href="'.$url.'?mod=users&page=sharing&user='.$root.'&folders='.$folders.'&dir='.urlencode($sofar).'">'.$breadcrumbs[$bi].'</a></li>';
      }
      }
    
    $baseurl = $url.'?mod=users&page=files&dir='.strip_tags($_GET['dir']) . '&amp;';
    $fileurl = 'sort=name&amp;order=asc';
    $sizeurl = 'sort=size&amp;order=asc';
    $dateurl = 'sort=date&amp;order=asc';

    $asc='sort=name&amp;order=asc';
    $desc='sort=name&amp;order=desc';
    
    switch ($_GET['sort']) {
      case 'name':
        if($_GET['order']=='asc') $fileurl = 'sort=name&amp;order=desc';
        break;
      case 'size':
        if($_GET['order']=='asc') $sizeurl = 'sort=size&amp;order=desc';
        break;
        
      case 'date':
        if($_GET['order']=='asc') $dateurl = 'sort=date&amp;order=desc';
        break;  
      default:
        $fileurl = 'sort=name&amp;order=desc';
        break;
    }
    ?>
    </ol>

  <input type="hidden" name="websiteurl" value="<?=$websiteurl?>"/>
  <div class="table-responsive">
   <table width="98%" class="table table-hover table-background table-bordered">
    <thead>
    <tr>
      <script type="text/javascript">
      function check_all(val) {
          var checkbox = document.checkboxlistfile.elements['checkfile[]'];
          if ( checkbox.length > 0 ) {
              for (i = 0; i < checkbox.length; i++) {
                  if ( val.checked ) {
                      checkbox[i].checked = true;
                  }
                  else {
                      checkbox[i].checked = false;
                  }
              }
          }
          else {
              if ( val.checked ) {
                  checkbox.checked = true;
              }
              else {
                  checkbox.checked = false;
              }
          }
      }

      </script>
      <th width="4%" class="center"><input type="checkbox" onclick="check_all(this)"></th>
      <th width="34%" class="center">File Name <i onclick="javascript:window.location.href='<?php echo $baseurl . $fileurl;?>'; return false;" class="fa fa-sort fa-fw"></i></th>
      <th width="7%" class="center">Type</th>
      <th width="19%" class="center">Size <i onclick="javascript:window.location.href='<?php echo $baseurl . $sizeurl;?>'; return false;" class="fa fa-sort fa-fw"></i></th>
      <th width="23%" class="center">Last Modified <i onclick="javascript:window.location.href='<?php echo $baseurl . $dateurl;?>'; return false;" class="fa fa-sort fa-fw"></i></th>
      <th width="12%" class="center">Action
      </th>
    </tr>
  </thead>
  <?php
    if($dirok) {
    ?>
    <tr>
      <td colspan="6"><i class="fa fa-arrow-circle-left fa-fw"></i> <a href="<?php echo $url.'?mod=users&page=sharing&user='.$root.'&folders='.$folders.'&dir='.urlencode($dotdotdir);?>">Back...</a></td>
    </tr>
  <?php
    }
  ?>
      <tbody class="">
        <?php
        $arsize = sizeof($dirs);
        for($i=0;$i<$arsize;$i++) {
          $folderpath = $leadon . $dirs[$i];
          $folderfullname=$dirs[$i];
          $folderpathonly=$leadon;
        ?>
         <tr>
          <td width="4%" class="center">
            <input type="checkbox" name="checkfile[]" value="<?=$folderpath?>" id="checkbox">
          </td>
          <td width="34%"><i class="fa fa-folder fa-fw" style="color:#f1c40f"></i> <strong><a href="<?php echo $url.'?mod=users&page=sharing&user='.$root.'&folders='.$folders.'&dir='.urlencode(str_replace($startdir,'',$leadon).$dirs[$i]);?>"><?php echo $dirs[$i];?></a></strong></td>
          <td width="7%" class="center"> Folder</td>
          <td width="19%" class="center">-</td>
          <td width="23%" class="center"><?php echo date ("M d Y h:i:s A", filemtime($includeurl.$leadon.$dirs[$i]));?></td>
          <td width="12%">
            <div class="center">
              <input type="hidden" name="rootpath" value="<?=$startdir?>"/>
              <input type="hidden" name="folderpath" value="<?=$folderpathonly?>"/> 
              <?php
                if ($fetch_setting_share['permission']=="rw") {
              ?>
                  <button type="submit" id="test" name="deletefolder" value="<?=$folderpath?>" class="btn btn-danger tooltip1 action2 ask-custom" title="Delete" onclick="return confirm('Are you sure want to delete this folder? the shared folder or public linked files in this folder will be remove!')">
                      <i class="fa fa-eraser fa-fw"></i>
                  </button>
                  <button type="submit" name="copyfolder" value="<?=$folderfullname?>" class="btn btn-warning tooltip1 action2" title="Copy">
                          <i class="fa fa-copy fa-fw"></i>
                  </button>
                  <button type="submit" name="renamefolder" value="<?=$folderfullname?>" class="btn btn-primary tooltip1 action2" title="Rename">
                          <i class="fa fa-edit fa-fw"></i>
                  </button>
              <?php
                } else {
              ?>
                  <button type="submit" name="copyfolder" value="<?=$folderfullname?>" class="btn btn-warning tooltip1 action2" title="Copy">
                          <i class="fa fa-copy fa-fw"></i>
                  </button>
              <?php
                }
              ?>
            </div>
          </td>
        </tr>


        <?php
        }
        $arsize = sizeof($files);
        for($i=0;$i<$arsize;$i++) {
          
          $filename = $files[$i];
          if(strlen($filename)>20) {
            $filename = substr($files[$i], 0, 30) . '...';
          }
          
          $fileurl = $includeurl . $leadon . $files[$i];
          $filepath = $leadon.$files[$i];
          $filefullname=$files[$i];
          $fileonylpath=$leadon;
          $filepath_name=str_replace(STORAGE_DIR.'/', "", $filepath);
          if($forcedownloads) {
            $fileurl = $url.'?mod=users&page=sharing&user='.$root.'&folders='.$folders.'&dir='.urlencode(str_replace($startdir,'',$leadon)) . '&download=' . urlencode($files[$i]);
          }
        ?>
        <tr> 
          <td width="4%" class="center">

            <input type="checkbox" name="checkfile[]" value="<?=$filepath?>" id="checkfilebox"/>
            <input type="hidden" name="namefile[]" value="<?=$filefullname?>">

          </td>
          <td width="34%"><a href="<?php echo $fileurl;?>"><?php echo $filename;?></a></td>
          <td width="7%" class="center"> File</td>
          <td width="19%" class="center"><em><?php echo formatBytes(filesize($includeurl.$leadon.$files[$i]));?></em></td>
          <td width="23%" class="center"><?php echo date ("M d Y h:i:s A", filemtime($includeurl.$leadon.$files[$i]));?></td>
          <td width="12%">
            <div class="center">
              <input type="hidden" name="rootpath" value="<?=$startdir?>"/>
              <input type="hidden" name="filepath" value="<?=$fileonylpath?>"/> 
              <?php
                if ($fetch_setting_share['permission']=="rw") {
              ?>
                <button onclick="return confirm('Are you sure want to delete this file?')" type="submit" name="deletefile" value="<?=$filepath?>" class="btn btn-danger tooltip1 action2" title="Delete">
                        <i class="fa fa-eraser fa-fw"></i>
                </button>
                <button type="submit" name="copyfile" value="<?=$filefullname?>" class="btn btn-warning tooltip1 action2" title="Copy">
                        <i class="fa fa-copy fa-fw"></i>
                </button>
                <button type="submit" name="renamefile" value="<?=$filefullname?>" class="btn btn-primary tooltip1 action2" title="Rename">
                        <i class="fa fa-edit fa-fw"></i>
                </button>
              <?php
                } else {
              ?>
                <button type="submit" name="copyfile" value="<?=$filefullname?>" class="btn btn-warning tooltip1 action2" title="Copy">
                        <i class="fa fa-copy fa-fw"></i>
                </button>
              <?php
                }
              ?>
          </div>
          </td>
        </tr>

        <?php
        } 
        ?>
        </tbody>
    </table>
  <?php
    if ($fetch_setting_share['permission']=="rw") {
  ?>
  <div id="confirmation-box" class="confirmation-popup">
   <div class="modal-dialog">
      <div class="modal-content">
        <!-- dialog body -->
        <div class="modal-body" style="height:50px;padding:20px">
          <a class="close">&times;</a>
          Delete All File
          <div class="loading" style="display:none;"><img src="img/load.gif" alt="" /></div>
        </div>
        <!-- dialog buttons -->
        <div class="modal-footer"><button class="btn btn-danger d" type="submit" value="Delete" name="delete"/>OK</button>
          <button type="button" class="btn btn-primary c">No</button>

        </div>
      </div>
    </div>
  </div>

  <table width="100%" class="table table-hover table-background table-bordered">
    <tr>
      <td colspan="6">
        
        <span>Checked Action</span> :&nbsp;  <button name="#confirmation-box" class="btn btn-danger confirmation">Delete Selected</button>
      </td>
    </tr> 
    </tbody>
  </table>
  <?php
    }
  ?>
  </div>
  </form>
  <?php
    if($allowuploads) {
      $phpallowuploads = (bool) ini_get('file_uploads');    
      $phpmaxsize = ini_get('upload_max_filesize');
      $phpmaxsize = trim($phpmaxsize);
      $last = strtolower($phpmaxsize{strlen($phpmaxsize)-1});
      switch($last) {
        case 'g':
          $phpmaxsize *= 1024;
        case 'm':
          $phpmaxsize *= 1024;
      }
    ?>
   <table width="100%" class="table table-hover table-background table-bordered">
    <thead>
    <tr>
      <th colspan="2" width="100%"><strong>File Upload</strong> (Max Filesize: <?php echo $phpmaxsize;?>KB)</th>
    </tr>
  </thead>
  <tbody class="">
    <tr>
      <td width="10%">
        <?php if($uploaderror) echo '<div class="upload-error">'.$uploaderror.'</div>'; ?>
        <?php
          if($phpallowuploads) {
        ?>
          <form method="post" action="<?php echo strip_tags($_SERVER['PHP_SELF']);?>?mod=users&amp;page=sharing&user=<?=$root?>&folders=<?=$folders?>&dir=<?php echo urlencode(str_replace($startdir,'',$leadon));?>" enctype="multipart/form-data">
          <input type="file" name="file[]" multiple/>
      </td>
      <td width="90%">
        <input class="btn btn-inverse" type="submit" value="Upload" name="upload"/>
          </form>
      </td>
    </tr>
    <tr>
      <?php
         } else {
        ?>
          File uploads are disabled in your php.ini file. Please enable them.
        <?php
         }
        ?>
    </tr>
  </tbody>
  </table>
  <?php
    }
}
  ?>