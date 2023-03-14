<?php

use function PHPSTORM_META\type;

$id = $_GET['id'];
	$con=new mysqli("localhost","root","","blood_donate");
	if(mysqli_connect_error())
	{
		die('Connect Error('. mysqli_connect_errno().')'.mysqli_connect_error());
	}
    $qry = $con->query("SELECT * FROM admin where username='$id' ");
	foreach($qry->fetch_array() as $k => $val){
		$$k=$val;

		}
?>
<div class="modal fade" id="edit--user" tabindex="-1" role="dialog" aria-labelledby="viewuserLabel" aria-hidden="true">
	<div class="modal-dialog" role="document" style="margin: 5% 32%;">
	  <div class="modal-content">
		<div class="modal-header">
		  <h4 class="modal-title" id="exampleModalLabel">New Detail</h4>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		  </button>
		</div>
		<div class="modal-body">
		  <form action="admin_usercode.php" method="POST" id="new-user" enctype="multipart/form-data">
			  <div id="err"></div>	
			  <div class="form-group text-center" style="position: relative;" >
				  <span class="img-div">
				  <div class="text-center img-placeholder"  onClick="triggerClick()">
					  <h4>Update image</h4>
				  </div>
				  <img src="'.$photo.'" onClick="triggerClick()" id="profileDisplay">
				  </span>
				  <input type="file" name="profileImage" onChange="displayImage(this)" id="profileImage" class="form-control" style="display: none;">
				  <label>Profile Image</label>
				</div>			
  
			  <div class="form-group">
				  <label for="" class="control-label">Name</label>
				  <input type="text" class="form-control" id="editusername" name="editusername" value="'.$name.'">
			  </div>
			  <div class="form-group">
				  <label for="" class="control-label">Email</label>
				  <input type="email" class="form-control" name="editemail" value="'.$email.'">
			  </div>		
			  <input id="username" style="display:none" type="text" name="fakeusernameremembered">
				<input id="password" style="display:none" type="password" name="fakepasswordremembered">	
			  <div class="form-group">
				  <label for="username">Username</label>
				  <input type="text" name="editdname" id="editdname" value="'.$username.'" class="form-control" autocomplete="off" required >
			  </div>
			  <div class="form-group">
			  <label for="password">Password</label>
				  <input type="password" name="editdword" id="editdword" value="'.$password.'" class="form-control"  autocomplete="off" required>
			  </div>		
			  <div class="form-group">
				  <label for="" class="control-label">Account Type</label>
					  <select name="editaccounttype" class="custom-select select2" required>
						  <option >Admin</option>
						  <option >Staff</option>
					  </select>
			  </div>
			  <div class="modal-footer">
				  <button type="submit" class="btn btn-primary" name="editusersubmit">Save</button>
				  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			  </div>
		  </form>
		</div>
	  </div>
	</div>
  </div>

