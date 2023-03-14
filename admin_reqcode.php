<?php
    session_start();
    $con=new mysqli("localhost","root","","blood_donate");
    if(mysqli_connect_error())
    {
        die('Connect Error('. mysqli_connect_errno().')'.mysqli_connect_error());
    }

    if(isset($_POST['newreqsubmit']))
    {
        $name=$_POST['NAME'];
		$gender=$_POST['GENDER'];
		$bg=$_POST['BLOOD'];
		$bu=$_POST['BUNIT'];
		$hosp=$_POST['HOSP'];
		$city=$_POST['CITY'];
		$pincode=$_POST['PIN'];
		$doc=$_POST['DOC'];
		$rdate=$_POST['RDATE'];
		$cname=$_POST['CNAME'];
		$cadd=$_POST['CADDRESS'];
		$cont1=$_POST['CON1'];
		$reas=$_POST["REASON"];
		$email=$con->real_escape_string($_POST['EMAIL']);
		$dt=date("Y-m-d",strtotime($_POST['RDATE']));
        $i = 1;
        while($i == 1){
            $rand = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $ref_code = substr(str_shuffle($rand), 0,8);
            $chk = $con->query("SELECT * FROM request where ref_code = '$ref_code'")->num_rows;
            if($chk <= 0){
                $i = 0;
                $data = $ref_code;
            }
        }
        $avatar_path = $con->real_escape_string('requestor/'.$_FILES['profileImage']['name']);
        if(preg_match("!image!",$_FILES['profileImage']['type']))
        {
            if(move_uploaded_file($_FILES['profileImage']['tmp_name'],$avatar_path))
            {
                $sql="
					INSERT INTO request(name,gender,blood,bunit,hosp,city,pincode,doc_name,rdate,c_name,c_address,email,contact,reason,pic,ref_code)
					VALUES 
					('$name','$gender','$bg', $bu,'$hosp','$city',$pincode,'$doc','$dt','$cname','$cadd','$email',$cont1,'$reas','$avatar_path','$data');
                    ";
                    
                if($con->query($sql)==true)
                {
                    $_SESSION['status']="Successfully Saved";
                    header("Location:admin_index.php?page=admin_request");
        
                }
                else{
        
                    $_SESSION['status']="Donor could not be added to the database";
                    header("Location:admin_index.php?page=admin_request");
                }
            }
            else{
                $_SESSION['status']="File upload failed!";
                header("Location:admin_index.php?page=admin_request");
            }
        }
        else{
            $_SESSION['status']="Please only upload GIF, JPG , or PNG images";
            header("Location:admin_index.php?page=admin_request");
        }
    }
    if(isset($_POST['checking_editreq']))
    {
        $result_array = [];
        $rid = $_POST['rid'];
        $query = "SELECT * FROM request where r_id='$rid' ";
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
    if(isset($_POST['editreqsubmit']))
    {
        $rid =$_POST['er_id'];
        $ename=$_POST['ENAME'];
		$ebu=$_POST['EBUNIT'];
		$ehosp=$_POST['EHOSP'];
		$edoc=$_POST['EDOC'];
		$edt=date("Y-m-d",strtotime($_POST['ERDATE']));
        $new_image = $_FILES['profileImg']['name'];
        $old_image = $_POST['fakepic'];
        $estatus = $_POST['estatus'];
    
        if($new_image != '')
        {
            $update_filename = $con->real_escape_string('requestor/'.$_FILES['profileImg']['name']);
            echo "$update_filename";
        }
        else{
            $update_filename = $con->real_escape_string($_POST['fakepic']);
            echo "$update_filename";
        }
        $query = "Update request set name='$ename',bunit='$ebu',hosp='$ehosp',doc_name='$edoc',rdate='$edt',pic='$update_filename',status='$estatus' where r_id='$rid';";
        $query_run = mysqli_query($con,$query);
        if($query_run)
        {
            if($_FILES['profileImg']['name']!='')
            {
                move_uploaded_file($_FILES["profileImg"]["tmp_name"],"requestor/".$_FILES["profileImg"]["name"]);
                unlink($old_image);
            }
            $_SESSION['status'] = "Updated Successfully";
            header("Location: admin_index.php?page=admin_request");
        }
        else{
            $_SESSION['status'] = "Failed To Upload";
            header("Location: admin_index.php?page=admin_request");
        }


    }

    if(isset($_POST['delete_req']))
    {
        $id = $_POST['del_rid'];
        $query ="DELETE From request where r_id ='$id';";
        $query_run = mysqli_query($con,$query);

        if($query_run){
        header("Location:admin_index.php?page=admin_request");
        }
        else
        {
            echo 'error';
        }
    }

    if(isset($_POST['chk_btn']))
    {
        $ref_code = $_POST['ref'];
        $query_run= $con->query("SELECT * FROM request where ref_code = '$ref_code'");
		$result_array = [];
        if(mysqli_num_rows($query_run) > 0)
        {
            foreach($query_run as $row)
            {
                array_push($result_array,$row);
                header('Content-type: application/json');
                echo json_encode($result_array);
            }
        }
        else{
            $result='3';
            echo ($result);
        }
    }

    if(isset($_POST['newhandsubmit']))
    {
        $id =$_POST['request_id'];
        $p = $_POST['picked_up_by'];
        $query="INSERT INTO handedover_request(request_id,picked_up_by)
                VALUES('$id','$p')";
        $query1="UPDATE request SET 
                 status='2' where r_id='$id'";
        $query_run = mysqli_query($con,$query);
        $query_run1 = mysqli_query($con,$query1);
        if(($query_run) and ($query_run1))
        {
            echo "Success";
        }
        else{
            $roll1="";
        }
    }

    if(isset($_POST['delete_hand']))
    {
        $id = $_POST['del_hand'];
        $query ="DELETE From handedover_request where id ='$id';";
        $query_run = mysqli_query($con,$query);

        if($query_run){
            header("Location:admin_index.php?page=admin_handover");
            echo "$return='
                <div class='alert alert-danger'>Reference box should not be empty.</div>
            ';";
        }
        else
        {
            header("Location:admin_index.php?page=admin_handover");
            
        }
    }
    
    

?>
