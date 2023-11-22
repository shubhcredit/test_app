<?php
include('../config.php');
include('../hp/helper_function.php');

$conn = new mysqli(DB_HOST_NAME, DB_USER_NAME, DB_PASSWORD, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST'){

    $validation=validate($_POST,['email_id','new_password']);
    if($validation['status']==false){
        echo json_encode($validation);
        die;
    }
    $email=$_POST['email_id'];
    $new_password = $_POST['new_password'];

    $sql = "SELECT * FROM users WHERE email_id='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // $user = $result->fetch_assoc();
        $sql="UPDATE users SET password='$new_password' WHERE email_id='$email'";
        if($conn->query($sql)==true){
            $status=true;
            $msg="Password Updated successfully";
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
