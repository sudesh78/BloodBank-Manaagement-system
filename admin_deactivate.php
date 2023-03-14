<?php 
session_start();
$con=new mysqli("localhost","root","","blood_donate");
if(mysqli_connect_error())
{
    die('Connect Error('. mysqli_connect_errno().')'.mysqli_connect_error());
}

 if(isset($_GET["id"])&&!empty($_GET["id"]))
 {
	 $sql="UPDATE donors SET status='0' WHERE d_id=".$_GET["id"];
	 $con->query($sql);
	 header("location:admin_index.php?page=admin_ldonors"); 
 }
 else
 {
	 header("location:admin_index.php?page=admin_ldonors"); 
 }

?>