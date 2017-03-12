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
  $startdir =STORAGE_DIR; // root home direktori user


// directory settings
  $showdirs=true;
// directory settings


// download settings
  $forcedownloads=true;
// download settings


// upload settings
  $allowuploads=true;
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
          <p align="center">File extension is Invalid or File Too Large!</p>
        </div>';
      }
      $file_size=$_FILES["file"]['size']["$j"];
      $totalall=$total_space_used_in_bytes+$file_size;

      if($totalall >= $max_space_per_user_in_bytes) {
        header('location:?mod=users&page=files&msg=error&id_msg=6');
        exit();
      }

      if($upload) {
         //loop the uploaded file array

        $filen = $_FILES["file"]['name']["$j"]; //file name
        $path = $includeurl.$leadon.$filen; //generate the destination path
        move_uploaded_file($_FILES["file"]['tmp_name']["$j"],$path);

        $file_root=str_replace($filen, "", $path);
        $file_root=rtrim($file_root,"/");
        $file_root=str_replace(STORAGE_DIR, ' <i class="fa fa-home"></i>(Home) ', $file_root);

        $title_log="<b>$filen</b> to <b>$file_root/</b>";

        $q_log=$db->prepare("INSERT INTO user_recent_activity SET id_user='$_SESSION[user_id]',date=now(), action='Upload',type='File',name='$title_log'");
        $q_log->execute();
      }
    }
  }
}
// end upload settings coding

