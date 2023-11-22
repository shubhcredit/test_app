<?php
include('../config.php');
include('../hp/helper_function.php');

$conn = new mysqli(DB_HOST_NAME, DB_USER_NAME, DB_PASSWORD, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST'){

    $validation=validate($_POST,['email_id','password']);
    if($validation['status']==false){
        echo json_encode($validation);
        die;
    }

    $email = $_POST['email_id'];
    $password = $_POST['password'];
    $user;

    $sql = "SELECT * FROM users WHERE email_id='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $get_data = $result->fetch_assoc();
        if ($password == $get_data['password']) {
            $user=$get_data;
            $status=true;
            $msg="Login successfully";
        } else {
            $status=false;
            $msg="Password Not matched";
        }
    } else {
        $status=false;
        $msg= "User not found";
    }
    $response=["status"=>$status,'msg'=>$msg,"data"=>$user];
    echo json_encode($response);
}





?>
