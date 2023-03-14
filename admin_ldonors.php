<?php 
$conn=new mysqli("localhost","root","","blood_donate");
if(mysqli_connect_error())
{
	die('Connect Error('. mysqli_connect_errno().')'.mysqli_connect_error());
}
if(isset($_GET['d_id'])){
	$qry = $conn->query("SELECT * FROM donors where d_id= ".$_GET['d_id']);
	foreach($qry->fetch_array() as $k => $val){
		$$k=$val;
	}
	}
?>
<!--############################################ Style ###############################-->
<style>
	.round-img{
		width:160%;
		height:300px;
		margin: 15px 100%;
	}
	.editimg {
    position: absolute;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    border: 1px solid grey;
    top: -17px;
    left: 263px;
    color: #6060bd;
    background: springgreen;
}
</style>
<!--############################################ Style ###############################-->
<!--############################################ MAIN Table ###############################-->
<div class="container-fluid" >
	
	<div class="col-lg-12">
		<div class="row mb-4 mt-4">
			<div class="col-md-12">
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<?php
						if(isset($_SESSION['status']) && $_SESSION['status'] !='')
						{
							?>
							<h5><?php echo $_SESSION['status']; ?></h5>
							<?php
								unset($_SESSION['status']);
						}
						?>
					<div class="card-header">
						<b>List of Donors</b>
						<span class="float:right"><a class="btn btn-primary btn-block btn-sm col-sm-2 float-right"  id="new_donor" data-target="#new-do" data-toggle="modal">
					<i class="fa fa-plus"></i> New Entry
				</a></span>
					</div>
					<div class="card-body">
						<table class="table table-condensed table-bordered table-hover" id="ldonor">
							<thead>
								<tr>
									<th class="text-center">D_id</th>
									<th class="">Image</th>
									<th class="">Donor Name</th>
									<th class="">Blood Group</th>
									<th class="">Information</th>
									<th class="">Previuos Donation</th>
									<th class="text-center">Action</th>
									<th class="text-center">Status</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$donor = $conn->query("SELECT * FROM donors order by d_id ");
                                while($row=$donor->fetch_assoc())
                                {
									if($row['last_d_date']==null || $row['last_d_date']=="0000-00-00"){
                                        $prev= "New";
                                    }
                                    else{
                                        $prev = $row['last_d_date'];
									}
								?>
								<tr>
									<td class="text-center"><?php echo $row['d_id'] ?></td>
									
									<td class=""><img src="<?php echo $row['photo'] ?>" style="width: 100px; height: 100px;" ></td>
									<td class="">
										 <p> <b><?php echo ucwords($row['f_Name'])," ",ucwords($row[ 'l_Name']); ?></b></p>
									</td>
									<td class="">
										 <p> <b><?php echo $row['b_group'] ?></b></p>
									</td>
                                
									<td class="">
										 <p>Email: <b><?php echo $row['email']; ?></b></p>
										 <p>Contact 1: <b><?php echo $row['Contact1']; ?></b></p>
										 <p>Contact 2: <b><?php echo !empty($row['Contact2']) ? $row['Contact2']: "unavailable" ?></b></p>
										 <p>Address: <b><?php echo ucwords($row['street'])," ",ucwords($row['area'])," ",ucwords($row['city'])," ",ucwords($row['state']); ?></b></p>
									</td> 
									<td>
										<?php echo $prev ?>
									</td>
									<td class="text-center">
										<button class="btn btn-sm btn-outline-primary view_donor" type="button" data-target="#view-do" data-toggle="modal" data-id="<?php echo $row['d_id'] ?>" >View</button>
										<button class="btn btn-sm btn-outline-primary edit_donor" type="button" data-id="<?php echo $row['d_id'] ?>" >Edit</button>
										<button class="btn btn-sm btn-outline-danger delete_donor" type="button" data-toggle="modal" data-target="#deletemodal" data-id="<?php echo $row['d_id'] ?>">Delete</button>
									</td>
									<td class="text-center"><?php 
									
										$status=$row["status"];
										if($status==0)
										{
											echo'<a href="admin_activate.php?id='.$row["d_id"].'" class="btn btn-sm btn-danger">Activate Now</a>';
										}
										else
										{
											echo'<a href="admin_deactivate.php?id='.$row["d_id"].'" class="btn btn-sm btn-success">Deactivate Now</a>';
										}
									
									?></td>
								</tr>
                            <?php   } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>	
