<?php
$users->startSession();
print_r($_SESSION['LoginUser']);
$user =  $users->getUserId($_SESSION['LoginUser']['ID']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listify</title>
    <link rel="shortcut icon" href="../../assets/listify-fav-ico.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body></body>


<script src="functions.js"></script>
<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
<div class="container-fluid">
    <!-- Logo on the left side -->
    <a href="/" class="navbar-brand"><img src="/assets/listify-fav-ico.png" height="40px" alt="icon"></a>

    <!-- Toggler button for small screens -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar items in the center -->
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a href="/" class="nav-link">Products</a>
            </li>  
            <li class="nav-item">
                <a href="../Admin/userAdminDashboard.php" class="nav-link">Users</a>
            </li>
             <li class="nav-item">
                <a href="../Admin/inventoryAdminDashboard.php" class="nav-link">Inventory</a>
            </li> 
              <li class="nav-item">
                <a href="../Admin/ordersAdminDashboard.php" class="nav-link">Orders</a>
            </li>
            
        </ul>
        
        <!-- Profile image on the far right -->
        <?php if (isset($_SESSION['LoginUser'])):?>
            <div class="dropdown text-end ">
          <a href="#" id="dropdownToggle" class="d-block link-body-emphasis text-decoration-none dropdown-toggle  text-white mx-2" data-bs-toggle="dropdown" aria-expanded="true">
          <img src="/uploads/<?=$user['user_image']?>" alt="Profile Image" width="32" height="32" class="rounded-circle">
          <?=$user['first_name']?> <?=$user['last_name']?>    
        </a>
          <ul id="dropdownMenu" class="dropdown-menu text-small " style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate3d(0px, 34px, 0px);" data-popper-placement="bottom-start">

            <li><a class="dropdown-item" href="../profile.php">Profile</a></li>
            <li><a class="dropdown-item" href="#">Settings</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="../logout.php">Sign out</a></li>
          </ul>
        </div>
        <?php else:?>
            <div class=" text-end ">
            <a href="../Login/login.php" class="nav-link">Login</a>
            </div>
            
        <?php endif; ?>
    </div>
</div>
</nav>



