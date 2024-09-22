<?php
error_reporting(E_ALL);
include_once 'usersController.php';

if (isset($_POST['submit'])) {
    if ($_POST['password'] === $_POST['confirmed_password']) {
        $status = $users->registerUser($_POST['first_name'],$_POST['last_name'],$_POST['email'], $_POST['password']);
        if ($status === "success") {
            echo "<div class='bg-success bg-gradient text-white p-2'>User registered successfully!</div>";

        } else {
            echo "<div class='bg-danger bg-gradient text-white p-2'>Password does not match</div>";
        }

    } else {
        echo "<div class='bg-danger bg-gradient text-white p-2'>Password does not match</div>";

    }

}
//print_r($items);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listify</title>
    <link rel="shortcut icon" href="assets/listify-fav-ico.png" type="image/x-icon">
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>




<div class="d-flex justify-content-center align-items-center gap-2 vh-100">
  <div class="col">
<img class="rounded" src="/assets/login-page-design-2.png" height="750" alt="login-thumbnail">
  </div>
<div class="col mx-3 my-3 ">
<form method="POST" class="d-flex flex-column gap-3 w-55 mx-2  mt-5  py-3 ">
<div class="text-center">
<img src="assets/listify-fav-ico.png" alt="" height="75px" width="75px" srcset="">
<h1 class="fw-normal text-center">Register to Listify</h1>
</div>    

<div class="d-flex justify-content-between gap-3">
    <div class="form-floating mb-4 w-50">
      <input type="text" class="form-control" name="first_name" id="floatingInput" required>
      <label for="floatingInput">First Name</label>
      </div> 
    <div class="form-floating mb-4 w-50">
      <input type="text" class="form-control" name="last_name" id="floatingInput" required>
      <label for="floatingInput">Last Name</label>
    </div>  
    </div>   
    <div class="form-floating mb-3">
      <input type="email" class="form-control" name="email" id="floatingInput" required>
      <label for="floatingInput">Email address</label>
    </div>
    <div class="form-floating  mb-3">
      <input type="password" class="form-control" name="password" id="floatingPassword" required>
      <label for="floatingPassword">Password</label>
    </div>


    <div class="form-floating  mb-3">
      <input type="password" class="form-control" name="confirmed_password" id="floatingPassword" required>
      <label for="floatingPassword"> Confirm Password</label>
    </div>


    <button class="w-100 btn btn-lg" id="action-btn" name="submit" type="submit">Register</button>
    <div class="d-flex flex-column gap-2 text-center ">
    <a href="login.php">Already have an account? Login here</a>
    <a href="">Forgot password</a>

    </div>
    <p class=" text-muted text-center">&copy; 2017–2021</p>
  </form>

  </div>
  </div>


<?php include_once 'components/footer.php';?>