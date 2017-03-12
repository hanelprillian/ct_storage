<?php
	error_reporting(0);
	session_start();
	if(!isset($_SESSION['role'])) die ("<h1>Not Found</h1>
<p>The requested URL $_SERVER[PHP_SELF] was not found on this server.</p>");
	if($_SESSION['role']!="users") {
		header('location:login.php');
		exit();
	}  
	$msg=addslashes($_GET['msg']);
	$id_msg=addslashes($_GET['id_msg']);
?>
<div class="title-dash">
	<i class="fa fa-share-square-o fa-3x left margin10right"></i><div class="title">Sharing | <button name="#confirmation-box-sharefolder" class="btn btn-info confirmation" style="background: #16a085">Share A Folder</button></div>
</div>

<?php
if($msg=="success") {
	if($id_msg==1) {
		echo '<div class="alert alert-block alert-success fade in">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
				<p align="center">Confirm Success!</p>
			</div>';
	} else if($id_msg==2) {
		echo '<div class="alert alert-block alert-success fade in">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
				<p align="center" stye="color:black">Invite Sharing Canceled!</p>
			</div>';
	} else if($id_msg==3) {
		echo '<div class="alert alert-block alert-success fade in">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
				<p align="center" stye="color:black">Sharing Has Been Remove!</p>
			</div>';
	} else if($id_msg==4) {
		echo '<div class="alert alert-block alert-success fade in">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
				<p align="center">Share folder success!</p>
			</div>';
	}
} else if($msg=="error") {
	if($id_msg==1) {
		echo '<div class="alert alert-block alert-danger fade in">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
				<p align="center">Please Select a folders!</p>
			</div>';
	} else if ($id_msg==2) {
		echo '<div class="alert alert-block alert-danger fade in">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
				<p align="center">Please insert email!</p>
			</div>';
	} else if ($id_msg==3) {
		echo '<div class="alert alert-block alert-danger fade in">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
				<p align="center">Cannot Find Email!</p>
			</div>';
	} else if ($id_msg==4) {
		echo '<div class="alert alert-block alert-danger fade in">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
				<p align="center">You have already share this!</p>
			</div>';
	}
}
?>
<script type="text/javascript">
	function validateemail() {
		$("#email").change(function(){
    	$("#messageemail").html("<span style='font-size:10pt'>Checking.....</span>");
		var emailid=$("#email").val();
		var mailformat = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;  
        $.ajax({
            type:"post",
            url:"mod/users/check_email_to_share.php?id=<?=$_SESSION['user_id']?>",
            data:"email="+emailid,
            success:function(data){
            	if(email.value.match(mailformat)) {  
					validemail=true;  
				} else {  
					$("#messageemail").html("<span style='color:red;font-size:10pt'>Please enter correct email!</span>"); 
					email.focus();
					$(email).css("border-color","red");
					validemail=false;  
					return false;  
				}
                if(data==1){
                    $("#messageemail").html("<span style='color:green;font-size:10pt'>Email found!</span>");
                    $(email).css("border-color","green");
                    validemail=true;
                } else if(data==2){
                    $("#messageemail").html("<span style='color:red;font-size:10pt'>It's your mail!</span>");
                    $(email).css("border-color","red");
                    validemail=false;
                } else {
                	$("#messageemail").html("<span style='color:red;font-size:10pt'>Email not found!</span>");
                	$(email).css("border-color","red");
                   	validemail=false;
                   	return false;
                }
            }
        });
    	});	
	}
	function ValidateForm() {
		var folder_select = document.sharefolders.folder_select;
		var email = document.sharefolders.email;
		var mailformat = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;  

		if(folder_select.value=="") {
			alert("Select a folders!");
			$(folder_select).css("border-color","red");
			return false;
		} else if (email.value=="" || !validemail) {
			alert("Please fix error!");
			$(email).css("border-color","red");
			return false;
		} else if(email.value.match(mailformat)) {  
			return true;  
		} else {  
			alert("You have entered an invalid email address!");  
			email.focus();
			$(email).css("border-color","red");
			return false;  
		}

		return true;
	}
</script>
<div id="confirmation-box-sharefolder" class="confirmation-popup popup-box">
	<form action="?mod=users&page=sharing&act=add" method="POST" enctype="multipart/form-data" name="sharefolders">
	 <div class="modal-dialog" style="width:700px">
	    <div class="modal-content">
	      <!-- dialog body -->
	      <div class="modal-body" style="padding:10px">
	        <a class="close">&times;</a>
	        Share a Folder
	        <div class="loading" style="display:none;"><img src="img/load.gif" alt="" /></div>
	        <table width="100%" class="table table-hover table-background table-bordered" style="margin-bottom:-20px;">
	    		<tr>
	    			<td width="30%">Select folder to share
	    			</td>
	    			<td width="70%">
	    				<?php
						$root = STORAGE_DIR.'/';

						function ListFolder($path)
						{
						    //using the opendir function
						    $dir_handle = @opendir($path) or die("Unable to open $path");
						    
						    //Leave only the lastest folder name
						    $dirname = end(explode("/", $path));
						    $dirname_value=str_replace(STORAGE_DIR, "", $path);
						    $dirname_value=ltrim($dirname_value,"/");
						    
						    //display the target folder.
						    echo "<li><label><input name='folder_select' value='$dirname-$dirname_value/' type='radio' style='float:left'/> <i class=\"fa fa-folder left margin10right\" style='padding:2px 0px 0px 5px'><a>$dirname /</a></i><div style='clear:both'></div></label>\n";
						    echo "<ul id=\"navlist\">\n";
						    while (false !== ($file = readdir($dir_handle))) 
						    {
						        if($file!="." && $file!="..")
						        {
						            if (is_dir($path."/".$file))
						            {
						                //Display a list of sub folders.
						                ListFolder($path."/".$file);
						            }
						        }
						    }
						    echo "</ul>\n";
						    echo "</li>\n";
						    
						    //closing the directory
						    closedir($dir_handle);
						}
						echo '<div class="listing">';
						echo "<ul id=\"navlist\">\n";
						ListFolder($root);
						echo "</ul>\n";
						echo '</div>';
						?>	
	    			</td>
	    		</tr>
	    		<tr>
	    			<td>Select User By Email</td>
	    			<td>
					    <input type="text" name="email" id="email" class="form-control" onkeyup="return validateemail();" autocomplete="off"/><span id="messageemail"></span>
	    			</td>
	    		</tr>
	    		<tr>
	    			<td>
	    				Permission
	    			</td>
	    			<td>
	    				<select name="permission">
	    					<option value="r">Read</option>
	    					<option value="rw">Read / Write</option>
	    				</select>
	    			</td>
	    		</tr>
	        </table>
	      </div>
	      <!-- dialog buttons -->
	      <div class="modal-footer" style="margin:-10px 0px -10px 0px">
	      	<input class="btn btn-danger b" type="submit" value="Share" name="share" onclick="return ValidateForm();"/>
	        <button type="button" class="btn btn-primary c">No</button>

	      </div>
	    </div>
		</div>
	</form>
</div>
<div style="clear:both"></div>
<div class="content-dash">
	<?php
		if(isset($_GET['user'])) {
	?>
			<div class="box">
				<div class="content">
					<?php include 'sharing.core.php'; ?>
				</div>
			</div>
	<?php
		} else {
			include 'sharing.dashboard.php';
		}
	?>	

	<div style="clear:both"></div>

	<div id="footer">
		Copyright &copy; <?php echo date("Y")?> CT Upload Portal. All Right Reserved.
	</div>

</div>