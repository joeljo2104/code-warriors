<?php

session_start();

$username="";
$email="";
$errors=array();


$db = mysqli_connect('localhost', 'root', '', 'registration');


if(isset($_POST['reg_user'])){

    // receives all inut values from the form

    $username = mysqli_real_escape_string($db, $_POST['username']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password_1 = mysqli_real_escape_string($db, $_POST['pass']);
    $password_2 = mysqli_real_escape_string($db, $_POST['confirm-pass']);


    // 


    if(empty($username)){
        array_push($errors, "username is required");
    }

    if(empty($email)){
        array_push($errors, "email is required");

    }
    if(empty($password_1)){
        array_push($errors, "password is required");
    }

    if($password_1 != $password_2){
        array_push($errors, "the two password does not match");
    }


    $user_check_query  =  "SELECT * FROM users WHERE user_name='$username' OR email='$email' LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);


    // if user exist


    if($user){
        if($user['user_name'] == $username)
        {
            array_push($errors, "username  aleready exist");
        }

        if($user['email'] == $email){
            array_push($errors, "email already exist");
        }
    }


    if(count($errors) == 0){
       $password = md5($password_1);

       $query = "INSERT INTO users (user_name, email, password)VALUES('$username', '$email', '$password')";

       if(!mysqli_query($db, $query)){
           die("mysqli Error: ".mysqli_error($db));
       }

       $_SESSION['username'] = $username;
       $_SESSION['success'] = "you are now logged in";
       $_SESSION['result'] = $result;

       header('location: index.php');

    }
    // login user
    

}
?>