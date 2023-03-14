<?php
	session_start();
    $con=new mysqli("localhost","root","","blood_donate");
	if(mysqli_connect_error())
	{
		die('Connect Error('. mysqli_connect_errno().')'.mysqli_connect_error());
	}
?>
<html lang="en">
<head>
	<title></title>
	<?php include("include/head.php");?>
	<link rel="stylesheet" type="text/css" href="css/admin.css">
</head>
<body >
<?php include("include/nav.php"); ?>

    <div class="hero conttt">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header text-col"><i class='fa fa-user-md'></i> Admin Login</h1>
            </div>
			<div class="row" style="padding-top: 12px;">
				<div class="col-md-3"></div>
				<div class="col-xs-12 col-md-12 offset-md-6" style="padding: 4em 12em;">
					<?php 
						if($_SERVER['REQUEST_METHOD']=='POST')
						{
							$myusername = mysqli_real_escape_string($con,$_POST['user']);
							$mypassword = mysqli_real_escape_string($con,$_POST['pass']); 
							
							$sql = "SELECT id,name,photo FROM admin WHERE username = '$myusername' and password = '$mypassword'";
							$result=$con->query($sql);
							$count = mysqli_num_rows($result);
							$row=$result->fetch_assoc();
							if($count == 1) 
							{
								$_SESSION['login_pic'] = $row['photo'];
								$_SESSION['login_name'] = $row['name'];
								header("location: admin_index.php?page=admin_dashboard");
							}
							else
							{
								echo "<div class='alert alert-danger'><b>Error : </b> User Name and Password Incorrect.</div>";
							}
						} 
					?>
					<form role="form" action="admin.php" method="post">
			    	  	<div class="form-group">
							 <label for="user_name" class="text-primary">User Name</label>
			    		    <input class="form-control" name="user"  id="user" type="text" required>
			    		</div>
			    		<div class="form-group">
							<label for="pass" class="text-primary">Password</label>
			    			<input class="form-control" id="pass" name="pass" type="password" value="" required>
			    		</div>
						
						
			    		<button class="btn btn-primary" style="float: left;margin-left: -1px;"name="submit" type="submit"><i class="fa fa-sign-in"></i> Login Here</button>
			      	</form>
				</div>
				<div class="col-md-3"></div>
			</div>
        </div>
        </div>
	<?php include"include/footer.php";?>
</body>

</html>