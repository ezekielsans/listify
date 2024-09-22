<?php
include_once 'usersController.php';
$users->startSession();
print_r($_SESSION['LoginUser']);
$user =  $users->getUserId($_SESSION['LoginUser']['ID']);
//echo "<br> user details <br>";
//print_r($users);?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listify</title>
    <link rel="shortcut icon" href="assets/listify-fav-ico.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <?php if ($user['role']==="administrator"):?>
        <?php include_once 'components/adminNavbar.php';?>
        <?php else:?>
        <?php include_once 'components/userNavbar.php';?>
        <?php endif; ?>
       