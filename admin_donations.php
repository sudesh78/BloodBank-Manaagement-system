<?php 
$conn=new mysqli("localhost","root","","blood_donate");
if(mysqli_connect_error())
{
	die('Connect Error('. mysqli_connect_errno().')'.mysqli_connect_error());
}
?>
<div class="container-fluid">
	<div class="col-lg-12">
		<div class="row mb-4 mt-4">
			<div class="col-md-12"></div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<b>List of Donations</b>
						<span class="float:right"><a class="btn btn-primary btn-block btn-sm col-sm-2 float-right" id="new_dona" data-target="#new_donation" data-toggle="modal">
					<i class="fa fa-plus"></i> New Entry
				</a></span>
					</div>
					<div class="card-body">
						<table class="table table-condensed table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="">Date</th>
									<th class="">Donor</th>
									<th class="">Blood Group</th>
									<th class="">Volume (ml)</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$donor = $conn->query("SELECT * FROM donors");
								while($row=$donor->fetch_assoc()){
									$dname[$row['d_id']] = ucwords($row['f_Name']);
									$dname1[$row['d_id']] = ucwords($row['l_Name']);

								}
								$donations = $conn->query("SELECT * FROM blood_inventory where status = 1 order by date(date_created) desc ");
								while($row=$donations->fetch_assoc()):
									
								?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td>
										<?php echo date('M d, Y',strtotime($row['date_created'])) ?>
									</td>
									<td class="">
										 <p> <b><?php echo isset($dname[$row['d_id']]) ? $dname[$row['d_id']]." ".$dname1[$row['d_id']] : 'Donor was removed from the list.' ?></b></p>
									</td>
									<td class="">
										 <p> <b><?php echo $row['blood_group'] ?></b></p>
									</td>
									<td class="">
										 <p><b><?php echo $row['volume']; ?></b></p>
									</td>
									<td class="text-center">
										<button class="btn btn-sm btn-outline-primary  edit_donation" type="button" data-id="<?php echo $row['id'] ?>" data-did="<?php echo $dname[$row['d_id']]." ".$dname1[$row['d_id']] ?>" >Edit</button>
										<button class="btn btn-sm btn-outline-danger delete_donation" type="button" data-toggle="modal" data-target="#deletedonmodal" data-id="<?php echo $row['id'] ?>">Delete</button>
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

<div class="modal fade" id="new_donation" tabindex="-1" role="dialog" aria-labelledby="newdonationLabel" aria-hidden="true">
	<div class="modal-dialog" role="document" style="margin: 5% 32%;">
	  <div class="modal-content">
		<div class="modal-header">
		  <h4 class="modal-title" id="exampleModalLabel">New Donation</h4>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		  </button>
		</div>
		<div class="modal-body">
			<form action="admin_usercode.php" method = "POST">
				<div id="msg"></div>
				<div class="form-group">
					<input type="hidden" name="status" value="1">				
					<label for="" class="control-label">Donor's Name</label>
					<select class="custom-select select2" name="donor_id" required>
					<option value=""></option>
						<?php 
						$qry = $conn->query("SELECT * FROM donors order by f_Name asc");
						while($row= $qry->fetch_assoc()):
						?>
						<option value="<?php echo $row['d_id'] ?>" data-bgroup="<?php echo $row['b_group'] ?>"><?php echo $row['f_Name'] ?></option>
						<?php endwhile; ?>
					</select>
				</div>
				<div class="form-group">
					<label for="" class="control-label">Blood Group</label>
					<input type="text" class="form-control" name="blood_group"  value="" required readonly>
					
				</div>
				<div class="form-group">
					<label for="" class="control-label">Volume (ml)</label>
					<input type="number" class="form-control text-right" step="any" name="volume"  value="" required>
				</div>
				<div class="form-group">
					<label for="" class="control-label">Date of Transfusion/Donation</label>
					<input type="date" class="form-control" name="date_created"  value="" required>
				</div>
				<div class="modal-footer">
				<button type="submit" class="btn btn-primary" name='newdonsubmit'>Save</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	  </div>
	</div>
</div>

  <div class="modal fade" id="edit_donation" tabindex="-1" role="dialog" aria-labelledby="editdonationLabel" aria-hidden="true">
	<div class="modal-dialog" role="document" style="margin: 5% 32%;">
	  <div class="modal-content">
		<div class="modal-header">
		  <h4 class="modal-title" id="exampleModalLabel">Edit Donation Detail's</h4>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		  </button>
		</div>
		<div class="modal-body">
			<form action="admin_usercode.php" method = "POST">
				<div id="msg"></div>
				<input type="hidden" name="eid" id="eid" value="">	
				<div class="form-group">			
					<label for="" class="control-label">Donor's Name</label>
					<div class="edname"></div>
				</div>
				<div class="form-group">
					<label for="" class="control-label">Blood Group</label>
					<input type="text" class="form-control" name="eblood_group" id="eblood_group"  value="" readonly>
				</div>
				<div class="form-group">
					<label for="" class="control-label">Volume (ml)</label>
					<input type="number" class="form-control text-right" step="any" name="evolume" id="evolume" value="" required>
				</div>
				<div class="form-group">
					<label for="" class="control-label">Date of Transfusion/Donation</label>
					<input type="date" class="form-control datepicker" name="edate_created" id="edate_created"  value="" required>
				</div>
				<div class="modal-footer">
				<button type="submit" class="btn btn-primary" name='editdonsubmit'>Save</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	  </div>
	</div>
  </div>

  <div class="modal fade" id="deletedonmodal" tabindex="-1" role="dialog" aria-labelledby="deletemodalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete Donation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  	<form action="admin_usercode.php" method="POST">
			<input type="hidden" name="del_did" id="del_did">
			<h4> Do you want to Delete this donation </h4>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary" name="delete_don">Yes</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
			</div>
	  	</form>
      </div>
    </div>
  </div>
</div>



<style>
	
	td{
		vertical-align: middle !important;
	}
	td p{
		margin: unset
	}
	img{
		max-width:100px;
		max-height: 150px;
	}
</style>

<script>

	$(document).ready(function(){
		$('table').dataTable()
	});

	$('[name="donor_id"]').change(function(){
		var _id = $(this).val()
		if(_id > 0){
			$('[name="blood_group"]').val($(this).find('option[value="'+_id+'"]').attr('data-bgroup'))
		}else{
			$('[name="blood_group"]').val('')
		}
	});

	$(".edit_donation").click(function (e){ 
		e.preventDefault();
		var id = $(this).attr("data-id");
		var did = $(this).attr("data-did");
		$.ajax({
			type: "POST",
			url: "admin_usercode.php",
			data:{
				'checking_editdon': true,
				'id':id,
			},
			success: function (response) {
				$.each(response,function(key,value)
				{
					$('#eid').attr('value',value['id']);
					$('#eblood_group').val(value['blood_group']);
					$('#evolume').val(value['volume']);
					$('#edate_created').val(value['date_created']);
					$('#edonor_name').val(value['name']);
					$('.edname').html("<input type='text' class='form-control' name='edonor_name' id='edonor_name' value='"+ did +"' readonly>");
					$('#edit_donation').modal('show');
				});
			}
		});
	});
	$(".delete_donation").click(function (e) { 
		e.preventDefault();
		var id = $(this).attr("data-id");
		$("#del_did").val(id);
	});


</script>