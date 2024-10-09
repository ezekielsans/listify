<?php


$users->startSession();
$user = $users->getUserId($_SESSION['LoginUser']['ID']);

$userOrders = $orders->showUserOrdersCancelled($user['user_id']);
// $activeTab ='myOrders'; 
//echo "<br/> user orders <br/>";
print_r($userOrders);
$counter = 1;
?>

<?php if($userOrders):?>

<?php foreach($userOrders as $order) {?>
    <div class="card my-4">
    <div class="card-body">
        <!-- Seller Info and Order Status -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <!-- <h6 class="text-muted mb-0">Preferred <?=$order['seller_name']?></h6> -->
            <span class="badge bg-danger text-white"><?=$order['order_status']?></span>
        </div>

        <!-- Product Info -->
        <div class="d-flex gap-2">
            <div class="col-md-2 ">
                <img src="/uploads/<?=$order['product_image']?>" alt="Product Image" class="img-fluid">
            </div>
            <div class="col-md-7">
                <h5 class="mb-1"><?=$order['product_name']?></h5>
                <p class="mb-1"><?=$order['product_description']?></p>
                <p class="text-muted">x<?=$order['quantity']?></p>
            </div>
            <div class="col-md-3 text-end px-3">
                <p>Order Total: </p> <h4 class="text-danger"> ₱<?=number_format($order['total_price'])?><h4/>
            </div>
        </div>

        <!-- Delivery Info (Optional) -->
        <!-- <p class="text-muted small mb-1">
            Delivery attempt should be made between <?=$order['delivery_start']?> and <?=$order['delivery_end']?>
        </p> -->

        <!-- Action Buttons -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div>
                <a href="#" class="btn btn-outline-primary btn-sm me-2">Contact Seller</a>
                <a href="details.php?ID=<?=$order['product_id']?>" class="btn btn-secondary btn-sm">View Product</a>
            </div>
            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteConfirmModal" data-user-id="<?=$order['order_id']?>">Re-Order</button>
        </div>
    </div>
</div>
<?php } ?>


<?php else:?>
<div class="mt-5 text-center ">
    <h4 class="text-muted">No orders yet...</h4>
    </div>

 <?php endif;?>
