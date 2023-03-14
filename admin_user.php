
<?php 
$conn=new mysqli("localhost","root","","blood_donate");
if(mysqli_connect_error())
{
	die('Connect Error('. mysqli_connect_errno().')'.mysqli_connect_error());
}

?>
<style>
	.text-center{
		text-align: center;
	}
	.si{
		font-size: 1.2rem;
		font-weight: bold;
		height: 2rem;
	}
	.ri{
		padding: 8px 0;
		font-size: 17px;
	}
	.form-div { margin-top: 100px; border: 1px solid #e0e0e0; }
#profileDisplay,#profileDis { display: block; height: 210px; width: 60%; margin: 0px auto; border-radius: 50%; }
.img-placeholder {
  width: 60%;
  color: white;
  height: 100%;
  background: black;
  opacity: .7;
  height: 210px;
  border-radius: 50%;
  z-index: 2;
  position: absolute;
  left: 50%;
  transform: translateX(-50%);
  display: none;
}
.img-placeholder h4 {
  margin-top: 40%;
  color: white;
}
.img-div:hover .img-placeholder {
  display: block;
  cursor: pointer;
}
</style>

<div class="container-fluid">
	
	<div class="col-lg-12">
		<div class="row mb-4 mt-4">
			<div class="col-md-12">
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<b>List of Requests</b>
						<span class="float:right"><a class="btn btn-primary float-right btn-sm" id="new_user" data-target="#new--user" data-toggle="modal">
					<i class="fa fa-plus"></i> New User
				</a></span>
					</div>
					<div class="card-body">
			<table class="table-striped table-bordered col-md-12">
				<thead>
					<tr>
						<th class="text-center si">Id</th>
						<th class="text-center si ">Name</th>
						<th class="text-center si">Username</th>
						<th class="text-center si">Type</th>
						<th class="text-center si">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$users = $conn->query("SELECT * FROM admin order by id");
						while($row= $users->fetch_assoc()):
					?>
					<tr class="text-center">
						<td class="ri">
							<?php echo $row['id']?>
						</td class="ri">
						<td class="ri">
							<?php echo ucwords($row['name']) ?>
						</td>
						
						<td class="ri">
							<?php echo $row['username'] ?>
						</td>
						<td class="ri">
							<?php echo $row['type'] ?>
						</td>
						<td class="ri">
							<button class="btn btn-sm btn-outline-primary edit_user" data-id="<?php echo $row['username'] ?>" type="button"> Edit </button>
							<button class="btn btn-sm btn-outline-danger delete_user" type="button" data-toggle="modal" data-target="#deletemodal" data-id="<?php echo $row['id'] ?>">Delete</button>
						</td>
					</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
					</div>
				</div>
			</div>
		</div>
	</div>	
</div>
<!-- ########################################### New Account ##########################################################################################-->

<div class="modal fade" id="new--user" tabindex="-1" role="dialog" aria-labelledby="viewuserLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="margin: 5% 32%;">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">New User</h4>
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
				<img src="images/avatar.jpeg" onClick="triggerClick()" id="profileDisplay">
				</span>
				<input type="file" name="profileImage" onChange="displayImage(this)" id="profileImage" class="form-control" style="display: none;">
				<label>Profile Image</label>
          	</div>		

			<div class="form-group">
				<label for="" class="control-label">Name</label>
				<input type="text" class="form-control" id="newusername" name="newusername">
			</div>
			<div class="form-group">
				<label for="" class="control-label">Email</label>
				<input type="email" class="form-control" name="newemail" >
			</div>		
			<input id="username" style="display:none" type="text" name="fakeusernameremembered">
  			<input id="password" style="display:none" type="password" name="fakepasswordremembered">	
			<div class="form-group">
				<label for="username">Username</label>
				<input type="text" name="newdname" id="newdname" class="form-control" autocomplete="off" required >
			</div>
			<div class="form-group">
			<label for="password">Password</label>
				<input type="password" name="newdword" id="newdword" class="form-control" autocomplete="off" required>
			</div>		
			<div class="form-group">
				<label for="" class="control-label">Account Type</label>
					<select name="newaccounttype" class="custom-select select2" required>
						<option value="" >Select Account Type</option>
						<option value="Admin">Admin</option>
						<option value="Staff">Staff</option>
					</select>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary" name='newusersubmit'>Save</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			</div>
		</form>
      </div>
    </div>
  </div>
</div>

<!--########################################### Manage account #################################################################-->
<div class="modal fade" id="edit__user" tabindex="-1" role="dialog" aria-labelledby="viewuserLabel" aria-hidden="true">
	<div class="modal-dialog" role="document" style="margin: 5% 32%;">
	  <div class="modal-content">
		<div class="modal-header">
		  <h4 class="modal-title" id="exampleModalLabel">Manage Detail</h4>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		  </button>
		</div>
		<div class="modal-body">
		  <form action="admin_usercode.php" method="POST" id="new-user" enctype="multipart/form-data">
		  	  <input type='hidden' name='eid' id='eid' value="">
			  <div class="form-group text-center" style="position: relative;" >
				  <span class="img-div">
				  <div class="text-center img-placeholder"  onClick="triggerClck()">
					  <h4>Update image</h4>
				  </div>
				  <img src="" onClick="triggerClck()" id="profiledis">
				  </span>
				  <input type="hidden" id="fakepic" name="fakepic" value="">	
				  <input type="file" name="profileImg" onChange="displayImg(this)" id="profileImg" value="" class="form-control" style="display: none;">
				  <label>Profile Image</label>
				</div>					
			  <div class="form-group">
				  <label for="" class="control-label">Name</label>
				  <input type="text" class="form-control" id="editusername" name="editusername">
			  </div>
			  <div class="form-group">
				  <label for="" class="control-label">Email</label>
				  <input type="email" class="form-control" name="editemail" id="editemail">
			  </div>		
			  <input id="username" style="display:none" type="text" name="fakeusernameremembered">
				<input id="password" style="display:none" type="password" name="fakepasswordremembered">	
			  <div class="form-group">
				  <label for="username">Username</label>
				  <input type="text" name="editdname" id="editdname" class="form-control" autocomplete="off" required >
			  </div>
			  <div class="form-group">
			  <label for="password">Password</label>
				  <input type="password" name="editdword" id="editdword" class="form-control"  autocomplete="off" required>
			  </div>		
			  <div class="form-group">
				  <label class="control-label">Account Type</label>
					  <select name="editaccounttype" id="editaccounttype" class="custom-select select2" required>
						  <option value="Admin">Admin</option>
						  <option value="Staff">Staff</option>
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


<!--########################################### Delete account #################################################################-->

<div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="deletemodalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  	<form action="admin_usercode.php" method="POST">
			<input type="hidden" name="del_id" id="del_id">
			<h4> Do you want to Delete this User </h4>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary" name="delete_use">Yes</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
			</div>
	  	</form>
      </div>
    </div>
  </div>
</div>

<script>
	function triggerClick(e) {
  		document.querySelector('#profileImage').click();
	};

	function displayImage(e) {
  		if (e.files[0]) {
    		var reader = new FileReader();
    		reader.onload = function(e){
      			document.querySelector('#profileDisplay').setAttribute('src', e.target.result);
    		}
    	reader.readAsDataURL(e.files[0]);
  		}
	};
///////////////////////////////////////////////////////////
	function triggerClck(e) {
  		document.querySelector('#profileImg').click();
	};

	function displayImg(e) {
  		if (e.files[0]) {
    		var reader = new FileReader();
    		reader.onload = function(e){
      			document.querySelector('#profileDis').setAttribute('src', e.target.result);
    		}
    	reader.readAsDataURL(e.files[0]);
  		}
	};
	
	$(".edit_user").click(function (e){ 
		e.preventDefault();
		var user = $(this).attr("data-id");
		$.ajax({
			type: "POST",
			url: "admin_usercode.php",
			data:{
				'checking_editbtn': true,
				'user':user,
			},
			success: function (response) {
				$.each(response,function(key,value)
				{
					console.log(response);
					$('#eid').attr('value',value['id']);
					$('#editusername').val(value['name']);
					$('#editemail').val(value['email']);
					$('#editdname').val(value['username']);
					$('#editdword').val(value['password']);
					$('#editaccounttype').val(value['type']);
					$('#profiledis').attr('src',value['photo']);
					console.log(value['photo']);
					$('#fakepic').attr('value',value['photo']);
					$('#edit__user').modal('show');
				});
			}
		});
	});

	$(".delete_user").click(function (e) { 
		e.preventDefault();
		var id = $(this).attr("data-id");
		$("#del_id").val(id);
	});

</script>
