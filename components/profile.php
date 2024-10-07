<?php
require_once '../controllers/usersController.php';
require_once '../controllers/productController.php';
require_once '../controllers/ordersController.php';

$users->startSession();
$user = $users->getUserId($_SESSION['LoginUser']['ID']);


$userOrders = $orders->showUserOrders($user['user_id']);
echo "<br/> user orders <br/>";
print_r($userOrders);
$counter = 1;
?>
  
  <?php if ($user['role']==="administrator"):?>
        <?php include_once './Navbar/adminNavbar.php';?>
        <?php else:?>
        <?php include_once './Navbar/userNavbar.php';?>
        <?php endif; ?>

<div class="container mb-5">
  <h1 class="mb-5">My Profile</h1>

  <div class="row">
    <!-- Left Side (Profile Section) -->
    <div class="col-lg-4">
      <!-- Profile Image -->
      <div class="mb-3">
        <img src="/uploads/<?=$user['user_image']?>" alt="Profile Image" height="150px" class="img-fluid rounded" style="height:230px;">
      </div>
      <!-- Edit Profile Button -->
      <div class="mb-3">
        <a href="editProfile.php?ID=<?=$user['user_id']?>" class="btn btn-primary" >Edit Profile</a>
      </div>

      <!-- Profile Info -->
      <div class="mb-1">
      
      <span class="text-muted"><?=$user['first_name']?> <?= $user['last_name']?></span>
        
      </div>
      <div class="mb-1">
      <span class="text-muted"><?=$user['email']?></span>
      </div>
      <div class="mb-3">
      <span class="text-muted"><?=$user['role']?></span>
      </div>
    </div>

    <!-- Right Side (Shopping Cart Section) -->
    <div class="col-lg-8">
      <h4 class="d-flex justify-content-between align-items-center mb-3">
        <span class="text-primary">My orders</span>
      
      </h4>
      <!-- Shopping Cart Table -->
          <?php foreach($userOrders as $order) {?>
<div class="container my-5 card py-5 px-5">
    <!-- Product Info Row -->
    <h5 class="text-muted">Order status: <?=$order['order_status']?></h5>
    <div class="row py-4 border-bottom">
        <div class="col-md-2">
            <!-- Product image -->
            <img src="/uploads/<?=$order['product_image']?>" alt="Product Image" class="img-fluid">
        </div>
        <div class="col-md-7">
            <!-- Product details -->
            <h5 class="mb-1"> <?=$order['product_name']?></h5>
            <p class="mb-1"><strong>Description:</strong> <?=$order['product_description']?></p>
            <p class="mb-3"><strong>Quantity:</strong> x<?=$order['quantity']?></p>

        </div>
        <div class="col-md-3 text-end">
            <!-- Price and Discount -->
            <p class="text-muted mb-1"><del>₱239</del> <strong class="text-danger">₱ <?=number_format($order['product_price'])?></strong></p>
        </div>
    </div>

    <!-- Order Total and Action Buttons -->
  
    <div class="row align-items-end py-4">
    <!-- Order Total -->
    <div class="col text-end">
        <p class="mb-0">Order Total: <strong class="text-danger">₱<?=number_format($order['total_price'])?></strong></p>
    </div>
    </div>
    <!-- Action Buttons -->
    <div class="col text-end">
        <a href="#" class="btn btn-danger me-2">Cancel Order</a>
        <!-- <a href="#" class="btn btn-outline-secondary me-2">Contact Seller</a> -->
        <a href="../components/details.php?ID=<?=$order['product_id']?>" class="btn btn-outline-secondary">View Product</a>
    </div>

</div>
         <?php }?>


    

  
    </div>
    
  </div>
</div>


<?php include_once '../components/Footer/footer.php';?>