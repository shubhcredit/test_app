<?php
include('../config.php');
include('../hp/helper_function.php');

$conn = new mysqli(DB_HOST_NAME, DB_USER_NAME, DB_PASSWORD, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $image_name="";
    if($_FILES['image']){
       $image_name= $_FILES['image']['name'];
        $ext=end(explode('.',$image_name));
        $image_name=rand(111111,999999).".$ext";
       move_uploaded_file($_FILES['image']['tmp_name'],FILE_PATH."image/$image_name");
    }

    $validation=validate($_POST,['name','email_id','password']);
    if($validation['status']==false){
        echo json_encode($validation);
        die;
    }
    $name=$_POST['name'];
    $email = $_POST['email_id'];
    $password = $_POST['password'];
    $created_at=date('Y-m-d');


    $sql="INSERT INTO users (name,email_id,image,password,created_at)VALUES ('$name','$email','$image_name','$password','$created_at')";
    if ($conn->query($sql)==true) {
            $status=true;
            $msg="User registed successfull";
    } else {
        $status=false;
        $msg= "Something went wrong";
    }
    $response=["status"=>$status,'msg'=>$msg];
    echo json_encode($response);
}





?>
