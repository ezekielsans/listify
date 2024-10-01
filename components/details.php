<?php
include_once '../controllers/productController.php';
include_once '../controllers/usersController.php';

$users->startSession();
$user = $users->getUserId($_SESSION['LoginUser']['ID']);

$productId = $_GET['ID'];

if (isset($productId)) {
    $product = $products->getProductById($productId);

   // print_r($product);
}

if (isset($_POST['delete'])) {
    //print_r($_POST);
    //print_r($productId );
    $products->deleteProduct($productId);
    header("Location: index.php");
}

if (isset($_POST['add_to_cart'])) {
    //print_r($_POST);
    //print_r($productId );
    $total_price = $_POST['product_price'] * $_POST['quantity'];
    $products->createOrder($_POST['userId'], $total_price, $_POST['productId'], $_POST['product_price'],$_POST['quantity']);
    
    $products->addToCart($_POST['userId'], $total_price, $_POST['productId'], $_POST['product_price'],$_POST['quantity']);
    echo "Added to cart";
}

?>


<?php if ($user['role']==="administrator"):?>
        <?php include_once 'Navbar/adminNavbar.php';?>
        <?php else:?>
        <?php include_once 'Navbar/userNavbar.php';?>
        <?php endif; ?>

<main>

<div class="container">
<?php if ($product): ?>

<input type="hidden" value="<?=$product['product_id'];?>">
 <h1 class="mt-5"><?=$product['product_category'];?> Details</h1>

<div class="d-flex justify-content-between mb-5">
    <div class="col">
  <img src="/uploads/<?=$product['product_image'];?>" class="card-img-top rounded img-fluid" alt="product-image" style="height: 400px; width: 400px; object-fit: cover;" >
  </div>
  <div class="col-md-6 mb-4">
    <form id="addToCartForm"  method="post" class="p-3 ">
        <!-- Hidden Input for Product ID -->
        <input type="hidden" name="product_id" value="<?=$product['product_id'];?>">

        <!-- Product Name -->
        <h2><?=$product['product_name'];?></h2>

        <!-- Product Description -->
        <p class="mb-1 text-muted"><?=$product['product_description'];?></p>
        <h2 name="product_price" class="mb-3">₱<?=number_format($product['product_price']);?></h2>

        <!-- Last Updated Info -->

        <p class="mb-3 text-muted"><small>Last updated <?=$product['updated_at'];?></small></p>

        <!-- Quantity Selector -->
        <div class="mb-5 d-flex flex-column align-items-start">
  <div class="d-flex align-items-center mb-2">
     
  <?php if ($product['product_stocks'] === 0): ?>
   
    <label for="quantity" class="me-2 text-muted">Quantity:</label>
    <div class="input-group w-auto text-muted">
      <button class="btn btn-secondary text-white" type="button" id="btn-decrement" aria-label="Decrease quantity" disabled>-</button>
      <input type="number" name="quantity" id="quantity" class="form-control form-control-lg text-center text-muted"  value="0"   min="1" max="<?=$product['product_stocks'];?>" style="width: 80px;" disabled>
      <button class="btn btn-secondary text-white" type="button" id="btn-increment" aria-label="Increase quantity" disabled>+</button>
    </div>
  
    <?php else: ?>

    <div class="input-group w-auto">
      <button class="btn btn-outline-secondary" type="button" id="btn-decrement" aria-label="Decrease quantity">-</button>
      <input type="number" name="quantity" id="quantity" class="form-control form-control-lg text-center" value="1" min="1" max="<?=$product['product_stocks'];?>" style="width: 80px;">
      <button class="btn btn-outline-secondary" type="button" id="btn-increment" aria-label="Increase quantity">+</button>
    </div>

  <?php endif;?>
  </div>
  <p class="mb-3 text-muted"><?=$product['product_stocks'];?> stocks available</p>
</div>
<?php if ($product['product_stocks'] === 0): ?>
        <!-- Buttons (Add to Cart & Buy Now) -->
<input type="hidden" name="productId" value="<?=$product['product_id'];?>">
<input type="hidden" name="userId" value="<?=$user['user_id'];?>">
        <div class="d-grid gap-2 d-md-flex justify-content-md-start">
            <button type="submit" id="addToCart" name="add_to_cart" class="btn btn-secondary me-2" disabled>Add to Cart</button>
            <button type="submit" name="buy_now" class="btn btn-secondary" disabled>Buy Now</button>
        </div>
<?php else: ?>
          <!-- Buttons (Add to Cart & Buy Now) -->
<input type="hidden" name="productId" value="<?=$product['product_id'];?>">
<input type="hidden" name="userId" value="<?=$user['user_id'];?>">
        <div class="d-grid gap-2 d-md-flex justify-content-md-start">
            <button type="submit" id="addToCart" name="add_to_cart" class="btn btn-primary me-2">Add to Cart</button>
            <button type="submit" name="buy_now" class="btn btn-success">Buy Now</button>
        </div>

        <?php endif;?>

    </form>
</div>

<!-- Toast Notification -->
<div class="toast align-items-center text-bg-primary border-0 top-50 start-50 translate-middle" id="liveToast" role="alert" aria-live="assertive" aria-atomic="true">
  <div class="d-flex">
    <div class="toast-body">
      Product added to cart!
    </div>
    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
</div>


</div>





<div class="d-flex"">
<form method="post">
<div class="btn-group">
<?php if (isset($_SESSION['LoginUser']) && ($user['role'] === "administrator")): ?>
    <a class="btn btn-primary mx-2" href="editProduct.php?ID=<?=$product['ID'];?>">Edit Product</a>
    <button type="submit" class="btn btn-danger" name="delete">Delete Product</button>
<?php endif;?>
<input type="hidden" value="<?php $product['product_id'];?>">
</form>
</div>
<div class="col">
<!-- <a class="mx-5 btn btn-primary" href="index.php"> Return </a> -->

</div>
</div>

<?php else: ?>
    <h3 class="mt-5">Product does not exist</h3>
<?php endif;?>
</div>
</main>




<?php include_once '../components/Footer/footer.php';?>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const quantityInput = document.getElementById('quantity');
    const decrementBtn = document.getElementById('btn-decrement');
    const incrementBtn = document.getElementById('btn-increment');
    const maxStock = parseInt(quantityInput.max, 10);

    decrementBtn.addEventListener('click', function () {
      let currentValue = parseInt(quantityInput.value, 10);
      if (currentValue > 0) {
        quantityInput.value = currentValue - 1;
      }
    });

    incrementBtn.addEventListener('click', function () {
      let currentValue = parseInt(quantityInput.value, 10);
      if (currentValue < maxStock) {
        quantityInput.value = currentValue + 1;
      }
    });
  });


   // Handle Add to Cart via AJAX and Show Toast
   const addToCartBtn = document.getElementById('addToCart');
    const toastLive = document.getElementById('liveToast');

    addToCartBtn.addEventListener('click', function () {
        // Prepare form data
        const formData = new FormData(document.getElementById('addToCartForm'));

        // Send AJAX request to add to cart
        fetch('', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())  // Handle response (could be JSON)
        .then(data => {
            // Show the toast after a successful request
            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLive);
            toastBootstrap.show();
        })
        .catch(error => {
            console.error('Error adding to cart:', error);
        });
    });



</script>