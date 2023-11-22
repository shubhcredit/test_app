<?php
include('../../config.php');
include('../../hp/helper_function.php');

$conn = new mysqli(DB_HOST_NAME, DB_USER_NAME, DB_PASSWORD, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $validation=validate($_POST,['user_id','movie_id','expiry_date']);
    if($validation['status']==false){
        echo json_encode($validation);
        die;
    }
    $user_id=$_POST['user_id'];
    $movie_id = $_POST['movie_id'];
    $expiry_date = $_POST['expiry_date'];
    $status="1";
    $created_at=date('Y-m-d');

    $sql="SELECT id FROM subscriptions WHERE user_id ='$user_id' &&  movie_id=$movie_id";
    $result=$conn->query($sql);
    if($result->num_rows>0){
        $subs=$result->fetch_assoc();
        $subs_id= $subs['id'];
        $sql="UPDATE subscriptions SET status='$status',expiry_date='$expiry_date' WHERE id='$subs_id'";
    }else{
        $sql="INSERT INTO subscriptions (user_id,movie_id,expiry_date,status,created_at)VALUES ('$user_id','$movie_id','$expiry_date','$status','$created_at')";
    }

    if ($conn->query($sql)==true) {
            $status=true;
            $msg="Subscription  successfull";
    } else {
        $status=false;
        $msg= "Something went wrong";
    }
    $response=["status"=>$status,'msg'=>$msg];
    echo json_encode($response);
}





?>
