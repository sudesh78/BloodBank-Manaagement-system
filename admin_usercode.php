<?php   
    session_start();
    $con=new mysqli("localhost","root","","blood_donate");
    if(mysqli_connect_error())
    {
        die('Connect Error('. mysqli_connect_errno().')'.mysqli_connect_error());
    }
    
    if(isset($_POST["newusersubmit"]))
    {
        $name = $_POST["newusername"];
        $email = $_POST["newemail"];
        $uname = $_POST["newdname"];
        $pwd = $_POST["newdword"];
        $type = $_POST["newaccounttype"];    
        $avatar_path = $con->real_escape_string('images/'.$_FILES['profileImage']['name']);
        if(preg_match("!image!",$_FILES['profileImage']['type']))
        {
            if(move_uploaded_file($_FILES['profileImage']['tmp_name'],$avatar_path))
            {
                $sql="
                    INSERT INTO admin(name,email,username,password,type,photo)
                    VALUES 
                    ('$name','$email','$uname','$pwd','$type','$avatar_path');"
                    ;
                    
                if($con->query($sql)==true)
                {
                    $_SESSION['status']="Successfully Saved";
                    header("Location:admin_index.php?page=admin_user");
        
                }
                else{
        
                    $_SESSION['status']="Donor could not be added to the database";
                    header("Location:admin_index.php?page=admin_user");
                }
            }
            else{
                $_SESSION['status']="File upload failed!";
                header("Location:admin_index.php?page=admin_user");
            }
        }
        else{
            $_SESSION['status']="Please only upload GIF, JPG , or PNG images";
            header("Location:admin_index.php?page=admin_user");
        }
    }

    if(isset($_POST["checking_editbtn"]))
    {
        $result_array = [];
        $username = $_POST['user'];
        $query = "SELECT * FROM admin where username='$username' ";
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
        else
        {
            echo $return = "<h5>No Record Found</h5>";
        }
    }

    if(isset($_POST["editusersubmit"]))
    {
        $eid = $_POST['eid'];
        $ename = $_POST['editusername'];
        $eemail = $_POST['editemail'];
        $euser = $_POST['editdname'];
        $epwd = $_POST['editdword'];
        $etype = $_POST['editaccounttype'];
        $new_image = $_FILES['profileImg']['name'];
        $old_image = $_POST['fakepic'];
    
        if($new_image != '')
        {
            $update_filename = $con->real_escape_string('images/'.$_FILES['profileImg']['name']);
            echo "$update_filename";
        }
        else{
            $update_filename = $con->real_escape_string($_POST['fakepic']);
            echo "$update_filename";
        }
        $query = "Update admin set name='$ename',email='$eemail',username='$euser',password='$epwd',type='$etype',photo='$update_filename' where id='$eid';";
        $query_run = mysqli_query($con,$query);
        if($query_run)
        {
            if($_FILES['profileImg']['name']!='')
            {
                move_uploaded_file($_FILES["profileImg"]["tmp_name"],"donorspic/".$_FILES["profileImg"]["name"]);
                unlink($old_image);
            }
            $_SESSION['status'] = "Updated Successfully";
            header("Location: admin_index.php?page=admin_user");
        }
        else{
            $_SESSION['status'] = "Failed To Upload";
            header("Location: admin_index.php?page=admin_user");
        }
    }

    if(isset($_POST['delete_use']))
    {
        $id = $_POST['del_id'];
        $query ="DELETE From admin where id ='$id';";
        $query_run = mysqli_query($con,$query);

        if($query_run){
        header("Location:admin_index.php?page=admin_user");
        }
        else
        {
            echo 'error';
        }
    }  

    if(isset($_POST['newdonsubmit']))
    {
        $did = $_POST['donor_id'];
        $dbgroup = $_POST['blood_group'];
        $dvol = $_POST['volume'];
        $dstat = $_POST['status'];
        $ddon =  date('Y-m-d',strtotime($_POST['date_created'])) ;
        
        $query = "Insert Into blood_inventory(blood_group,volume,d_id,status,date_created) Values('$dbgroup','$dvol','$did','$dstat','$ddon');";
        $query_run = mysqli_query($con,$query);
        if($query_run)
        {
            $_SESSION['status'] = "Updated Successfully";
            header("Location: admin_index.php?page=admin_donations");
        }
        else{
            $_SESSION['status'] = "Failed To Update";
            echo '12';
        }
    }
    if(isset($_POST['checking_editdon']))
    {
        $result_array = [];
        $id = $_POST['id'];
        $query = "SELECT * FROM blood_inventory where id='$id' ";
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
    if(isset($_POST['editdonsubmit']))
    {
        $eeid = $_POST['eid'];
        $eevol = $_POST['evolume'];
        $edate =  date('Y-m-d',strtotime($_POST['edate_created'])) ;
        $query = "Update blood_inventory SET volume='$eevol',date_created='$edate' where id='$eeid';";
        $query_run = mysqli_query($con,$query);
        if($query_run)
        {
            $_SESSION['status'] = "Updated Successfully";
            header("Location: admin_index.php?page=admin_donations");
        }
        else{
            $_SESSION['status'] = "Failed To Update";
        }
    }
    if(isset($_POST['delete_don']))
    {
        $id = $_POST['del_did'];
        $query ="DELETE From blood_inventory where id ='$id';";
        $query_run = mysqli_query($con,$query);

        if($query_run){
        header("Location:admin_index.php?page=admin_donations");
        }
        else
        {
            echo 'error';
        }

    } 

?>
