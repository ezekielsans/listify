<?php
require_once '../../controllers/usersController.php';
require_once '../../controllers/productController.php';
require_once '../../controllers/ordersController.php';

$users->startSession();

$user = $users->getUserId($_SESSION['LoginUser']['ID']);
$userId = $user['user_id'];
echo "<br> User  ";
print_r($user);

$date_today = date('F j, Y');
$totalOrderPrice = 0;
$totalItems = 0;
$shippingFee = 20;

//if checkout button is clicked

if (isset($_POST['checkout'])) {
    $selectedItems = isset($_POST['selected_items']) ? explode(',', $_POST['selected_items']) : [];
    $totalPrice = isset($_POST['total_price']) ? floatval($_POST['total_price']) : 0;

}

if (isset($_POST['place_order'])) {

    $userId = $user['user_id'];
    $shippingAddress = $user['address_line2'];
    $paymentMethod = $_POST['payment_method'];
// Ensure that selected items are being retrieved correctly
    $selectedItems = isset($_POST['selected_items']) ? explode(',', $_POST['selected_items']) : [];

    $totalPrice = isset($_POST['total_price']) ? floatval($_POST['total_price']) : 0;
    if (!empty($selectedItems)) {

//place order for each selected item
        foreach ($selectedItems as $item) {

            $checkoutItems = $orders->showCheckoutItems($userId, $item);
            if ($checkoutItems) {
                print_r($userId);
                print_r($item);
                print_r($shippingAddress);
                 $orders->placeOrder($userId, $paymentMethod, $shippingAddress);

            }
        }
        echo "<br> Order successfully placed! <br>";
        echo "Shipping Address: " . print_r($shippingAddress, true);
        echo "<br> User ID: " . print_r($userId, true);
        echo "<br> Total Price: " . print_r($totalPrice, true);
    } else {
        echo "<br>No items selected for order.<br>";
        
    }
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
            <!-- Order Date & Estimated Delivery -->
                <div class="col">
                    <p class="text-muted">
            <?=$user['first_name']?> <?=$user['last_name']?>
            </p>
            <?php if ($user['address_line1'] === null): ?>
                <p class="text-muted">To continue order processing, update information first <a href="../../components/editProfile.php?ID=<?=$user['user_id']?>">update details</a></p>
            <?php else: ?>
               <p class="text-muted"><?=$user['address_line1']?> <?=$user['city']?> , <?=$user['country']?>     </p>


            <?php endif;?>
            <p class="text-muted">
                <?=$user['mobile_number']?><br>

                </p>
                </div>

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
    $checkoutItems = $orders->showCheckoutItems($userId, $item);

    // Calculate the subtotal for each product
    $subtotal = $checkoutItems['quantity'] * $checkoutItems['product_price'];
    $totalOrderPrice += $subtotal; // Add to the total order price
    print_r($checkoutItems);
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
                        <p class="mb-0 fw-bold">₱<?=number_format($subtotal, 2)?></p>
                    </div>

                </div>

            <?php
}?>

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
                <form method="post">
                    <div class="form-check">
                        <input class="form-check-input"  name="payment_method" type="radio" name="plan" id="plan1">
                        <label class="form-check-label" for="plan1">
                            Cash on Delivery

                        </label>
                    </div>







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
                    <span id="shippingFee">₱<?=$shippingFee?></span>
                </div>

                <hr>

                <div class="d-flex justify-content-between fw-bold">
                    <span>Total Payment</span>
                    <span id="totalPayment" name="totalPayment" class="text-danger">₱<?=$totalPrice?></span>
                </div>
              
                <input type="hidden" name="total_price" value="<?=$totalOrderPrice?>">
                <input type="hidden" name="selected_items" value="<?=implode(',', $selectedItems)?>">

                <!-- Payment Method -->
                <!-- <input type="radio" name="payment_method" value="cod" checked> -->

                <!-- Submit Button -->
                <button type="submit" name="place_order" class="btn btn-primary mt-4 w-100">Place Order</button>
</form>
            </div>
        </div>
    </div>
</div>





</main>
<script>

document.addEventListener("DOMContentLoaded", function () {

const shippingFee = document.getElementById('shippingFee');
const totalPayment = document.getElementById('totalPayment');
let result = 0;



function calculateTotalPayment(){
const shipping = Number(shippingFee.textContent.replace('₱', '').trim());
const total = Number(totalPayment.textContent.replace('₱', '').trim());


result = total+shipping;

totalPayment.innerText='₱'+result.toFixed(2);
}


calculateTotalPayment();





})



</script>

<?php include_once '../Footer/footer.php';?>