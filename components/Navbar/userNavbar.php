<?php


$userId = $_SESSION['LoginUser']['ID']; 

$users->startSession();

$user =  $users->getUserId($_SESSION['LoginUser']['ID']);
// $userDetails = $users->getUserId($_SESSION['LoginUser']['ID']);
// $userId = $userDetails['ID'];

$cartItems = $orders->countCartItems($userId);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listify</title>
    <link rel="shortcut icon" href="../assets/listify-fav-ico.png" type="image/x-icon">
    <link rel="stylesheet" href="userNavbar.css">
  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

<nav class="navbar navbar-expand-sm" style="background-color:#2E7D32;">
<div class="container-fluid">
    <!-- Logo on the left side -->
    <a href="/" class="navbar-brand"><img src="/assets/listify-fav-ico.png" height="40px"  alt="icon"></a>

    <!-- Toggler button for small screens -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar items in the center -->
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a href="/" class="nav-link text-white">Products</a>
            </li>
        </ul>
           

      
          <!-- Profile image on the far right -->
<?php if (isset($_SESSION['LoginUser'])): ?>

<?php if ($cartItems !== 0): ?>
<div class="cart-icon" style="position: relative; margin-right:12px;">
    <span class="badge  rounded-pill" style="background-color:#4CAF50; position: absolute; top: -3px; right: -5px;"><?=$cartItems;?></span>
    <a href="../../components/User/userCart.php" class="nav-link">
    <svg width="35px" height="35px" viewBox="0 0 512 512" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#fff0f0" stroke="#fff0f0">
        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
        <g id="SVGRepo_iconCarrier"> <title>shopping-cart</title> 
        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <g id="icon" fill="#ffffff" transform="translate(42.666667, 85.333333)"> 
        <path d="M7.10542736e-15,-1.42108547e-14 L70.3622093,-1.42108547e-14 L89.7493333,85.3333333 L378.389061,85.3333333 L337.246204,277.333333 L89.6377907,277.333333 L36.288,42.6666667 L7.10542736e-15,42.6666667 L7.10542736e-15,-1.42108547e-14 Z M325.610667,128 L99.456,128 L123.690667,234.666667 L302.741333,234.666667 L325.610667,128 Z M138.666667,384 C156.339779,384 170.666667,369.673112 170.666667,352 C170.666667,334.326888 156.339779,320 138.666667,320 C120.993555,320 106.666667,334.326888 106.666667,352 C106.666667,369.673112 120.993555,384 138.666667,384 Z M288,384 C305.673112,384 320,369.673112 320,352 C320,334.326888 305.673112,320 288,320 C270.326888,320 256,334.326888 256,352 C256,369.673112 270.326888,384 288,384 Z" id="Combined-Shape"> </path> 
    </g> 
</g> 
</g>
</svg>
    </a>
</div>
<?php else: ?>
    <div class="cart-icon" style="position: relative; margin-right:12px;">
    <a href="../../components/User/userCart.php"  class="nav-link ">
        <svg width="25px" height="25px"  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
            <g id="SVGRepo_iconCarrier">
                <path d="M6.29977 5H21L19 12H7.37671M20 16H8L6 3H3M9 20C9 20.5523 8.55228 21 8 21C7.44772 21 7 20.5523 7 20C7 19.4477 7.44772 19 8 19C8.55228 19 9 19.4477 9 20ZM20 20C20 20.5523 19.5523 21 19 21C18.4477 21 18 20.5523 18 20C18 19.4477 18.4477 19 19 19C19.5523 19 20 19.4477 20 20Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </g>
        </svg>
    </a>
</div>
<?php endif;?>
                

<div class="dropdown text-end ">
          <a href="#" id="dropdownToggle" class="d-block link-body-emphasis text-decoration-none dropdown-toggle  text-white mx-2" data-bs-toggle="dropdown" aria-expanded="true">
          <img src="/uploads/<?=$user['user_image']?>" alt="Profile Image" width="32" height="32" class="rounded-circle">
          <?=$user['first_name']?> <?=$user['last_name']?>
        </a>
          <ul id="dropdownMenu" class="dropdown-menu text-small " style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate3d(0px, 34px, 0px);" data-popper-placement="bottom-start">

            <li><a class="dropdown-item" href="../profile.php">My Account</a></li>
            <li><a class="dropdown-item" href="../../components/User/userCart.php">My Purchases</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="../logout.php">Sign out</a></li>
          </ul>
        </div>
            <!-- <div class="d-flex align-items-center gap-2">


            <a href="profile.php" class="nav-link text-white "> </a>
            </div> -->
        <?php else: ?>
            <a href="../Login/login.php" class="text-end text-decoration-none text-white">Login</a>

        <?php endif;?>
    </div>
</div>
</nav>

