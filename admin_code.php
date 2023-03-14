<?php
session_start();
$con=new mysqli("localhost","root","","blood_donate");
if(mysqli_connect_error())
{
    die('Connect Error('. mysqli_connect_errno().')'.mysqli_connect_error());
}

$categories = array();
$blood= $con->query("SELECT sum(volume) as vol,blood_group from blood_inventory group by blood_group");
while($row = mysqli_fetch_array($blood)){
    $categories[$row['blood_group']] = $row['vol'];
}
echo $categories;

if(isset($_POST["newsubmitbtn"])) {
    $newfirstname = $_POST['newfirstname'];
    $newlastname = $_POST['newlastname'];
    $newfname = $_POST['newfname'];
    $newgender = $_POST['newgender'];
    $newdob =  date('Y-m-d',strtotime($_POST['newdob'])) ;
    $newemail=$_POST['newemail'];
    $newblood_group = $_POST['newblood_group'];
    $newweight = $_POST['newweight'];
    $newstreet = $_POST['newstreet'];
    $newarea = $_POST['newarea'];
    $newcity = $_POST['newcity'];
    $newstate = $_POST['newstate'];
    $newpincode = $_POST['newpincode'];
    $newcountry = $_POST['newcountry'];
    $newcontact1 = $_POST['newcontact1'];
    $newcontact2 = $_POST['newcontact2'];
    $newldonate =  date('Y-m-d',strtotime($_POST['newldonate'])) ;
   
    $avatar_path = $con->real_escape_string('donorspic/'.$_FILES['newfileToUpload']['name']);
    if(preg_match("!image!",$_FILES['newfileToUpload']['type']))
    {
        if(move_uploaded_file($_FILES['newfileToUpload']['tmp_name'],$avatar_path))
        {
            $sql="
                INSERT INTO donors(f_Name,l_Name,father_name,gender,dob,b_group,weight,email,street,area,city,state,pincode,country,Contact1,Contact2,photo,last_d_date)
                VALUES 
                ('$newfirstname','$newlastname','$newfname','$newgender','$newdob','$newblood_group','$newweight','$newemail','$newstreet','$newarea','$newcity','$newstate','$newpincode','$newcountry','$newcontact1','$newcontact2','$avatar_path','$newldonate');"
                ;
                
            if($con->query($sql)==true)
            {
                $_SESSION['status']="Successfully Saved";
                header("location: admin_index.php?page=admin_ldonors");
            }
            else{
                header("location: admin_index.php?page=admin_ldonors");
                $_SESSION['status']="Donor could not be added to the database";
            }
        }
        else{
            header("location: admin_index.php?page=admin_ldonors");
            $_SESSION['status']="File upload failed!";
        }
    }
    else{
        header("location: admin_index.php?page=admin_ldonors");
        $_SESSION['status']="Please only upload GIF, JPG , or PNG images";
    }
}


if(isset($_POST['checking_viewbtn']))
{
    $d_id = $_POST['d_id'];
    $query = "SELECT * FROM donors where d_id='$d_id' ";
    $query_run = mysqli_query($con,$query);

    if(mysqli_num_rows($query_run) > 0)
    {
        foreach($query_run as $row)
        {
            $dob = date('d-M-Y',strtotime($row['dob'])) ;
            if(empty($row['last_d_date']) or $row['last_d_date']=="0000-00-00")
            {
                $dondate = 'New';
            }
            else{
                $dondate =  date('d-M-Y',strtotime($row['last_d_date'])) ;
            }
            if($row['status']==1)
            {
                $stat =  "ACTIVE" ;
            }
            else{
                $stat =  "DEACTIVE" ;
            }

            echo $return = '
                        <div class="col-md-4">
                                <div class="panel">
                                <div class="panel-body">
                                <div>
                                    <img src="'.$row['photo'].'" class="round-img" >
                                </div>
                        </div>
                        </div> 

                    </div>
                    <table class="table table-striped">
                        <tr>
                            <th>First Name</th>
                            <td>'.$row['f_Name'].' </td>
                        </tr>
                        <tr>
                            <th>Last Name</th>
                            <td>'.$row['l_Name'].'</td>
                        </tr>
                        <tr>
                            <th>Father Name</th>
                            <td>'.$row['father_name'].'</td>
                        </tr>
                        <tr>
                            <th>Gender</th>
                            <td>'.$row['gender'].'</td>
                        </tr>
                        <tr>
                            <th>D.O.B</th>
                            <td> '.$dob.'</td>
                        </tr>
                        <tr>
                            <th>Blood Group</th>
                            <td>'.$row['b_group'].'</td>
                        </tr>
                        <tr>
                            <th>Body Weight</th>
                            <td>'.$row['weight'].'</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>'.$row['email'].'</td>
                        </tr>
                        <tr>
                            <th>Address</th>
                        </tr>
                        <tr></tr>
                            <th>Street</th>
                            <td>'.$row['street'].'</td>
                        </tr>
                        <tr>
                            <th>Area</th>
                            <td>'.$row['area'].'</td>
                        </tr>
                        <tr>
                            <th>City</th>
                            <td>'.$row['city'].'</td>
                        </tr>
                        <tr>
                            <th>Pincode</th>
                            <td>'.$row['pincode'].'</td>
                        </tr>
                        <tr>
                            <th>State</th>
                            <td>'.$row['state'].'</td>
                        </tr>
                        <tr>
                            <th>Country</th>
                            <td>'.$row['country'].'</td>
                        </tr>
                
                        <tr>
                            <th>Contact-1</th>
                            <td>'.$row['Contact1'].'</td>
                        </tr>
                        <tr>
                            <th>Contact-2</th>
                            <td>'.$row['Contact2'].'</td>
                        </tr>			
                        <tr>
                            <th>Last Donoted Date</th>
                            <td> '.$dondate.' </td>
                        </tr>

                        <tr>
                            <th>Status</th>
                            <td> '.$stat.'</td>
                        </tr>
                    </table>
            ';
        }
    }
}

