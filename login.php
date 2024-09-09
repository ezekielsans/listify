<?php
error_reporting(E_ALL);
include_once 'productController.php';

$items = $products->getAllProducts();
//print_r($items);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listify</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>



<main >
<div class="container-fluid d-flex justify-content-center align-items-center vh-100">
  <form method="POST" class="d-flex flex-column gap-3 w-50 mx-auto border p-4 ">
   
    <h1 class="h3 mb-3 fw-normal text-center">Sign in</h1>
    

    <div class="form-floating mb-4">
      <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
      <label for="floatingInput">Email address</label>
    </div>
    <div class="form-floating  mb-4">
      <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
      <label for="floatingPassword">Password</label>
    </div>

    <div class="d-flex flex-column gap-2 text-center mb-4">
    <a href="register.php">Register here</a>
    <a href="">Forgot password</a>
  
    </div>
    <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
    <p class="mt-5 mb-3 text-muted">&copy; 2017–2021</p>
  </form>
  </div>
  </div>
</main>

<?php include_once 'templates/footer.php';?>