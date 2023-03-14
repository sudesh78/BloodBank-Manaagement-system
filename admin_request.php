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
						<span class="float:right"><a class="btn btn-primary btn-block btn-sm col-sm-2 float-right" href="javascript:void(0)" id="new_request" data-target="#new-req" data-toggle="modal">
					<i class="fa fa-plus"></i> New Entry
				</a></span>
					</div>
					<div class="card-body">
						<table class="table table-condensed table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="">Date</th>
									<th class="">Referrence Code</th>
									<th class="">Patient Name</th>
									<th class="">Blood Group</th>
									<th class="">Information</th>
									<th class="">Status</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$requests = $conn->query("SELECT * FROM request order by date(date_created) desc ");
								while($row=$requests->fetch_assoc()):
									
								?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td>
										<?php echo date('M d, Y',strtotime($row['date_created'])) ?>
									</td>
									<td class="">
										 <p> <b><?php echo $row['ref_code'] ?></b></p>
									</td>
									<td class="">
										 <p> <b><?php echo ucwords($row['name']) ?></b></p>
									</td>
									<td class="">
										 <p> <b><?php echo $row['blood'] ?></b></p>
									</td>
									<td class="">
										 <p>Volume Needed: <b><?php echo  ($row['bunit']).' mL' ?></b></p>
										 <p>Physician Name: <b><?php echo ucwords($row['doc_name']) ?></b></p>
									</td>
									<td class=" text-center">
										<?php if($row['status'] == 0): ?>
											<span class="badge badge-secondary">Pending</span>
										<?php elseif($row['status'] == 1): ?>
											<span class="badge badge-primary">Approved</span>
										<?php elseif($row['status'] == 2): ?>
											<span class="badge badge-success">Completed</span>	
										<?php endif; ?>

									</td>
									<td class="text-center">
										<button class="btn btn-sm btn-outline-primary edit_request" type="button" data-id="<?php echo $row['r_id'] ?>" >Edit</button>
										<button class="btn btn-sm btn-outline-danger delete_request" type="button" data-toggle="modal" data-target="#deletereq" data-id="<?php echo $row['r_id'] ?>">Delete</button>
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