// start create folder setting
if($_POST['createfolder']) {
  $the_path=$includeurl.$leadon;
  $name_folder=trim(strip_tags(addslashes(str_replace('..', '',str_replace('/', '',$_POST['namefolder'])))));

  mkdir($the_path.$name_folder,0755);

  $the_path_name=rtrim($the_path,"/");
  $the_path_name=str_replace(STORAGE_DIR, ' <i class="fa fa-home"></i>(Home) ', $the_path_name);

  $title_log="<b>$name_folder</b> in <b>$the_path_name/</b>";

  $q_log=$db->prepare("INSERT INTO user_recent_activity SET id_user='$_SESSION[user_id]',date=now(), action='Create',type='Folder',name='$title_log'");

  $q_log->execute();

  header('location:'.$_SERVER['PHP_SELF'].'?mod=users&page=files&dir='.urlencode(str_replace($startdir,'',$leadon)).'');
  exit();
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
      } else {
        $key = $n;
      }

      $dirs[$key] = $file . "/";

    } else {

      $n++;
      if($_GET['sort']=="date") {
        $key = @filemtime($includeurl.$leadon.$file) . ".$n";
      } else if($_GET['sort']=="size") {
        $key = @filesize($includeurl.$leadon.$file) . ".$n";
      } else {
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
<script type="text/javascript">
$(document).ready(function () {
    $('input[name=namefolder]').keyup(function() {
        var $th = $(this);
        $th.val( $th.val().replace(/[^a-zA-Z0-9_ @]/g, function(str) { alert('Input Invalid'); return ''; } ) );
    });
});
</script>

<table width="100%" class="table table-hover table-bordered">
  <form action="<?php echo strip_tags($_SERVER['PHP_SELF']);?>?mod=users&amp;page=files&amp;dir=<?php echo urlencode(str_replace($startdir,'',$leadon));?>" method="POST" role="form" name="form">
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
if (is_dir_empty(STORAGE_DIR)) {
  echo '<div class="alert alert-block alert-danger fade in">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
          <p align="center">Folder or file is EMPTY!</p>
        </div>'; 
} 
?>
<?php
  if ($_POST['s_l']) {
    header('location:'.$_POST['s_l'].'');
    exit();
  }
?>
  <form action="" method="post" name="checkboxlistfile" id="checkbox">

  <ol class="breadcrumb breadcrumb-arrow-square breadcrumb-arrow" style="margin-bottom: 5px;">
  <li> <a href="<?php echo $url.'?mod=users&page=files&dir=';?>">Home</a> </li>
  <?php

  $breadcrumbs = split('/', str_replace($startdir, '', $leadon));
  if(($bsize = sizeof($breadcrumbs))>0) {
    $sofar = '';
    for($bi=0;$bi<($bsize-1);$bi++) {
      $sofar = $sofar . $breadcrumbs[$bi] . '/';
      echo '<li><a href="'.$url.'?mod=users&page=files&dir='.urlencode($sofar).'">'.$breadcrumbs[$bi].'</a></li>';
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

<style type="text/css">
  .wew {
    overflow: scroll;
    max-height: 500px;
  }
</style>

<div class="wew table-responsive">
 <table width="100%" class="table table-hover table-background table-bordered">
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

    function submitcheck() {

    }

    </script>
    <th width="4%" class="center"><input type="checkbox" onclick="check_all(this)"></th>
    <th width="35%" class="center">File Name <i onclick="javascript:window.location.href='<?php echo $baseurl . $fileurl;?>'; return false;" class="fa fa-sort fa-fw"></i></th>
    <th width="5%" class="center">Type</th>
    <th width="9%" class="center">Size <i onclick="javascript:window.location.href='<?php echo $baseurl . $sizeurl;?>'; return false;" class="fa fa-sort fa-fw"></i></th>
    <th width="23%" class="center">Created <i onclick="javascript:window.location.href='<?php echo $baseurl . $dateurl;?>'; return false;" class="fa fa-sort fa-fw"></i></th>
    <th width="16%" class="center">Action
    </th>
  </tr>
</thead>
<?php
  if($dirok) {
  ?>
  <tr>
    <td colspan="6"><i class="fa fa-arrow-circle-left fa-fw"></i> <a href="<?php echo $url.'?mod=users&page=files&dir='.urlencode($dotdotdir);?>">Back...</a></td>
  </tr>
<?php
  }
?>
    <tbody>
      <?php
      $arsize = sizeof($dirs);
      for($i=0;$i<$arsize;$i++) {
        $folderpath = $leadon . $dirs[$i];
        $folderfullname=$dirs[$i];
        $folderpathonly=$leadon;

        $folder_to_share_path=str_replace(STORAGE_DIR.'/', "", $folderpath);
      ?>
       <tr>
        <td class="center">
          <input type="checkbox" class="checkfile" name="checkfile[]" value="<?=$folderpath?>">
        </td>
        <td>
          <?php
            $share=$db->prepare("SELECT * FROM user_sharing_subscriber where id_user = '$_SESSION[user_id]' and folder_sharing = '$folder_to_share_path'");
            $share->execute();
            $fetch=$share->fetch(PDO::FETCH_ASSOC);
            $count=$share->rowcount();
            if($count > 0) {
              $color="green";
              $icon="fa-folder-open";
              $confirm="Are you sure want to delete shared folder? Folder will be delete from sharing area!";
              $button=false;
            } else {
              $color="#f1c40f";
              $icon="fa-folder";
              $confirm="Are you sure want to delete this folder? the shared folder or public linked files in this folder will be remove!";
              $button=true;
            }
          ?>
          <i class="fa <?=$icon?> fa-fw" style="color:<?=$color?>"></i> <strong><a href="<?php echo $url.'?mod=users&page=files&dir='.urlencode(str_replace($startdir,'',$leadon).$dirs[$i]);?>"><?php echo $dirs[$i];?></a></strong></td>
        <td class="center"> Folder</span></td>
        <td class="center">-</td>
        <td class="center"><?php echo date ("M d Y h:i:s A", filemtime($includeurl.$leadon.$dirs[$i]));?></td>
        <td>
          <div class="center">
          <input type="hidden" name="rootpath" value="<?=$startdir?>"/>
          <input type="hidden" name="folderpath" value="<?=$folderpathonly?>"/> 
          <?php
            $folder_to_share_name=rtrim($folderfullname,"/");
            $folder_to_share_path=str_replace(STORAGE_DIR.'/', "", $folderpath);
            if ($button) {
              echo '
                <button name="s_l" class="btn btn-success tooltip1 action2" title="Share This Folder" value="index.php?mod=users&page=sharing&act=add&folder_path='.$folder_to_share_path.'">
                      <i class="fa fa-share-square-o fa-fw"></i>
                </button>
              ';
            } else {
              echo '<span class="tooltip1" title="Shared">&nbsp;&nbsp;<i class="fa fa-share-square-o fa-fw"></i>&nbsp;</span>';
            }
          ?>
            <button type="submit" id="test" name="deletefolder" value="<?=$folderpath?>" class="btn btn-danger tooltip1 action2 ask-custom" title="Delete" onclick="return confirm('<?=$confirm?>')">
                    <i class="fa fa-eraser fa-fw"></i>
            </button>
            <button type="submit" name="copyfolder" value="<?=$folderfullname?>" class="btn btn-warning tooltip1 action2" title="Copy">
                    <i class="fa fa-copy fa-fw"></i>
            </button>
            <button type="submit" name="renamefolder" value="<?=$folderfullname?>" class="btn btn-primary tooltip1 action2" title="Rename">
                    <i class="fa fa-edit fa-fw"></i>
            </button>
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
        if($forcedownloads) {
          $fileurl = $url.'?mod=users&page=files&dir='.urlencode(str_replace($startdir,'',$leadon)) . '&download=' . urlencode($files[$i]);
        }
      ?>
      <tr> 
        <td class="center">
          <input type="checkbox" class="checkfile" name="checkfile[]" value="<?=$filepath?>"/>
          <input type="hidden" name="namefile[]" value="<?=$filefullname?>">
        </td>
        <td><a href="<?php echo $fileurl;?>"><?php echo $filename;?></a></td>
        <td class="center">
          <?php
            $ex_file_listing=end(explode(".",$filefullname));
            echo $ex_file_listing;
          ?>
        </td>
        <td class="center"><em><?php echo formatBytes(filesize($includeurl.$leadon.$files[$i]));?></em></td>
        <td class="center"><?php echo date ("M d Y h:i:s A", filemtime($includeurl.$leadon.$files[$i]));?></td>
        <td>
          <div class="center">
            <input type="hidden" name="rootpath" value="<?=$startdir?>"/>
            <input type="hidden" name="filepath" value="<?=$fileonylpath?>"/> 
            <?php
              $q=$db->prepare("SELECT * FROM user_public_links where id_user = '$_SESSION[user_id]' and file_name = '$filefullname' and file_path = '$fileonylpath'");
              $q->execute();
              $count=$q->rowcount();
              $fetch_q=$q->fetch(PDO::FETCH_ASSOC);
              if ($count==0) {
                $confirm="Are you sure want to delete this file?";
            ?>
              <button type="submit" name="create_pub_links" value="<?=$filefullname?>" class="btn btn-success tooltip1 action2" title="Create Public Link">
                      <i class="fa fa-link fa-fw"></i>
              </button>
            <?php 
              } else {
                $confirm="Are you sure want to delete this file? the file will be remove from public link area!";
            ?>
              <a href="links.php?files=<?=$fetch_q['file_name']?>&code=<?=$fetch_q['ref_code']?>" target="_blank" class="tooltip2" title="Visit Link">&nbsp;&nbsp;<i class="fa fa-link fa-fw"></i>&nbsp;</a>
            <?php 
              }
            ?>
            <button type="submit" name="deletefile" value="<?=$filepath?>" class="btn btn-danger tooltip1 action2" title="Delete" onclick="return confirm('<?=$confirm?>')">
                    <i class="fa fa-eraser fa-fw"></i>
            </button>
            <button type="submit" name="copyfile" value="<?=$filefullname?>" class="btn btn-warning tooltip1 action2" title="Copy">
                    <i class="fa fa-copy fa-fw"></i>
            </button>
            <button type="submit" name="renamefile" value="<?=$filefullname?>" class="btn btn-primary tooltip1 action2" title="Rename">
                    <i class="fa fa-edit fa-fw"></i>
            </button>
        </div>
        </td>
      </tr>

      <?php
      } 
      ?>
      </tbody>
  </table>
</div>

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
      <span>Checked Action</span> :&nbsp;  <button onclick="return submitcheck();" name="#confirmation-box" class="btn btn-danger confirmation delete_button">Delete Selected</button>
    </td>
  </tr> 
  </tbody>
</table>
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

    if($phpallowuploads) {
?>    
      <script>
        $(document).ready(function() {
          $(".add_more_file").click(function() {
            $('<div><input class="left" type="file" name="file[]" multiple/><span class="rem" ><a href="javascript:void(0);">Remove</span><div style="clear:both"></div></div>').appendTo(".content_upload");
            });
          $('.content_upload').on('click', '.rem', function() {
            $(this).parent("div").remove();
          });
         
        });
      </script>
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
                <form method="post" action="<?php echo strip_tags($_SERVER['PHP_SELF']);?>?mod=users&amp;page=files&amp;dir=<?php echo urlencode(str_replace($startdir,'',$leadon));?>" enctype="multipart/form-data">
                  <div class="content_upload">
                    <input class="left" type="file" name="file[]"/><a href="javascript:void(0);" class="add_more_file " >Add More</a>
                    <div style="clear:both"></div>
                  </div>
                  <br>
                  <input class="btn btn-inverse" type="submit" value="Upload" name="upload"/>
                </form>
            </td>
          </tr>
          <tr>
            
          </tr>
        </tbody>
      </table>
<?php
    } else {
      echo "File uploads are disabled in your php.ini file. Please enable them.";
    }
  }
?>