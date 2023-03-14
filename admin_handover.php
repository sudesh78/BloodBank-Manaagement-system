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
						<b>List of Handed Over Requests</b>
						<span class="float:right"><a class="btn btn-primary btn-block btn-sm col-sm-2 float-right" href="javascript:void(0)" id="new_handover" data-target="#newhand" data-toggle="modal">
					<i class="fa fa-plus"></i> New Entry </a></span>
					</div>
					<div class="card-body">
						<table class="table table-condensed table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="">Date</th>
									<th class="">Request's Ref. Code</th>
									<th class="">Patient Name</th>
									<th class="">Blood Group</th>
									<th class="">Information</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$handovers = $conn->query("SELECT hr.*,r.name,r.blood, r.bunit,r.ref_code FROM handedover_request hr inner join request r on r.r_id = hr.request_id order by date(hr.date_created) desc ");
								while($row=$handovers->fetch_assoc()):
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
										 <p>Volume Given: <b><?php echo  ($row['bunit'] / 1000).' L' ?></b></p>
										 <p>Received By: <b><?php echo ucwords($row['picked_up_by']) ?></b></p>
									</td>
									<td class="text-center">
										<button class="btn btn-sm btn-outline-danger delete_handover" type="button" data-toggle="modal" data-target="#delete-hand" data-id="<?php echo $row['id'] ?>">Delete</button>
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

<div class="modal fade" id="newhand" tabindex="-1" role="dialog" aria-labelledby="newhand" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: burlywood;">
        <h5 class="modal-title" id="exampleModalLabel" >New Entry</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="background: aliceblue;">
	  <form action="admin_reqcode.php" method="POST" id="new-handover">
        <div id="msg"></div>
        <div class="form-group">
            <label for="" class="control-label">Request's Reference Code</label>
            <input type="text" class="form-control" name="ref_code" id="ref_code"  value="" required>
        </div>
        <div class="form-group">
            <button class="btn btn-sm btn-primary" type="button" id="chk_request">Check</button>
        </div>
        <div class="form-group" id="request_details" style="padding: 0 12px;"></div>							
        <div class="form-group" style="display: none">
            <label for="" class="control-label">Received by: </label>
            <input type="text" class="form-control" name="picked_up_by"  value="" >
        </div>
		<div class="modal-footer">
			<button type="submit" class="btn btn-primary" name='newhandsubmit'>Save</button>
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
		</div>							
    	</form>
      </div>
  </div>
  </div>
</div>

<div class="modal fade" id="delete-hand" tabindex="-1" role="dialog" aria-labelledby="deletehandLabel" aria-hidden="true">
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
			<input type="hidden" name="del_hand" id="del_hand">
			<h4> Do you want to Delete this Record </h4>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary" name="delete_hand">Yes</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
			</div>
	  	</form>
      </div>
    </div>
  </div>
</div>

<script>
	$(document).ready(function(){
		$('table').dataTable()
	});

	$('#chk_request').click(function(){
        var ref_code = $('[name="ref_code"]').val();
		if (ref_code == '') {
      		$("#msg").html("<div class='alert alert-danger'>Reference box should not be empty.</div>");
   		}
		else{
			$.ajax({
			type: "POST",
			url: "admin_reqcode.php",
			data: {
				'chk_btn':true,
				'ref':ref_code,
			},
			success: function (resp) {
				if(resp==3){
					$('#msg').html('<div class="alert alert-danger">Unknown Reference Code.</div>');
				}else{
					$.each(resp, function(key, value){
					if(value['status'] == 1){
                        var _html = '';
                        _html += '<input type="hidden" name="request_id" value="'+value['r_id']+'">';
                        _html += '<p><b>Patient:</b> '+value['name']+'<b></b></p>';
                        _html += '<p><b>Blood Group: </b>'+value['blood']+'<b></b></p>';
                        _html += '<p><b>Volume Needed:</b> '+value['bunit']+' L<b></b></p>';
                        _html += '<p><b>Physician:</b> '+value['doc_name']+'<b></b></p>';
                        $('#request_details').html(_html);
                        $('[name="picked_up_by"]').parent().show();

                    }
					else if(value['status'] == 0){
                         $('#msg').html('<div class="alert alert-danger">Request is not approved yet.</div>');

                    }else if(value['status'] == 2){
                         $('#msg').html('<div class="alert alert-danger">Request already handed over.</div>');

                    }
				});
				}
			}
		});
		}
    })
	$(".delete_handover").click(function (e) { 
		e.preventDefault();
		var id = $(this).attr("data-id");
		$("#del_hand").val(id);
	});
</script>