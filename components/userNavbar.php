<?php
include_once 'usersController.php';
$users->startSession();

$user = $users->getUserId($_SESSION['LoginUser']['ID']);
//print_r($_SESSION['LoginUser']['ID']);
// echo "<br> login values ";
// print_r($_SESSION['LoginUser']);
// echo "<br> user <br> ";
// print_r($user);



?><nav class="navbar navbar-expand-sm bg-dark navbar-dark">
<div class="container-fluid">
    <!-- Logo on the left side -->
    <a href="/" class="navbar-brand">logo</a>

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
        </ul>
            <?php if (isset($_SESSION['LoginUser'])): ?>    
            <a href="logout.php" class="nav-link">My Orders</a>
            <?php else: ?>
                <a href="login.php" class="nav-link">Login</a>
            <?php endif; ?>

        <!-- Profile image on the far right -->
          <!-- Profile image on the far right -->
          <?php if (isset($_SESSION['LoginUser'])): ?>
            <a href="logout.php" class="nav-link text-white">My Orders</a>
            <div class="dropdown text-end ">
          <a href="#" id="dropdownToggle" class="d-block link-body-emphasis text-decoration-none dropdown-toggle  text-white mx-2" data-bs-toggle="dropdown" aria-expanded="true">
          <img src="/uploads/<?=$user['user_image']?>" alt="Profile Image" width="32" height="32" class="rounded-circle">
          <?=$user['first_name']?> <?=$user['last_name']?>    
        </a>
          <ul id="dropdownMenu" class="dropdown-menu text-small " style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate3d(0px, 34px, 0px);" data-popper-placement="bottom-start">

            <li><a class="dropdown-item" href="profile.php">Profile</a></li>
            <li><a class="dropdown-item" href="#">Settings</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="logout.php">Sign out</a></li>
          </ul>
        </div>
            <!-- <div class="d-flex align-items-center gap-2">
              
        
            <a href="profile.php" class="nav-link text-white "> </a>
            </div> -->
        <?php else:?>
            <a href="login.php" class="text-end text-decoration-none text-white">Login</a>

        <?php endif; ?>
    </div>
</div>
</nav>

