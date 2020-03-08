<?php

include('server.php');


if(isset($_POST['login_user'])){
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['pass']);
  
    $password_1 = md5($password);


    if(empty($username)){
        array_push($errors, "username is required");
    }

    if(empty($password_1)){
        array_push($errors, "password is required");
    }

$user_check_query  =  "SELECT * FROM users WHERE user_name='$username' or password='$password_1' LIMIT 1";
$result = mysqli_query($db, $user_check_query);
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);


$count = mysqli_num_rows($result);

if($count == 1 AND $row['user_name'] == $username){
   $_SESSION['username']  = $username;
    $_SESSION['success'] = "you are logged in ";
    header('location: index.php');
}
    // echo $user['user_name'];
    else{
        array_push($errors, "wrong username/ passmn word ");
        header('location: login.php'); 
    }
}




?>