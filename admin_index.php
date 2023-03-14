<?php 
	session_start();
	$conn=new mysqli("localhost","root","","blood_donate");
	if(mysqli_connect_error())
	{
		die('Connect Error('. mysqli_connect_errno().')'.mysqli_connect_error());
	}
	echo $_SESSION['login_name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <?php
        include('admin_include/head.php');
    ?>
    <link href="admin_css/index.css" rel="stylesheet" type="text/css">
</head>
<body style="background-image: url('images/bloodbg.jpg');">
    <?php include("admin_navbar.php") ?> 
    <?php include("admin_sidenav.php") ?> 
    <main id="view-panel">
      <?php $page = isset($_GET['page']) ? $_GET['page'] :'admin_dashboard'; ?>
  	    <?php include $page.'.php' ?>	
    </main>


</body>
<script>

   window.alert_toast= function($msg = 'TEST',$bg = 'success'){
      $('#alert_toast').removeClass('bg-success')
      $('#alert_toast').removeClass('bg-danger')
      $('#alert_toast').removeClass('bg-info')
      $('#alert_toast').removeClass('bg-warning')

    if($bg == 'success')
      $('#alert_toast').addClass('bg-success')
    if($bg == 'danger')
      $('#alert_toast').addClass('bg-danger')
    if($bg == 'info')
      $('#alert_toast').addClass('bg-info')
    if($bg == 'warning')
      $('#alert_toast').addClass('bg-warning')
    $('#alert_toast .toast-body').html($msg)
    $('#alert_toast').toast({delay:3000}).toast('show');
  }


  $('.select2').select2({
    placeholder:"Please select here",
    width: "100%"
  })
</script>	
</html>