<div class="modal fade" id="new-req" tabindex="-1" role="dialog" aria-labelledby="view-doLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="margin: 5% 32%;">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">New Request</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<form action="admin_reqcode.php" method="POST" id="newreq" enctype="multipart/form-data">
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
				<label class="control-label">Patient Name</label>
				<input type="text" placeholder="Patient Name" name="NAME"   id="NAME" class="form-control">
			</div>
			<div class="form-group">
				<label class="control-label"  for="GENDER">Gender</label>
				<select id="gen" name="GENDER"  class="form-control">
					<option value="">Select Gender</option>
					<option value="Male">Male</option>
					<option value="Female">Female</option>
				</select>
			</div>
			<div class="form-group"> 
				<label class="control-label"> Blood Group</label>
				<select name="BLOOD" id="BLOOD"   class="form-control">
					<option value="">Select Blood</option>
					<option value="A+">A+</option>
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
				<label class="control-label">Blood Needed</label>
				<input type="text"  name="BUNIT" id="BUNIT" class="form-control" placeholder="Insert blood in mL">
			</div>
			<div class="form-group">
				<label class="control-label">Hospital Name &amp; Address</label>
				<textarea  name="HOSP" id="HOSP" rows="5" style="resize:none;"class="form-control" placeholder="Hospital Full Address"></textarea>
			</div>
			<div class="form-group">
				<label class="control-label">City</label>
				<input type="text"  name="CITY" id="CITY" class="form-control" placeholder="Insert City">
			</div>
			<div class="form-group">
				<label class="control-label">Pincode</label>
				<input type="text"  name="PIN" id="PIN" class="form-control" placeholder="Insert Pincode">
			</div>
			<div class="form-group">
				<label class="control-label">Doctor Name</label>
				<input type="text" placeholder="Doctor Name" class="form-control " name="DOC" id="DOC">
			</div>
			<div class="form-group">
				<label class="control-label">When Required </label>
				<input type="date" class="form-control" name="RDATE" id="RDATE" value="" required>
			</div>
				
				<div class="form-group">
					<label class="control-label">Contact Name</label>
					<input type="text" placeholder="Contact Name" class="form-control " name="CNAME" id="CNAME">
				</div>
				<div class="form-group">
						<label class="control-label">Address</label>
						<textarea  name="CADDRESS" id="CADDRESS" rows="5" style="resize:none;"class="form-control" placeholder="Full Address"></textarea>
					</div>
				<div class="form-group">
					<label class="control-label" for="EMAIL" >Email ID</label>
					<input type="email"   name="EMAIL" id="EMAIL" class="form-control" placeholder="Email Address">
				</div>
				<div class="form-group">
					<label class="control-label">Contact No-</label>
					<input type="text" placeholder="Contact Number" class="form-control " name="CON1" id="CON1">
				</div>

				<div class="form-group">
					<label class="control-label">Reason For Blood</label>
					<textarea  name="REASON" id="REASON" rows="5" style="resize:none;"class="form-control" placeholder="Reason For Blood" name="REASON" id="REASON"></textarea>
				</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary" name='newreqsubmit'>Save</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			</div>
			<div id="err"></div>
		</form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="edit-req" tabindex="-1" role="dialog" aria-labelledby="view-doLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="margin: 5% 32%;">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Edit Request</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<form action="admin_reqcode.php" method="POST" id="editreq" enctype="multipart/form-data">
			<input type="hidden" id="er_id" name="er_id" value="">
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
				<label class="control-label">Patient Name</label>
				<input type="text" placeholder="Patient Name" name="ENAME"   id="ENAME" class="form-control">
			</div>
			<div class="form-group"> 
				<label class="control-label"> Blood Group</label>
				<input type="text" class="form-control" name="EBLOOD" id="EBLOOD"  value="" readonly>
			</div>
			<div class="form-group">
				<label class="control-label">Blood Needed</label>
				<input type="text"  name="EBUNIT" id="EBUNIT" class="form-control" placeholder="Insert blood in mL">
			</div>
			<div class="form-group">
				<label class="control-label">Hospital Name &amp; Address</label>
				<textarea  name="EHOSP" id="EHOSP" rows="5" style="resize:none;"class="form-control" placeholder="Hospital Full Address"></textarea>
			</div>
			<div class="form-group">
				<label class="control-label">Doctor Name</label>
				<input type="text" placeholder="Doctor Name" class="form-control " name="EDOC" id="EDOC">
			</div>
			<div class="form-group">
				<label class="control-label">When Required </label>
				<input type="date" class="form-control" name="ERDATE" id="ERDATE">
			</div>
			<div class="form-group">
				<label for="" class="control-label">Status</label>
				<select name="estatus" id="estatus" class="custom-select" required>
					<option value="0">Pending</option>
					<option value="1">Approved</option>
					<option hidden value="2">Completed</option>
				</select>
				<input type="text" class="form-control" id="ecstatus" readonly style="display:none;">

			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary" name='editreqsubmit'>Save</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			</div>
			<div id="err"></div>
		</form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="deletereq" tabindex="-1" role="dialog" aria-labelledby="deletereqLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  	<form action="admin_reqcode.php" method="POST">
			<input type="hidden" name="del_rid" id="del_rid">
			<h4> Do you want to Delete this Request </h4>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary" name="delete_req">Yes</button>
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
											

	$(document).ready(function(){
		$('table').dataTable()
	})
	$(document).ready(function () {
		$( ".datepicker" ).datepicker();
	});
	$(".edit_request").click(function (e){ 
		e.preventDefault();
		var rid = $(this).attr("data-id");
		$.ajax({
			type: "POST",
			url: "admin_reqcode.php",
			data:{
				'checking_editreq': true,
				'rid':rid,
			},
			success: function (response) {
				$.each(response,function(key,value)
				{
					$('#er_id').val(value['r_id']);
					$('#ENAME').attr('value',value['name']);
					$('#EBLOOD').val(value['blood']);
					$('#EBUNIT').val(value['bunit']);
					$('#EHOSP').val(value['hosp']);
					$('#EDOC').val(value['doc_name']);
					$('#ERDATE').val(value['rdate']);
					$('#estatus').val(value['status']);
					$('#profiledis').attr('src',value['pic']);
					$('#fakepic').attr('value',value['pic']);
					if(value['status']==2)
					{
						$('#ecstatus').val("Completed");
						$('#estatus').hide('hide');
						$('#ecstatus').show('show');
					}
					else{
						$('#estatus').show('show');
						$('#ecstatus').hide('hide');
					}
					$('#edit-req').modal('show');
				});

			}
		});
	});
	$(".delete_request").click(function (e) { 
		e.preventDefault();
		var id = $(this).attr("data-id");
		$("#del_rid").val(id);
	});

</script>