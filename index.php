<?php 
$conn=new mysqli("localhost","root","","blood_donate");
if(mysqli_connect_error())
{
	die('Connect Error('. mysqli_connect_errno().')'.mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html>
<head>
<title></title>
	<?php include ('include/head.php');?>
	<link rel="stylesheet" type="text/css" href="css/index.css">
</head>
<body>

<?php include('include/nav.php') ?>
<div class="container-fluid">
<div id="demo" class="carousel slide" data-ride="carousel">
  <ul class="carousel-indicators">
    <li data-target="#demo" data-slide-to="0" class="active"></li>
    <li data-target="#demo" data-slide-to="1"></li>
    <li data-target="#demo" data-slide-to="2"></li>
  </ul>

  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="images/can1.jpeg" width="1100" height="500">
    </div>
    <div class="carousel-item">
      <img src="images/can2.jpg" width="1100" height="500">
    </div>
    <div class="carousel-item">
      <img src="images/can3.jpg">
    </div>
  </div>
  
  <a class="carousel-control-prev" href="#demo" data-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </a>
  <a class="carousel-control-next" href="#demo" data-slide="next">
    <span class="carousel-control-next-icon"></span>
  </a>
</div>
<section >
	<div class="container-fluid red-background">
				<div class="row">
					<div class="col-md-12">
						<h1 class="text-center" style="font-size:4vh;color: white; font-weight: 500;padding: 2px;">Welcome</h1>
						<hr class="white-bar">
						<p class="text-center pera-text">
							Blood Bank Management System (BBMS) is a browser based system that is designed to store, process, retrieve and analyze information concerned with the administrative and inventory management within a blood bank. This project aims at maintaining all the information pertaining to blood donors, different blood groups available in each blood bank and help them manage in a better way. Aim is to provide transparency in this field, make the process of obtaining blood from a blood bank hassle free and corruption free and make the system of blood bank management effective.
						</p>
					</div>
				</div>
	</div>
	<div class="container">
				<div class="row">
    				<div class="col-lg-4 col-md-4 col-12">
    					<div class="card">
     						<h3 class="text1">Our Vission</h3>
								<img src="images/vision.png" alt="Our Vission" class="img img-responsive" width="168" height="168">
								<p class="text-center">
									Saving and improving lives in our community with safe and reliable blood and innovative cell therapies.
									
								</p>
						</div>
    				</div>
    				
    				<div class="col-lg-4 col-md-4 col-12">
    					<div class="card">
      							<h3 class="text1">Our Goal</h3>
								<img src="images/Goal.png" alt="Our Vission" class="img img-responsive" width="168" height="168">
								<p class="text-center">
									Promote and support the establishment of effective national blood donor programmes and the elimination of a dependency on replacement and paid blood donation.
								</p>
						</div>
    				</div>
    		
    				<div class="col-lg-4 col-md-4 col-12">
    					<div class="card">
      						<h3 class="text1">Our Mission</h3>
								<img src="images/Mission.png" alt="Our Vission" class="img img-responsive" width="168" height="168">
								<p class="text-center">
									To enhance the well being of patients in our service area by assuring a reliable and economical supply of the safest possible blood, by providing innovative hemotherapy services, and by promoting research and education programs in transfusion medicine.
								</p>
							</div>
   			 		</div>
 			</div>
 	</div>
	 <?php 
$results = $conn->query("SELECT f_Name,l_Name,gender,b_group from donors where status=1 order by rand() limit 6");
while($row = $results->fetch_assoc()){
?>
	<div class="row">
            <div class="col-lg-4 col-sm-6 portfolio-item">
                <div class="card h-100">
                    <a href="#"><img class="card-img-top img-fluid" src="images/blood.jpg" alt="" ></a>
                    <div class="card-block">
                        <h4 class="card-title"><a href="#"><?php echo ucwords($row['f_Name'])," ",ucwords($row[ 'l_Name']);?></a></h4>
<p class="card-text"><b>  Gender :</b> <?php echo ucwords($row['gender']);?></p>
<p class="card-text"><b>Blood Group :</b> <?php echo ucwords($row['b_group']);?></p>

                    </div>
                </div>
            </div>

        </div>


<?php } ?>
</div>
	 
	<?php include('include/footer.php') ?>
</section>
</body>
</html>