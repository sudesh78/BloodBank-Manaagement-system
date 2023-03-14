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
		$fname=$_POST['FNAME'];
		$lname=$_POST['LNAME'];
		$fathername=$_POST['FATHER_NAME'];
		$gender=$_POST['GENDER'];
		$dob=$_POST['DOB'];
		$bg=$_POST['BLOOD'];
		$bw=$_POST['BODY_WEIGHT'];
		$email=$con->real_escape_string($_POST['EMAIL']);
		$street=$_POST['street'];
		$area=$_POST['area'];
		$city=$_POST['city'];
		$pincode=$_POST['pincode'];
		$state=$_POST['state'];
		$country=$_POST['country'];
		$cont1=$_POST['CONTACT_1'];
		
		if(isset($_POST['CONTACT_2'])){
			$cont2=$_POST["CONTACT_2"];
		}
		else{
			$cont2=null;
		}
			
		$avatar_path = $con->real_escape_string('donorspic/'.$_FILES['fileToUpload']['name']);
		
		if(preg_match("!image!",$_FILES['fileToUpload']['type']))
		{
			if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'],$avatar_path))
			{
				$sql="
					INSERT INTO donors(f_name,l_name,father_name,gender,dob,b_group,weight,email,street,area,city,state,pincode,country,contact1,contact2,photo)
					VALUES 
					('$fname','$lname' , '$fathername', '$gender','$dob','$bg',$bw,'$email','$street','$area','$city','$state',$pincode,'$country',$cont1,$cont2,'$avatar_path');
                    ";
					
				if($con->query($sql)==true)
				{
					$_SESSION['status']="Successfully Saved";
					header("location: ldonor.php");
				}
				else{
					$_SESSION['status']="Donor could not be added to the database";
				}
			}
			else{
				$_SESSION['status']="File upload failed!";
			}
		}
		else{
			$_SESSION['status']="Please only upload GIF, JPG , or PNG images";
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include("include/head.php");?>
    <link rel="stylesheet" type="text/css" href="css/donor.css">
    <title>Document</title>
</head>
<body>
    <?php include("include/nav.php"); ?>
    
    <div class="hero ">
    <div class="s-upper">
        <h3 class="u-tex"><i class="fa fa-user-md"> Donor Registration</i> </h3><hr>
        </div>
        <div class="main">
            <div class="head">
                <p><i class="fa fa-user-md"> Donor Registration</i></p>
            </div>
            <div class="form f">
                <form method="POST" action="donor.php"  autocomplete="off" enctype="multipart/form-data">
                    <div class="alert alert-error"><?= $_SESSION['message'] ?></div>
                    <div class="form-group">
                        <label class="color name" for="NAME">First Name</label>
					    <input type="text" placeholder="First Name" id="FNAME" name="FNAME" required="" class="form-control input-sm n">
                    </div>
					<div class="form-group">
                        <label class=" color name" for="NAME">Last Name</label>
                        <input type="text" placeholder="Last Name" id="LNAME" name="LNAME" required="" class="form-control input-sm n">
                    </div>
                    <div class="form-group">
                        <label class="color name" for="FATHER_NAME">Father Name</label>
						<input type="text" placeholder="Father Name" id="FATHER_NAME" name="FATHER_NAME" required class="form-control input-sm">
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
						<label class="color name" for="DOB">D.O.B</label>
						<input type="text"  placeholder="YYYY/MM/DD" required id="DOB" name="DOB"  class="form-control input-sm DATES">
					</div>
                    <div class="form-group">
							<label class=" color name" for="BLOOD" >Blood Group</label>
						<select id="blood" name="BLOOD" required class="form-control input-sm">	
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
							<label class="color name" for="BODY_WEIGHT" >Body Weight</label>
							<input type="text" required placeholder="Weight In Kgs"  name="BODY_WEIGHT" id="BODY_WEIGHT" class="form-control input-sm">
						</div>
						<div class="form-group">
							<label class="color name" for="EMAIL" >Email ID</label>
                            <input type="email"  required name="EMAIL" id="EMAIL" class="form-control" placeholder="Email Address">
                        </div>
                        <div class="form-group">
                            <label class="color name">Address</label>
                            <input type="street" name="street" class="form-contrl" id="autocomplete" required placeholder="Street">
							
							<input type="area" name="area" class="form-contrl" id="inputArea" required placeholder="Area">

                            <input type="city" name="city" class="form-contrl" id="inputCity" required placeholder="City">

                            <input type="zip" class="form-contrl" id="inputZip" name="pincode"required placeholder="Pincode">

                            <input type="state" class="form-contrl" id="inputState" name="state"required placeholder="State">

                            <input type="country" class="form-contrl" id="inputCountry" name="country" required placeholder="Country">
                        </div>
                        <div class="form-group">
								<label class="color name" for="CONTACT_1" >Contact-1</label>
                                <input type="text" required name="CONTACT_1" id="CONTACT_1" class="form-control" placeholder="Contact No-1">
                          </div>
						   <div class="form-group">
								<label class="color name" for="CONTACT_2" >Contact-2</label>
                                <input type="text" required name="CONTACT_2" id="CONTACT_2" class="form-control" placeholder="Contact No-2">
                          </div>
                          <hr>
                          <div class="form-group">
							<label class="text-success" for="fileToUpload" >Upload Photo</label>
							<input type="file" class="form-control"  name="fileToUpload">
						  </div>
                          <div class="subm">
                                <div class="form-group">
                                    <button class="btns" type="submit" name="submit" >Registar Now</button>
                                </div>
						  </div>
	
                </form>
            </div>
        </div>
    </div>
    <?php include"include/footer.php";?>

</body>
</html>