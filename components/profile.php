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
      <table class="table table-hover border">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Order ID</th>
            <th scope="col">Order Date</th>
            <th scope="col">Order Status</th>
            <th scope="col">Total Price</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($userOrders as $order) {?>
          <tr>
            <th scope="row"><?=$counter++?></th>
          
            
            <td><?=$order['order_id']?></td>
            <td><?=$order['created_at']?></td>
            <td><?=$order['order_status']?></td>
            <td><?=$order['total_price']?></td>
        
           
            <td><button class="btn btn-danger btn-sm">Cancel</button></td>
          </tr>
         <?php }?>
        </tbody>
      </table>

      <!-- Cart Summary -->
      <div class="d-flex justify-content-between">
        <span>Total:</span>
        <strong>$45.00</strong>
      </div>
      <button class="btn btn-success mt-3 w-100">Proceed to Checkout</button>
    </div>
  </div>
</div>


<?php include_once '../components/Footer/footer.php';?>