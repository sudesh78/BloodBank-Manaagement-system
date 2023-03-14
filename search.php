<?php 
	session_start();
	$con=new mysqli("localhost","root","","blood_donate");
	if(mysqli_connect_error())
	{
		die('Connect Error('. mysqli_connect_errno().')'.mysqli_connect_error());
	}
	
?>
<html>
<head>
<title></title>
<?php
        include('include/head.php')
?>
<link href="css/search.css" rel="stylesheet" type="text/css">
</head>

<body>
    <?php
        include('include/nav.php')
    ?>
    <section class="hero">
        <div class="s-upper">
            <h3 class="u-tex"><i class="fa fa-search"> Search Donor</i> </h3><hr>
        </div>
        <div class="warpper fl">
            <div class="main">
                <div class="head">
                    <p>
                   Search Donor</p>
                </div>
                <div class="form fl">
                    <form method="POST" action="search.php">
                        <p class="name">
                        Search Type</p>
                        <div class="form-check form-check-inline rad">
                            <input class="form-check-input" type="radio" name="sea" value="state" checked>
                            <label class="form-check-label">State</label>
                            </div>
                            <div class="form-check form-check-inline rad">
                            <input class="form-check-input" type="radio" name="sea" value="city">
                            <label class="form-check-label">City</label>
                            </div>
                            <p class="name">
                            Blood Type</p>
                            <select name="blood" required  class="form-control input-sm">
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
                            <p class="name">
                            Search </p>
							<div id="ins" style="display: none;">
                                <input type="text" name="incity" placeholder="City" class="form-control input-sm"> 
                                <input type="text" name="inarea" placeholder="Area (Optional)" class="form-control input-sm"> 
                            </div>
                            <div style="width: 50%;margin: 0 auto;">
                            <input type="text" id="sta" name="instate" placeholder="State" class="form-control input-sm"> 
                            </div>
                            <p><input type="submit" name="sb" value="SUBMIT" class="sub"></p>
                        </form>
                    </div>
                </div>
				<?php if ($_SERVER["REQUEST_METHOD"] == "POST") 
	{
			$type=$_POST["sea"];
			$blood=$_POST["blood"];
			$incity = $_POST["incity"];
			$inarea = $_POST["inarea"];
			$instate = $_POST["instate"];
			if (!preg_match("/^[a-zA-Z]*$/",$instate) Or !preg_match("/^[a-zA-Z]*$/",$inarea) Or !preg_match("/^[a-zA-Z]*$/",$incity)) {
				$strErr = "Only letters";
			}
			else
			{
				if($type =='state'){
					$sql="SELECT * FROM donors WHERE ( state LIKE '%$instate%' AND b_group='{$_POST["blood"]}' AND status=1)";
				}
				elseif($inarea==''){
					$sql="SELECT * FROM donors WHERE ( city LIKE '%$incity%' AND b_group='$blood' AND status=1)";
				}
				else{
					$sql="SELECT * FROM donors WHERE ( city LIKE '%$incity%' AND area LIKE '%$inarea%'AND b_group='$blood' AND status=1)";

				}
				
				$result=$con->query($sql);
				if($result->num_rows>0)
				{
						$i=0;
					echo "<div class='table-responsive trs'><table class='table table-striped table-bordered'>
								<tr class='text-primary'>	
									<th>Sno</th>
									<th>Picture</th>
									<th>Blood Group</th>
									<th>Name</th>
									<th>Area</th>
									<th>Pincode</th>
									<th>City</th>
									<th>State</th>
									<th>Cell1</th>
									<th>Cell2</th>
								</tr>
							";
						
					while($row=$result->fetch_assoc())
					{
						$sdate=$row["last_d_date"];
						echo "$sdate";
						$n=null;
						$date2=date_create($sdate);
						$cdate=date_create(date("Y-m-d"));
						$days=date_diff($date2,$cdate);
						$n=$days->format("%R%a");
						if($n>90 or $sdate==null)
						{
							
							$i++;
							echo"<tr>";
							echo"<td>$i</td>";
							echo"<td><img src='{$row["photo"]}' class='don_img' height='50px' width='50px'></td>";
							echo"<td>{$row["b_group"]}</td>";
							echo"<td>{$row["f_Name"]} {$row["l_Name"]}</td>";
							echo"<td>{$row["area"]}</td>";
							echo"<td>{$row["pincode"]}</td>";
							echo"<td>{$row["city"]}</td>";
							echo"<td>{$row["state"]}</td>";
							echo"<td>{$row["Contact1"]}</td>";
							if(($row["Contact2"])!=null)
							{
								echo"<td>{$row["Contact2"]}</td>";
							}
							else{
								echo"<td>__</td>";
							}
							echo"</tr>";
						}
						
					}
					echo "</table></div>";
					
					if($i==0)
					{
					echo "<div class='alert alert-danger'><i class='fa fa-users'></i> Our Donors already donated</div>";
					}
				}
				else
				{
					echo "<div class='alert alert-danger'><i class='fa fa-users'></i> No Donors Found</div>";
				}
		}
		
	}	?>
        </div>
    </section>
		<?php include('include/footer.php') ?>
</body>
<script src="js/jquery-3.6.0.min.js"></script>
<script>
	$(function() {
		$("input[name='sea']").change(function(){
			if ($(this).val() == 'city') {
				$('#ins').show();
				$('#sta').hide();
			}
			else if ($(this).val() == 'state') {
				$('#ins').hide();
				$('#sta').show();
			}
		});
	});
</script>
</html>

