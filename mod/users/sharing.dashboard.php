<?php
  error_reporting(0);
  session_start();
  if(!isset($_SESSION['role'])) die ("<h1>Not Found</h1>
  <p>The requested URL $_SERVER[PHP_SELF] was not found on this server.</p>");
  if($_SESSION['role']!="users") {
    header('location:login.php');
    exit();
  }
  
  // check folder shared is exist
  $q_c_f_s_i_e=$db->prepare("SELECT * FROM user_sharing_subscriber where id_user = '$_SESSION[user_id]'");
  $q_c_f_s_i_e->execute();
  $c_q_c_f_s_i_e=$q_c_f_s_i_e->rowCount();

  while ($f_q_c_f_s_i_e=$q_c_f_s_i_e->fetch(PDO::FETCH_ASSOC)) { 
    if (!is_dir(STORAGE_DIR.'/'.$f_q_c_f_s_i_e['folder_sharing'])) {
      $q_d_f_s=$db->prepare("DELETE FROM user_sharing_subscriber where id_user = '$_SESSION[user_id]' AND folder_sharing = '$f_q_c_f_s_i_e[folder_sharing]'");
      $q_d_f_s->execute();
    }
  }

?>

  <style type="text/css">
    .wew {
      overflow: scroll;
      max-height: 500px;
    }
    .wew td {
       word-break:break-all;
    }
  </style>

<?php
  $stop_share=trim(htmlentities(htmlspecialchars(addslashes($_POST['stop_share']))));

  if($stop_share){
    $q_s_sharing_sub=$db->prepare("SELECT * FROM user_sharing_subscriber where id ='$stop_share'");
    $q_s_sharing_sub->execute();
    $q_s_sharing_sub_fetch=$q_s_sharing_sub->fetch(PDO::FETCH_ASSOC);

    $q=$db->prepare("DELETE FROM user_sharing_subscriber where id = '$stop_share'");
    $q->execute();

    $q_user=$db->prepare("SELECT * FROM users where id ='$q_s_sharing_sub_fetch[id_subscriber]'");
    $q_user->execute();
    $fetch_user=$q_user->fetch(PDO::FETCH_ASSOC);

    $title_log="<b>$q_s_sharing_sub_fetch[folder_name]</b> from user email account <b>$fetch_user[email]</b>";

    $q_log=$db->prepare("INSERT INTO user_recent_activity SET id_user='$_SESSION[user_id]',date=now(), action='Stop Share',type='Folder',name='$title_log'");
    $q_log->execute();

    header('location:?mod=users&page=sharing&msg=success&id_msg=3');
    exit();
  }
?>
<div class="box">
  <div class="head">
    <i class="fa fa-share-square-o fa-fw margin10right"></i>Shared To Users 
  </div>
  <div class="content">
    <form action="" method="post">
      <div class="table-responsive">
        <div class="wew">
          <table width="98%" class="table table-hover table-background table-bordered">
            <thead>
              <tr>
                <th width="1%" class="center"></th>
                <th width="22%" class="center">Folders Name</th>
                <th width="11%" class="center">Permission</th>
                <th width="22%" class="center">Share To:</th>
                <th width="12%" class="center">Status</th>
                <th width="6%" class="center">Action</th>
              </tr>
            </thead>
            <tbody class="">
              <?php
                $q=$db->prepare("SELECT * FROM user_sharing_subscriber where id_user = '$_SESSION[user_id]' order by id desc");
                $q->execute();
                while ($r=$q->fetch(PDO::FETCH_ASSOC)) {
              ?>
               <tr>
                <td><i class="fa fa-folder-open fa-fw" style="color:#27ae60"></i></td>
                <td><strong><a href="<?php echo $url.'?mod=users&page=files&dir='.$r['folder_sharing'];?>"><?php echo $r['folder_name'];?></a></strong><br>
                  <span style="color:grey;font-size:10pt;padding-top:-10px;">
                    <?php
                      $user=$db->prepare("SELECT * FROM users where id='$_SESSION[user_id]'");
                      $user->execute();
                      $f_user=$user->fetch(PDO::FETCH_ASSOC);
                      echo $f_user['username'];
                    ?>/<?=$r['folder_sharing']?>
                  </span>
                </td>
                <td class="center">
                  <?php
                    if($r['permission']=='r') {
                      echo "Read";
                    } else if ($r['permission']=='rw') {
                      echo "Read/Write";
                    }
                  ?>
                </td>
                <td class="center">
                  <u>
                  <?php
                    $user=$db->prepare("SELECT * FROM users where id='$r[id_subscriber]'");
                    $user->execute();
                    $f_user=$user->fetch(PDO::FETCH_ASSOC);
                    echo $f_user['email'];
                  ?>
                  </u>
                </td>
                <td class="center">
                  <?php
                    if($r['status']==0) {
                      echo "Waiting Approval";
                    } else if($r['status']==1) {
                      echo "Shared";
                    }
                  ?>  
                </td>
                <td>
                  <div class="center">
                    <input type="hidden" name="id_sharing" value="<?=$r['id']?>"/>
                    <button type="submit" id="test" name="stop_share" value="<?=$r['id']?>" class="btn btn-danger tooltip1 action2 ask-custom" title="Cancel Share" onclick="return confirm('are you sure want to cancel share?')">
                            <i class="fa fa-eraser fa-fw"></i>
                    </button>
                    <!-- //deactive
                    <button type="submit" id="test" name="deactive_share" value="<?=$folderpath?>" class="btn btn-danger tooltip1 action2 ask-custom" title="Delete" onclick="return confirm('are you sure?')">
                            <i class="fa fa-eraser fa-fw"></i>
                    </button>
                    -->
                  </div>
                </td>
              </tr>
              <?php
                }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="box">
  <div class="head">
    <i class="fa fa-share-square-o fa-fw margin10right"></i>Shared By Users
  </div>
  <div class="content">
    <form action="" method="post">
      <div class="table-responsive">
        <div class="wew">
          <table width="98%" class="table table-hover table-background table-bordered">
            <thead>
              <tr>
                <th width="1%" class="center"></th>
                <th width="22%" class="center">Folders Name</th>
                <th width="11%" class="center">Permission</th>
                <th width="22%" class="center">Share By:</th>
                <th width="12%" class="center">Status</th>
                <th width="6%" class="center">Action</th>
              </tr>
            </thead>
            <tbody class="">
              <?php
                $q=$db->prepare("SELECT * FROM user_sharing_subscriber where id_subscriber = '$_SESSION[user_id]' and status = '1'");
                $q->execute();
                while ($r=$q->fetch(PDO::FETCH_ASSOC)) {

              ?>
               <tr>
                <td><i class="fa fa-folder-open fa-fw" style="color:#c0392b"></i></td>
                <td><strong><a href="<?php echo $url.'?mod=users&page=sharing&user='.$r['root_user'].'&folders='.$r['folder_sharing'];?>"><?php echo $r['folder_name'];?></a></strong><br>
                  <span style="color:grey;font-size:10pt;padding-top:-10px;">
                    <?php
                      $user=$db->prepare("SELECT * FROM users where id='$_SESSION[user_id]'");
                      $user->execute();
                      $f_user=$user->fetch(PDO::FETCH_ASSOC);
                      echo $f_user['username'];
                    ?>/<?=$r['folder_sharing']?>
                  </span>
                </td>
                <td class="center">
                  <?php
                    if($r['permission']=='r') {
                      echo "Read";
                    } else if ($r['permission']=='rw') {
                      echo "Read/Write";
                    }
                  ?>
                </td>
                <td class="center">
                  <u>
                  <?php
                    $user=$db->prepare("SELECT * FROM users where id='$r[id_user]'");
                    $user->execute();
                    $f_user=$user->fetch(PDO::FETCH_ASSOC);
                    echo $f_user['fullname'];
                  ?>
                  </u>
                </td>
                <td class="center">
                  <?php
                    if($r['status']==0) {
                      echo "Waiting Approval";
                    } else if($r['status']==1) {
                      echo "Shared";
                    }
                  ?>  
                </td>
                <td>
                  <div class="center">
                    <button type="submit" id="test" name="stop_share" value="<?=$r['id']?>" class="btn btn-danger tooltip1 action2 ask-custom" title="Stop Share" onclick="return confirm('are you sure want to stop share?')">
                            <i class="fa fa-eraser fa-fw"></i>
                    </button>
                    <!-- //deactive
                    <button type="submit" id="test" name="deactive_share" value="<?=$folderpath?>" class="btn btn-danger tooltip1 action2 ask-custom" title="Delete" onclick="return confirm('are you sure?')">
                            <i class="fa fa-eraser fa-fw"></i>
                    </button>
                    -->
                  </div>
                </td>
              </tr>
              <?php
                }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </form>
  </div>
</div>

