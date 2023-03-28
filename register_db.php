<?php
session_start();
include('server.php');

//กำหนด $errors เอาไว้เก็บ error ที่เป็น array
$errors = array();

if (isset($_POST['reg_user'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password_1 = mysqli_real_escape_string($conn, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($conn, $_POST['password_2']);

    //ฟังก์ชั่น empty
    if (empty($username)) {
        array_push($errors, "Username is required");
        $_SESSION['error'] = "Username is required";
    }

    if (empty($email)) {
        array_push($errors, "Email is required");
        $_SESSION['error'] = "Email is required";
    }

    if (empty($password_1)) {
        array_push($errors, "Password is required");
        $_SESSION['error'] = "Password is required";
    }

    //ถ้า password1 ไม่เท่ากับ password2 แสดงข้อความ errors
    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
        $_SESSION['error'] = "The two passwords do not match";

    }
//สร้างตัวแปร
    $user_check_query = "SELECT * FROM user WHERE username = '$username' OR email = '$email' ";
// สร้างตัวแปร query
    $query = mysqli_query($conn, $user_check_query);
//ใช้คำสั่ง assoc ของตัว query
    $result = mysqli_fetch_assoc($query);

    //check

    if ($result) { //if user exists
        if($result['username'] === $username){
            array_push($errors, "Username already exists");
        }

        if($result['email'] === $email){
            array_push($errors, "Email already exists");
        }
    }

    //check errors
    if (count($errors) == 0) {
        $password = md5($password_1);
        $sql = "INSERT INTO user (username, email, password) VALUES ('$username', '$email', '$password')"; mysqli_query($conn, $sql);

        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You are now logged in";
        header('location: index.php');
    } else {
        header("location: register.php");
    }
}                                                                                                                                   

?>