</div>
<!--################################# New DONOR ################################################################-->
<div class="modal fade" id="new-do" tabindex="-1" role="dialog" aria-labelledby="view-doLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="margin: 5% 32%;">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">New Detail</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<form action="admin_code.php" method="POST" id="newform" enctype="multipart/form-data">
			<div class="form-group">
				<label for="" class="control-label">First Name</label>
				<input type="text" class="form-control" id="newfirstname" name="newfirstname">
			</div>
			<div class="form-group">
			<label for="" class="control-label">Last Name</label>
				<input type="text" class="form-control" name="newlastname"  >
			</div>
			<div class="form-group">
				<label for="" class="control-label">Father Name</label>
				<input type="text" class="form-control" name="newfname"  >
			</div>
			<div class="form-group">
				<label for="" class="control-label">DOB</label>
				<input type="date" class="form-control datepicker" name="newdob" >
			</div>
			<div class="form-group">
				<label for="" class="control-label">Gender</label>
				<select name="newgender" class="custom-select select2" >
					<option value="Male">Male</option>
					<option value="Female">Female</option>
				</select>
			</div>
			<div class="form-group">
				<label for="" class="control-label">Blood Group</label>
				<select name="newblood_group" class="custom-select select2" >
					<option value="A+" >A+</option>
					<option value="B+">B+</option>
					<option value="O+">O+</option>
					<option value="AB+">AB+</option>
					<option value="A-">A-</option>
					<option value="B-">B-</option>
					<option value="O-">O-</option>
					<option value="AB-">AB-</option>
				</select>
			</div>
			<div class="form-group">
				<label for=""  class="control-label">Body Weight</label>
				<input type="text" class="form-control" name="newweight" >
			</div>
			<label for="" class="control-label">Address</label>
			<div class="form-group">
				<input type="street" name="newstreet" class="form-control " placeholder="Street" >
				<input type="area" name="newarea" class="form-control" placeholder="Area" >
				<input type="city" name="newcity" class="form-control last" placeholder="City" >
				<input type="zip" name="newpincode" class="form-control last" placeholder="Pincode" >
				<input type="state" class="form-control" name="newstate" placeholder="State" >
				<input type="country" class="form-control" name="newcountry" placeholder="Country" >
			</div>
			<div class="form-group">
				<label for="" class="control-label">Email</label>
				<input type="email" class="form-control" name="newemail" >
			</div>
			<div class="form-group">
				<label for="" class="control-label">Contact 1</label>
				<input type="text" class="form-control" name="newcontact1" >
			</div>
			<div class="form-group">
				<label for="" class="control-label">Contact 2</label>
				<input type="text" class="form-control" name="newcontact2" >
			</div>
			<div class="form-group">
				<label for="" class="control-label">Last Donated</label>
				<input type="date" class="form-control datepicker" name="newldonate" >
			</div>

			<div class="form-group">
				<label for="" class="text-success" for="fileToUpload" >Upload Photo</label>
				<input type="file" class="form-control" name="newfileToUpload">
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary" name='newsubmitbtn'>Save</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			</div>
			<div id="err"></div>
		</form>
      </div>
    </div>
  </div>
</div>		
<!--################################# New DONOR ################################################################-->
<!--################################# View DONOR ################################################################-->
<div class="modal fade" id="view-do" tabindex="-1" role="dialog" aria-labelledby="view-doLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="margin: 5% 32%;">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Donor Detail</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
			<div class="viewing_data"></div>
      </div>
    </div>
  </div>
