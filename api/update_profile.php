<?php
include('../config.php');
include('../hp/helper_function.php');

$conn = new mysqli(DB_HOST_NAME, DB_USER_NAME, DB_PASSWORD, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST'){

    $validation=validate($_POST,['user_id','name','email_id']);
    if($validation['status']==false){
        echo json_encode($validation);
        die;
    }
    $id=$_POST['user_id'];
    $email=$_POST['email_id'];
    $name = $_POST['name'];
    $user;
    $sql = "SELECT * FROM users WHERE id='$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $sql="UPDATE users SET name='$name',email_id='$email' WHERE id='$id'";
        if($conn->query($sql)==true){
            $status=true;
            $msg="Profile Data Updated successfully";
        }else{
            $status=false;
            $msg="Somethig went wrong,try again";
        }
    } else {
        $status=false;
        $msg= "User not found";
    }
    $response=["status"=>$status,'msg'=>$msg];
    echo json_encode($response);
}





?>