if(isset($_POST['checking_editbtn']))
{
    $result_array = [];
    $d_id = $_POST['d_id'];
    $query = "SELECT * FROM donors where d_id='$d_id' ";
    $query_run = mysqli_query($con,$query);

    if(mysqli_num_rows($query_run) > 0)
    {
        foreach($query_run as $row)
        {
            array_push($result_array,$row);
            header('Content-type: application/json');
            echo json_encode($result_array);
        }
    }

}

if(isset($_POST['update_sub']))
{   
    $editid = $_POST['id'];
    $editfirstname = $_POST['editfirstname'];
    $editlastname = $_POST['editlastname'];
    $editfname = $_POST['editfname'];
    $editgender = $_POST['editgender'];
    $editdob =  date('Y-m-d',strtotime($_POST['editdob'])) ;
    $editemail=$_POST['editemail'];
    $editblood_group = $_POST['editblood_group'];
    $editweight = $_POST['editweight'];
    $editstreet = $_POST['editstreet'];
    $editarea = $_POST['editarea'];
    $editcity = $_POST['editcity'];
    $editstate = $_POST['editstate'];
    $editpincode = $_POST['editpincode'];
    $editcountry = $_POST['editcountry'];
    $editcontact1 = $_POST['editcontact1'];
    $editcontact2 = $_POST['editcontact2'];
    $editldonate =  date('Y-m-d',strtotime($_POST['editldonate']));

    $new_image = $_FILES['donor_img']['name'];
    $old_image = $_POST['donor_img_old'];

    if($new_image != '')
    {
        $update_filename = $con->real_escape_string('donorspic/'.$_FILES['donor_img']['name']);
    }
    else{
        $update_filename = $con->real_escape_string($_POST['donor_img_old']);
    }

    $query = " UPDATE donors SET f_Name='$editfirstname',l_Name='$editlastname' ,father_name='$editfname',gender='$editgender',dob='$editdob' ,email='$editemail',b_group='$editblood_group',weight='$editweight' ,street='$editstreet',area='$editarea',city='$editcity' ,state='$editstate',pincode='$editpincode',country='$editcountry',Contact1='$editcontact1',Contact2='$editcontact2',photo='$update_filename',last_d_date='$editldonate' where d_id='$editid' ";
    $query_run = mysqli_query($con,$query);

    if($query_run)
    {
        if($_FILES['donor_img']['name']!='')
        {
            move_uploaded_file($_FILES["donor_img"]["tmp_name"],"donorspic/".$_FILES["donor_img"]["name"]);
            unlink($old_image);
        }
        $_SESSION['status'] = "Image Updated Successfully";
        header("Location: admin_index.php?page=admin_ldonors");
    }
    else{
        $_SESSION['status']="Image Not Updated !";
        header("Location: admin_index.php?page=admin_ldonors");
    }


}
if(isset($_POST['deletedata']))
{
    $id = $_POST['delete_id'];

    $query =" DELETE From donors where d_id='$id' ";
    $query_run = mysqli_query($con,$query);

    if($query_run)
    {
        echo '<script> alert("Data Deleted"); </script>';
        header("Location:admin_index.php?page=admin_ldonors");
    }
    else
    {
        echo '<script> alert("Data Not Deleted"); </script>';
    }

}

?>