</div>								
<!--################################# Edit DONOR ################################################################-->
<div class="modal fade" id="edit_do" tabindex="-1" role="dialog" aria-labelledby="edit_doTitle" aria-hidden="true">
  <div class="modal-dialog" role="document" style="margin: 5% 32%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit Donor's Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  <form action="admin_code.php" method="POST"  enctype="multipart/form-data">
		<div class="col-md-4">
			<div class="panel">
				<div class="panel-body">
					<div id="editimgview"></div>
				</div>
			</div> 
		</div>
		<div class="idd"></div>
		<div class="form-group" id="DonorPic">
			
		</div>
		<div class="form-group">
			<label for="" class="control-label">First Name</label>
			<input type="text" class="form-control" name="editfirstname" id="editfirstname"required>
		</div>
		<div class="form-group">
			<label for="" class="control-label">Last Name</label>
			<input type="text" class="form-control" name="editlastname" id="editlastname"required>
		</div>
		<div class="form-group">
			<label for="" class="control-label">Father Name</label>
			<input type="text" class="form-control" name="editfname" id="editfname" required>
		</div>
		<div class="form-group">
			<label for="" class="control-label">DOB</label>
			<input type="text" class="form-control datepicker" name="editdob" id="editdob"required>
		</div>
		<div class="form-group">
			<label  class="control-label">Gender</label>
			<select id="editgender" name="editgender" class="custom-select" >
				<option value="Male">Male</option>
				<option value="Female">Female</option>
			</select>
		</div>
		<div class="form-group">
	        <label for="" class="control-label">Blood Group</label>
			<select name="editblood_group" id="editblood_group" class="custom-select" required>
				<option value="A+">A+</option>
				<option value="A-">A-</option>
				<option value="B+">B+</option>
				<option value="B-">B-</option>
				<option value="O+">O+</option>
				<option value="O-">O-</option>
				<option value="AB+">AB+</option>
				<option value="AB-">AB-</option>
			</select>
		</div>
		<div class="form-group">
			<label for="" class="control-label">Body Weight</label>
			<input type="text" class="form-control" name="editweight" id="editweight" required>
		</div>
		<label for="" class="control-label">Address</label>
		<div class="form-group da">
			<input type="street" name="editstreet" id="editstreet" class="form-control " placeholder="Street"required>
			<input type="area" name="editarea" id="editarea" class="form-control" required="" placeholder="City">
			<input type="zip" name="editpincode" id="editpincode" class="form-control last" required="" placeholder="Pincode">
			<input type="city" name="editcity" id="editcity" class="form-control last" placeholder="City">
			<input type="state" class="form-control" name="editstate" id="editstate" required="" placeholder="State" >
			<input type="country" class="form-control" name="editcountry" id="editcountry" required="" placeholder="Country">
        </div>
		<div class="form-group">
			<label for="" class="control-label">Email</label>
			<input type="email" class="form-control" name="editemail" id="editemail" required>
		</div>
		<div class="form-group">
			<label for="" class="control-label">Contact 1</label>
			<input type="text" class="form-control" name="editcontact1" id="editcontact1"required>
		</div>
		<div class="form-group">
			<label for="" class="control-label">Contact 2</label>
			<input type="text" class="form-control" name="editcontact2" id="editcontact2" placeholder="Optional">
		</div>
		<div class="form-group">
			<label for="" class="control-label">Last Donated</label>
			<input type="text" class="form-control datepicker" name="editldonate" id="editldonate" placeholder="Optional">
		</div>
		<div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-primary" name="update_sub" >Update</button>
	</div>
	</form>
    </div>
    </div>
  </div>
</div>
<!--########################################################### Edit DONOR ################################################################-->

<div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="deletemodalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete Donor </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  	<form action="admin_code.php" method="POST">
			<input type="hidden" name="delete_id" id="delete_id">
			<h4> Do you want to Delete this Donor </h4>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary" name="deletedata">Yes</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
			</div>
	  	</form>
      </div>
    </div>
  </div>
</div>
<!--############################################################# SCRIPT #######################################################-->
<script>
	$(document).ready(function(){
		$('table').dataTable()
	})
	$(document).ready(function () {
		$( ".datepicker" ).datepicker();
	});

	$(".view_donor").click(function (e) { 
		e.preventDefault();
		var d_id = $(this).attr("data-id");
		$.ajax({
			type: "POST",
			url: "admin_code.php",
			data:{
				'checking_viewbtn': true,
				'd_id':d_id,
			},
			success: function (response) {
				$('.viewing_data').html(response);
				$('.view_do').modal('show');
			}
		});
	});

	$(".edit_donor").click(function (e){ 
		e.preventDefault();
		var d_id = $(this).attr("data-id");
		$.ajax({
			type: "POST",
			url: "admin_code.php",
			data:{
				'checking_editbtn': true,
				'd_id':d_id,
			},
			success: function (response) {
				$.each(response,function(key,value)
				{
					$('#editfirstname').val(value['f_Name']);
					$('#editfirstname').val(value['f_Name']);
					$('#editlastname').val(value['l_Name']);
					$('#editfname').val(value['father_name']);
					$('#editdob').val(value['dob']);
					$('#editgender').val(value['gender']);
					$('#editblood_group').val(value['b_group']);
					$('#editweight').val(value['weight']);
					$('#editstreet').val(value['street']);
					$('#editarea').val(value['area']);
					$('#editcity').val(value['city']);
					$('#editpincode').val(value['pincode']);
					$('#editstate').val(value['state']);
					$('#editcountry').val(value['country']);
					$('#editemail').val(value['email']);
					$('#editcontact1').val(value['Contact1']);
					$('#editcontact2').val(value['Contact2']);
					$('#editldonate').val(value['last_d_date']); 
					var pic = value['photo']; 
					$('#editimgview').html("<img src='"+pic+"'class='round-img''>");
					$('.idd').html("<input type='hidden' name='id' id='d_id' value=" + value['d_id'] + ">");
					$('#DonorPic').html("<label class='control-label'>Change Image</label><input type='file' class='form-control' name='donor_img'><input type='hidden' class='form-control' name='donor_img_old' value="+ pic+" >");
					$('#edit_do').modal('show');
				});
			}
		});
	});
	$(".delete_donor").click(function (e) { 
		e.preventDefault();
		var d_id = $(this).attr("data-id");
		$("#delete_id").val(d_id);
		
	});
		
</script>