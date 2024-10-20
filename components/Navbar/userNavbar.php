<?php
// $users->startSession();


$userId = $_SESSION['LoginUser']['ID'];
$user = $users->getUserId($_SESSION['LoginUser']['ID']);
$cartItems = $orders->countCartItems($userId);


?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listify</title>
    <link rel="shortcut icon" href="../assets/listify-fav-ico.png" type="image/x-icon">
    <link rel="stylesheet" href="../Navbar/userNavbar.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>


    <header style="background-color:#2E7D32;" class="py-3 border-bottom">
    <div class="container-fluid d-grid gap-3 align-items-center" style="grid-template-columns: 1fr 2fr;">
        <a href="/" class="navbar-brand d-flex align-items-center gap-2">
            <img src="/assets/listify-fav-ico.png" height="40px" alt="icon">
            <h5>Listify</h5>
        </a>

        <div class="d-flex align-items-center">
            <form class="w-100 me-3" role="search">
                <div class="input-group mb-3">
                    <input type="search" class="form-control" placeholder="Search..." aria-label="Search">
                    <button class="btn btn-outline-secondary" type="submit" aria-label="Search Button">
                        <svg fill="#ffffff" viewBox="-2 0 19 19" xmlns="http://www.w3.org/2000/svg" class="cf-icon-svg" stroke="#ffffff">
                            <path d="M14.147 15.488a1.112 1.112 0 0 1-1.567 0l-3.395-3.395a5.575 5.575 0 1 1 1.568-1.568l3.394 3.395a1.112 1.112 0 0 1 0 1.568zm-6.361-3.903a4.488 4.488 0 1 0-1.681.327 4.443 4.443 0 0 0 1.68-.327z"></path>
                        </svg>
                    </button>
                </div>
            </form>

            <?php if ($user): // User is logged in ?>
                <div class="dropdown text-end" style="margin-right: 1.5rem;">
                    <a href="#" id="dropdownToggle" class="d-block link-body-emphasis text-decoration-none dropdown-toggle text-white mx-2" data-bs-toggle="dropdown" aria-expanded="true">
                        <img src="/uploads/<?= $user['user_image'] ?>" alt="Profile Image" width="32" height="32" class="rounded-circle">
                        <?= $user['first_name'] ?> <?= $user['last_name'] ?>
                    </a>
                    <ul id="dropdownMenu" class="dropdown-menu text-small" style="position: absolute; inset: 0 auto auto 0; margin: 0; transform: translate3d(0, 34px, 0);" data-popper-placement="bottom-start">
                        <li><a class="dropdown-item" href="../profile.php">My Account</a></li>
                        <li><a class="dropdown-item" href="../../components/User/userCart.php">My Purchases</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="../logout.php">Sign out</a></li>
                    </ul>
                </div>

                <!-- Cart Icon Display -->
                <div class="cart-icon" style="position: relative; margin-right:12px;">
                    <span class="badge rounded-pill" style="background-color:#4CAF50; position: absolute; top: -3px; right: -5px;"><?= $cartItems; ?></span>
                    <a href="../../components/User/userCart.php" class="nav-link">
                        <svg width="35px" height="35px" viewBox="0 0 512 512" fill="#fff0f0" stroke="#fff0f0">
                            <path d="M7.10542736e-15,-1.42108547e-14 L70.3622093,-1.42108547e-14 L89.7493333,85.3333333 L378.389061,85.3333333 L337.246204,277.333333 L89.6377907,277.333333 L36.288,42.6666667 L7.10542736e-15,42.6666667 L7.10542736e-15,-1.42108547e-14 Z M325.610667,128 L99.456,128 L123.690667,234.666667 L302.741333,234.666667 L325.610667,128 Z M138.666667,384 C156.339779,384 170.666667,369.673112 170.666667,352 C170.666667,334.326888 156.339779,320 138.666667,320 C120.993555,320 106.666667,334.326888 106.666667,352 C106.666667,369.673112 120.993555,384 138.666667,384 Z M288,384 C305.673112,384 320,369.673112 320,352 C320,334.326888 305.673112,320 288,320 C270.326888,320 256,334.326888 256,352 C256,369.673112 270.326888,384 288,384 Z"></path>
                        </svg>
                    </a>
                </div>
            <?php else: // User is not logged in ?>
                <a href="../Login/login.php" class="text-end text-decoration-none text-white">Login</a>
            <?php endif; ?>
        </div>
    </div>
</header>

<nav class="navbar navbar-expand-sm" style="background-color:#2E7D32;">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-center" id="collapsibleNavbar">
            <div id="loadingMessage" style="font-size:1rem">Loading categories...</div>
            <ul id="categoryList" class="navbar-nav flex-row" style="display:flex"></ul>
        </div>
    </div>
</nav>

<script>document.addEventListener('DOMContentLoaded', requestCategories);

function requestCategories() {
    const loadingMessage = document.getElementById('loadingMessage');
    if (!loadingMessage) {
        console.error('Loading Message element not found');
        return;
    }

    const categoryList = document.getElementById('categoryList');

    if (!categoryList) {
        console.error('Category list element not found');
        return;
    }

    fetch("http://localhost/api/loadCategories.php", { method: "GET" })
        .then((res) => res.json())
        .then((data) => {
            loadingMessage.style.display = 'none';
            categoryList.style.display = 'flex';

            if (data.error) {
                console.error(data.error);
                return;
            }

            data.forEach((category) => {
                const listItem = document.createElement('li');
                listItem.classList.add('nav-item');
                const link = document.createElement('a');
                link.classList.add('nav-link');
                link.href = `../Category/category.php?id=${encodeURIComponent(category.product_category_id)}`;
                link.textContent = category.product_category;

                listItem.appendChild(link);
                categoryList.appendChild(listItem);
            });
        })
        .catch((err) => console.error('Failed to fetch categories:', err));
}


</script>
