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
    print_r($categories);
    $i=1;
    foreach ($categories as $key => $value) {
        $select="Update bloodbank set volume='$value' where blood_group = '$key';";
        $query_run = mysqli_query($conn,$select);
        if($query_run){
           echo"good";
        }
        else
        {
            echo $i;
        }
        $i++;
    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <label><?php ?></label>
</body>
</html>