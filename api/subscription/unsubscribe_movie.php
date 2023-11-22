<?php
include('../../config.php');
include('../../hp/helper_function.php');

$conn = new mysqli(DB_HOST_NAME, DB_USER_NAME, DB_PASSWORD, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $validation=validate($_POST,['subscription_id']);
    if($validation['status']==false){
        echo json_encode($validation);
        die;
    }
    $subscription_id=$_POST['subscription_id'];

    $sql="UPDATE subscriptions SET status='0' WHERE id='$subscription_id'";
    if ($conn->query($sql)==true) {
            $status=true;
            $msg="Unsubscription  successfull";
    } else {
        $status=false;
        $msg= "Something went wrong";
    }
    $response=["status"=>$status,'msg'=>$msg];
    echo json_encode($response);
}





?>
