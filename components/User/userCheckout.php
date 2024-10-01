<?php
require_once '../../controllers/usersController.php';
require_once '../../controllers/productController.php';
$users->startSession();

$user = $users->getUserId($_SESSION['LoginUser']['ID']);
$userId = $user['user_id'];
echo "<br> User  ";
print_r($user);

$date_today = date('F j, Y');
$totalOrderPrice = 0;
$totalItems = 0;

//if checkout button is clicked

if (isset($_POST['checkout'])) {
    $selectedItems = isset($_POST['selected_items']) ? explode(',', $_POST['selected_items']) : [];
    $totalPrice = isset($_POST['total_price']) ? floatval($_POST['total_price']) : 0;
    print_r($selectedItems);
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
            <h5><svg width="35px" height="35px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <path d="M17 10C17 11.7279 15.0424 14.9907 13.577 17.3543C12.8967 18.4514 12.5566 19 12 19C11.4434 19 11.1033 18.4514 10.423 17.3543C8.95763 14.9907 7 11.7279 7 10C7 7.23858 9.23858 5 12 5C14.7614 5 17 7.23858 17 10Z" stroke="#00d619" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M14.5 10C14.5 11.3807 13.3807 12.5 12 12.5C10.6193 12.5 9.5 11.3807 9.5 10C9.5 8.61929 10.6193 7.5 12 7.5C13.3807 7.5 14.5 8.61929 14.5 10Z" stroke="#00d619" stroke-linecap="round" stroke-linejoin="round">
            </path></g></svg>
            Delivery Address</h5>
            <div>
          <p class="text-muted"> <span class="fw-bold">Order date:</span>  <?=$date_today?></p>
        </div>
        </div>
        

        <div class="d-flex justify-content-between align-items-center">
            <!-- Order Date & Estimated Delivery -->  <p class="text-muted">
            <?=$user['first_name']?> <?=$user['last_name']?>        
            <?php if($user['address_line1'] === null): ?>
                <br> <p class="text-muted">To continue order processing, update information first <a href="../../components/editProfile.php?ID=<?=$user['user_id']?>">update details</a></p><br>
            <?php else: ?>
                <br> <?=$user['address_line1']?><br>
            <?php endif; ?>
                <?= $user['mobile_number']?><br>
                   
                </p>
            
       
        </div>
        </div>
        </div>

        <!-- Product List -->


        <div class="container mt-3">
    <div class="card shadow-sm p-4">
        <!-- Header Row -->
        <div class="row mb-4">
            <div class="col-6">
                <h5>Products Ordered</h5>
            </div>
            <div class="col-2 text-center">
                <p class="fw-bold">Item Price</p>
            </div>
            <div class="col-2 text-center">
                <p class="fw-bold">Quantity</p>
            </div>
            <div class="col-2 text-center">
                <p class="fw-bold">Subtotal</p>
            </div>
        </div>

        <!-- Products List -->
        <div class="row mt-4">
            <?php foreach ($selectedItems as $item) {
                $checkoutItems = $products->showCheckoutItems($userId, $item);
                 // Calculate the subtotal for each product
                 $subtotal = $checkoutItems['quantity'] * $checkoutItems['product_price'];
                 $totalOrderPrice += $subtotal; // Add to the total order price
            
                 $totalItems += $checkoutItems['quantity'];

                // Add to the total order price
                ?>

                <!-- Single Product Row -->
                <div class="row align-items-center mb-3">
                    <!-- Product Image and Name -->
                    <div class="col-6 d-flex align-items-center">
                        <img src="/uploads/<?=$checkoutItems['product_image']?>" alt="<?=$checkoutItems['product_name']?>" width="50" class="me-3">
                        <div>
                            <h6 class="mb-0"><?=$checkoutItems['product_name']?></h6>
                            <p class="text-muted mb-0"><?=$checkoutItems['product_description']?></p>
                        </div>
                    </div>

                    <!-- Product Price -->
                    <div class="col-2 text-center">
                        <p class="mb-0">₱<?=number_format($checkoutItems['product_price'], 2)?></p>
                    </div>

                    <!-- Product Quantity -->
                    <div class="col-2 text-center">
                        <p class="mb-0"><?=$checkoutItems['quantity']?></p>
                    </div>

                    <!-- Product Subtotal -->
                    <div class="col-2 text-center">
                        <p class="mb-0 fw-bold">₱<?= number_format($subtotal, 2)?></p>
                    </div>
                    
                </div>
               
            <?php } ?>
         
        </div>

        <!-- Order Total Section -->
        <div class="row mt-4 border-top mt-3 mb-3">
            <div class="col-md-6 mt-3"></div> <!-- Empty space to align the total -->
            <div class=" mx-5 col-md-5 d-flex justify-content-between">
                <p class="text-muted">Order Total: (<?=$totalItems?> Items:)</p>
                <p class="fw-bold text-danger">₱<?=number_format($totalOrderPrice, 2)?></p>
                </div>
        </div>
    </div>
</div>
</div>

        </div>
        </div>
        <div class="container mt-3">
    <div class="card shadow-sm p-4">
        <!-- Payment and Delivery Section -->
        <div class="row mt-4 border-top">
            <div class="col-md-6 mt-3">
                <!-- Payment Info -->
                <h5>Payment</h5>
                <form>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="plan" id="plan1">
                        <label class="form-check-label" for="plan1">
                            Cash on Delivery
                           
                        </label>
                    </div>

              


                   
                </form>
           
            </div>

            <!-- Order Summary -->
            <div class="mx-5 col-md-5 mt-3">
                <h6>Order Summary</h6>

                <div class="d-flex justify-content-between">
                    <span>Merchandise Subtotal</span>
                    <span>₱<?=$totalOrderPrice?></span>
                </div>

                <div class="d-flex justify-content-between">
                    <span>Shipping Total</span>
                    <span>₱36.00</span>
                </div>

                <hr>

                <div class="d-flex justify-content-between fw-bold">
                    <span>Total Payment</span>
                    <span class="text-danger">₱<?=$totalPrice?></span>
                </div>

                <button class="btn btn-primary mt-4 w-100">Place Order</button>
            </div>
        </div>
    </div>
</div>

  



</main>


<?php include_once '../Footer/footer.php';?>