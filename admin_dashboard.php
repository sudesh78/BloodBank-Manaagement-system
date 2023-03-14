<?php
    $conn=new mysqli("localhost","root","","blood_donate");
    if(mysqli_connect_error())
    {
        die('Connect Error('. mysqli_connect_errno().')'.mysqli_connect_error());
    }
    include("admin_bloodstock.php");
?>
<div class="containe-fluid">
	<div class="row mt-3 ml-3 mr-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <!-- <?php echo "Welcome back ". $_SESSION['login_name']."!"  ?> -->
                    <hr>
                    <h4><b>Available Blood Group Units</b></h4>
                    <div class="row">
                    <?php 
                        $blood_group = array("A+","B+","O+","AB+","A-","B-","O-","AB-");
                        foreach($blood_group as $v){
                            $bg_inn[$v] = 0; 
                        }
                        $qry = $conn->query("SELECT * FROM bloodbank ");
                        while($row = $qry->fetch_assoc()){
                                $bg_inn[$row['blood_group']] += $row['volume'];
                        }
                        ?>
                        <?php foreach ($blood_group as $v): ?>
                        <div class="col-md-3 mb-3">
                            <div class="card">
                                <div class="card-body bg-light">
                                    <div class="card-body text-dark">
                                        <span class="float-right summary_icon"> <?php echo $v ?> <i class="fa fa-tint text-danger"></i></span>
                                        <h4><b>
                                        <?php echo ($bg_inn[$v])?>
                                        </b></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    </div>	
                    <hr>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="card">
                                <div class="card-body bg-light">
                                    <div class="card-body text-dark">
                                        <span class="float-right summary_icon"> <i class="fa fa-user-friends text-primary "></i></span>
                                        <h4><b>
                                            <?php echo $conn->query("SELECT * FROM donors")->num_rows ?>
                                        </b></h4>
                                        <p><b>Total Donors</b></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card">
                                <div class="card-body bg-light">
                                    <div class="card-body text-dark">
                                        <span class="float-right summary_icon"> <i class="fa fa-notes-medical text-danger "></i></span>
                                        <h4><b>
                                            <?php echo $conn->query("SELECT * FROM blood_inventory where status = 1 and date(date_created) = '".date('Y-m-d')."' ")->num_rows ?>
                                        </b></h4>
                                        <p><b>Total Donated Today</b></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card">
                                <div class="card-body bg-light">
                                    <div class="card-body text-dark">
                                        <span class="float-right summary_icon"> <i class="fa fa-th-list "></i></span>
                                        <h4><b>
                                            <?php echo $conn->query("SELECT * FROM request where date(date_created) = '".date('Y-m-d')."' ")->num_rows ?>
                                        </b></h4>
                                        <p><b>Today's Requests</b></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card">
                                <div class="card-body bg-light">
                                    <div class="card-body text-dark">
                                        <span class="float-right summary_icon"> <i class="fa fa-check text-primary "></i></span>
                                        <h4><b>
                                            <?php echo $conn->query("SELECT * FROM request where date(date_created) = '".date('Y-m-d')."' and status = 1 ")->num_rows ?>
                                        </b></h4>
                                        <p><b>Today's Approved Requests</b></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>      			
        </div>
    </div>
</div>