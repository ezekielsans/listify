<?php
require_once '../../controllers/usersController.php';
require_once '../../controllers/productController.php';
$users->startSession();

$user = $users->getUserId($_SESSION['LoginUser']['ID']);
$userId = $user['ID'];
echo "<br> User";
print_r($user);

if (isset($_POST['checkout'])) {
    $selectedItems = isset($_POST['selected_items']) ? explode(',', $_POST['selected_items']) : [];
    $totalPrice = isset($_POST['total_price']) ? floatval($_POST['total_price']) : 0;

    // Now you can process the selected items and the total price as needed

}

?>




<?php if ($user['role'] === "administrator"): ?>
        <?php include_once '../Navbar/adminNavbar.php';?>
        <?php else: ?>
        <?php include_once '../Navbar/userNavbar.php';?>
        <?php endif;?>


<main>

<div class="container mt-5">
    <div class="card shadow-sm p-4">
        <div class="d-flex justify-content-between">
            <!-- Order ID -->
            <h5>Order ID: 334902461</h5>
            <!-- Buttons -->
            <div>
                <button class="btn btn-outline-secondary me-2">Invoice</button>
                <button class="btn btn-primary">Track order</button>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center">
            <!-- Order Date & Estimated Delivery -->
            <p class="text-muted">Order date: Feb 16, 2022</p>
            <p class="text-success">Estimated delivery: May 14, 2022</p>
        </div>

        <!-- Product List -->
        <div class="row mt-4">
      <?php  foreach ($selectedItems as $item){
        $checkoutItems =  $products->showCheckoutItems($userId,$item);
                ?>

            <!-- MacBook Product -->
            <div class="col-12 d-flex align-items-center mb-3">
                <img src="/uploads/<?=$checkoutItems['product_image']?>" alt="MacBook Pro 14" width="50" class="me-3">
                <div>
                    <h6><?=$checkoutItems['product_name']?></h6>
                    <p class="text-muted"><?=$checkoutItems['product_description']?></p>
                </div>
                <div class="ms-auto">
                    <p class="mb-0">₱<?=number_format($checkoutItems['product_price'], 2)?></p>
                    <p class="text-muted">Qty: <?=$checkoutItems['quantity']?></p>
                </div>
            </div>
            <?php  } ?>
           

           
        </div>

        <!-- Payment and Delivery Section -->
        <div class="row mt-4 border-top ">
            <div class="col-md-6 mt-3">
                <!-- Payment Info -->
                <h6>Payment</h6>
                <p class="text-muted">Visa **56</p>
            </div>
            <div class="col-md-6 mt-3">
                <!-- Delivery Info -->
                <h6>Delivery</h6>

                <p class="text-muted">
                    <?=$user['address']?><br>
                    <?= $user['mobile_number']?><br>
                    <?=$user['first_name']?> <?=$user['last_name']?>
                </p>
            </div>
        </div>



            <!-- Payment and Delivery Section -->
            <div class="row mt-4 border-top ">
            <div class="col-md-6 mt-3">
                <!-- Payment Info -->
                <h6>Payment</h6>
                <p class="text-muted">Visa **56</p>
            </div>
            <div class="col-md-6 mt-3">
                <!-- Delivery Info -->
                <h6>Order Summary</h6>

        <div class="d-flex justify-content-between">
    <span>Subtotal</span>
    <span>$</span>
</div>

<div class="d-flex justify-content-between">
    <span>Discount <span class="text-muted">discount</span></span>
    <span class="text-danger">- $</span>
</div>

<div class="d-flex justify-content-between">
    <span>Delivery <i class="bi bi-info-circle" data-bs-toggle="tooltip" title="Free Delivery"></i></span>
    <span>$</span>
</div>

<div class="d-flex justify-content-between">
    <span>Tax <i class="bi bi-info-circle" data-bs-toggle="tooltip" title="Calculated at checkout"></i></span>
    <span>+ $</span>
</div>

<hr>

<div class="d-flex justify-content-between fw-bold">
    <span>Total</span>
    <span>$</span>
</div>
</div>
</div>

    </div>
</div>


</main>


<?php include_once '../Footer/footer.php';?>