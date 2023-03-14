<?php
	$id = $_SESSION['login_pic'];
?>
<nav class="navbar navbar-expand-lg navbar-default navbod top-fixed" role="navigation" style="margin-top: -1.5em;">
	<div class="container-fluid ">
		
		<div class="col-md-4 float-left aad text-white">
			<a class="logo" href="admin_index.php">
				<img class="logoimg" src="images/logo.jpg" width="40" height="70">
			</a>
			<a class="navbar-brand" href="admin_index.php" style="padding-top: 18px;font-size: 22px;">Blood Bank</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
				</button>
		</div>
		<div class="float-right">
			<div class=" dropdown mr-4" style="font-size: 18px;">
				<a href="#" class="text-white dropdown-toggle"  id="account_settings" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="text-decoration-line: none;">
					<img class="logoig" src="<?php echo($id); ?>" width="40" height="40"> <?php echo($_SESSION['login_name']); ?> </a>
				<div class="dropdown-menu" aria-labelledby="account_settings" style="left: -2.5em;">
					<a class="dropdown-item" href="#" id="manage_my_account"><i class="fa fa-cog"></i> Manage Account</a>
					<a class="dropdown-item" href="admin_logout.php"><i class="fa fa-power-off"></i> Logout</a>
				</div>
			</div>
		</div>
	</div>
</nav>
