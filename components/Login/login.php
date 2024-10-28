<?php
error_reporting(E_ALL);
include_once '../../controllers/usersController.php';

$users->startSession();

if (isset($_POST['submit'])) {
    $statementResult = $users->login($_POST['email'], $_POST['password']);
    if ($statementResult !="Invalid Credentials" && $statementResult != "User not found") {
        $_SESSION['LoginUser'] = array(
            "ID" => $statementResult['user_id'],
            "first_name" => $statementResult['first_name'],
            "last_name" => $statementResult['last_name'],
            "email" => $statementResult['email'], );
        header("Location: /");
    } else {
        echo "<div class='bg-danger bg-gradient text-white p-2'>Password does not match</div>";
    }
  
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listify </title>
    <link rel="shortcut icon" href="../../assets/listify-fav-ico.png" type="image/x-icon">
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  </head>
<body>




<div class="d-flex justify-content-center align-items-center gap-5 vh-100">
  <div class="col">
<img class="" src="/assets/login-page-design-2.png" height="1000" alt="login-thumbnail">
  </div>
<div class="col  mx-3 my-3 ">  
<form method="POST" class="d-flex flex-column gap-3 mt-5  w-55 mx-auto  p-4 ">
<div class="text-center">
<img src="../../assets/listify-fav-ico.png" alt="" height="75px" width="75px" srcset="">
<h1 class="fw-normal text-center">Welcome to Listify</h1>
</div>    
  


    <div class="form-floating mb-4">
      <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com">
      <label for="floatingInput">Email address</label>
    </div>
    <div class="form-floating  mb-4">
      <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
      <label for="floatingPassword">Password</label>
    </div>

    <button class="w-100 btn btn-lg" id="action-btn" name="submit" type="submit">Sign in</button>

    <div class="d-flex flex-column gap-2 text-center mb-4">
    <a href="../register.php">New to Listify? Sign-up here</a>
    <a href="">Forgot password</a>
    </div>
    <p class="mt-5 mb-3 text-muted text-center">&copy; 2017–2021</p>
  </form>
  </div>
  </div>
  </div>


<?php include_once '../Footer/footer.php';?>