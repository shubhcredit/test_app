<?php
include('../../config.php');
include('../../hp/helper_function.php');

$conn = new mysqli(DB_HOST_NAME, DB_USER_NAME, DB_PASSWORD, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET'){

    $sql="SELECT subscriptions.*,users.name FROM subscriptions LEFT JOIN users ON subscriptions.user_id=users.id";
    $list_of_subs;
    $result=$conn->query($sql);
    if ($result->num_rows > 0) {
        $list_of_subs=$result->fetch_all();
            $status=true;
            $msg=" All subscription list";
    } else {
        $status=false;
        $msg= "Something went wrong";
    }
    $response=["status"=>$status,'msg'=>$msg,'data'=>$list_of_subs];
    echo json_encode($response);
}





?>
