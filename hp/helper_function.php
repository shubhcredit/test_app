<?php

// -----------for form validation--------------
 function validate($_arr,$val_key){
    $error_msg=[];
    $status=true;
    foreach($val_key as $key){
        if(!isset($_arr[$key]) || $_arr[$key]==""){
            $status=false;
            $error_msg[]=ucfirst($key). " field is required";
        }
    }
    return ["status"=>$status,"errors"=>$error_msg];
}
