<?php 
    session_start();
	$_SESSION['message'] = '';

    $con=new mysqli("localhost","root","","blood_donate");
	if(mysqli_connect_error())
	{
		die('Connect Error('. mysqli_connect_errno().')'.mysqli_connect_error());
	}

	if($_SERVER['REQUEST_METHOD']=='POST')
	{
		$name=$_POST['NAME'];
		$gender=$_POST['GENDER'];
		$bg=$_POST['BLOOD'];
		$bu=$_POST['BUNIT'];
		$hosp=$_POST['HOSP'];
		$city=$_POST['CITY'];
		$pincode=$_POST['PIN'];
		$doc=$_POST['DOC'];
		$rdate=$_POST['RDATE'];
		$cname=$_POST['CNAME'];
		$cadd=$_POST['CADDRESS'];
		$cont1=$_POST['CON1'];
		$reas=$_POST["REASON"];
		$email=$con->real_escape_string($_POST['EMAIL']);
		$dt=date("Y-m-d");

		$avatar_path = $con->real_escape_string('requestor/'.$_FILES['fileToUpload']['name']);
		
		if(preg_match("!image!",$_FILES['fileToUpload']['type']))
		{
			if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'],$avatar_path))
			{
				$sql="
					INSERT INTO request(name,gender,blood,bunit,hosp,city,pincode,doc_name,rdate,c_name,c_address,email,contact,reason,pic)
					VALUES 
					('$name','$gender','$bg', $bu,'$hosp','$city',$pincode,'$doc','$dt','$cname','$cadd','$email',$cont1,'$reas','$avatar_path');
                    ";
					
				if($con->query($sql)==true)
				{
					$_SESSION['message']="Registration successful! Donor $name added to database !";
					header("location: req.php");
				}
				else{
					$_SESSION['message']="Donor could not be added to the database";
				}
			}
			else{
				$_SESSION['message']="File upload failed!";
			}
		}
		else{
			$_SESSION['message']="Please only upload GIF, JPG , or PNG images";
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php include("include/head.php");?>
    <link rel="stylesheet" type="text/css" href="css/req.css">
</head>
<body>
    <?php include("include/nav.php"); ?>
    <div class="hero">
        <div class="s-upper">
            <h3 class="u-tex"><i class="fa fa-user-md"> Request Blood</i> </h3><hr>
        </div>
        <div class="main">
            <div class="head">
                <p><i class="fa fa-user-md"> Request-Blood</i></p>
            </div>
            <div class="form f">
                <form method="POST" action="req.php"  enctype="multipart/form-data">
					<div class="alert alert-error"><?= $_SESSION['message'] ?></div>
					<div class="form-group">
						<label class="color name">Patient Name</label>
						<input type="text" placeholder="Patient Name" name="NAME"  required id="NAME" class="form-control input-sm">
					</div>
                    <div class="form-group">
						<label class="color name"  for="GENDER">Gender</label>
						<select id="gen" name="GENDER" required class="form-control input-sm">
							<option value="">Select Gender</option>
							<option value="Male">Male</option>
							<option value="Female">Female</option>
						</select>
					</div>
                    <div class="form-group"> 
						<label class="color name">Required Blood Group</label>
						<select name="BLOOD" id="BLOOD" required  class="form-control input-sm">
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
						<label class="color name">Blood Needed</label>
                        <input type="text" required name="BUNIT" id="BUNIT" class="form-control" placeholder="Insert blood in mL">
                    </div>
					<div class="form-group">
						<label class="color name">Hospital Name &amp; Address</label>
                        <textarea required name="HOSP" id="HOSP" rows="5" style="resize:none;"class="form-control" placeholder="Hospital Full Address"></textarea>
                    </div>
					<div class="form-group">
						<label class="color name">City</label>
                        <input type="text" required name="CITY" id="CITY" class="form-control" placeholder="Insert City">
                    </div>
					<div class="form-group">
						<label class="color name">Pincode</label>
                        <input type="text" required name="PIN" id="PIN" class="form-control" placeholder="Insert Pincode">
                    </div>
					<div class="form-group">
					    <label class="color name">Doctor Name</label>
						<input type="text" placeholder="Doctor Name" class="form-control input-sm" name="DOC" id="DOC">
					</div>
					<div class="form-group">
						<label class="color name">When Required</label>
						<input type="date" class="form-control input-sm DATES datepicker" name="RDATE" id="RDATE">
					</div>
						
						<div class="form-group">
							<label class="color name">Contact Name</label>
							<input type="text" placeholder="Contact Name" class="form-control input-sm" name="CNAME" id="CNAME">
						</div>
						<div class="form-group">
								<label class="color name">Address</label>
                                <textarea required name="CADDRESS" id="CADDRESS" rows="5" style="resize:none;"class="form-control" placeholder="Full Address"></textarea>
                          </div>
						<div class="form-group">
							<label class="color name" for="EMAIL" >Email ID</label>
                            <input type="email"  required name="EMAIL" id="EMAIL" class="form-control" placeholder="Email Address">
                        </div>
						<div class="form-group">
							<label class="color name">Contact No-</label>
							<input type="text" placeholder="Contact Number" class="form-control input-sm" name="CON1" id="CON1">
						</div>

						<div class="form-group">
							<label class="color name">Reason For Blood</label>
                            <textarea required name="REASON" id="REASON" rows="5" style="resize:none;"class="form-control" placeholder="Reason For Blood" name="REASON" id="REASON"></textarea>
                        </div>
                    
                        <div class="form-group">
							<label class="text-success" for="fileToUpload" >Upload Photo</label>
							<input type="file" class="form-control"  name="fileToUpload">
						</div>
						<div class="subm">
                                <div class="form-group">
                                    <button class="btns" type="submit" name="submit" >Request</button>
                                </div>
						</div>
                </form>
            </div>
        </div>
    </div>
    <?php include"include/footer.php";?>

<script>
		$(document).ready(function () {
		$( ".datepicker" ).datepicker();
	});

</script>
</body>
</html>