<?php
    $conn=new mysqli("localhost","root","","blood_donate");
    if(mysqli_connect_error())
    {
        die('Connect Error('. mysqli_connect_errno().')'.mysqli_connect_error());
    }
    $categories = array();
    $blood= $conn->query("SELECT sum(volume) as vol,blood_group from blood_inventory group by blood_group");
    while($row = mysqli_fetch_array($blood)){
        $categories[$row['blood_group']] = $row['vol'];
    }
    $i=1;
    foreach ($categories as $key => $value) {
        $select="Update bloodbank set volume='$value' where blood_group = '$key';";
        $query_run = mysqli_query($conn,$select);
        $i++;
        if(!($query_run)){
           echo "$i";
        }

       
    }

?>