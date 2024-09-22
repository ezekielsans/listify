<?php
include_once 'productController.php';
include_once 'usersController.php';
$users->startSession();
$user = $users->getUserId($_SESSION['LoginUser']['ID']);

$productId = $_GET['ID'];

if (isset($productId)) {
    $product = $products->getProductById($productId);

    print_r($product);
}

if (isset($_POST['delete'])) {
    //print_r($_POST);
    //print_r($productId );
    $products->deleteProduct($productId);
    header("Location: index.php");
}

?>

<?php include_once 'components/header.php';?>

<main>

<div class="container">
<?php if ($product): ?>
<input type="hidden" value="<?=$product['ID'];?>">
 <h1 class="mt-5"><?=$product['product_category'];?> Details</h1>

<div class="d-flex justify-content-between mb-5">
    <div class="col">
  <img src="/uploads/<?=$product['product_image'];?>" class="card-img-top rounded img-fluid" alt="product-image" style="height: 400px; width: 400px; object-fit: cover;" >
  </div>
  <div class="col-md-6 mb-4">
    <form action="" method="post" class="p-3 ">
        <!-- Hidden Input for Product ID -->
        <input type="hidden" name="product_id" value="<?=$product['ID'];?>">

        <!-- Product Name -->
        <h5 class="mb-3"><?=$product['product_name'];?></h5>

        <!-- Product Description -->
        <p class="mb-3"><?=$product['product_description'];?></p>

        <!-- Last Updated Info -->
      
        <p class="mb-3 text-muted"><small>Last updated <?=$product['updated_at'];?></small></p>
  
        <!-- Quantity Selector -->
        <div class="mb-5 d-flex align-items-center">
            <label for="form1" class="me-2">Quantity:</label>
            <div class="d-flex gap-3 align-items-center justify-content-center">
            <input id="form1" min="1" name="quantity" value="1" type="number" class="form-control"  style="width: 50px;">  
            <p class="mb-3 text-muted"><?=$product['product_stocks'];?> stocks available</p>
        </div>
        </div>

        <!-- Buttons (Add to Cart & Buy Now) -->
        <div class="d-grid gap-2 d-md-flex justify-content-md-start">
            <button type="submit" name="add_to_cart" class="btn btn-primary me-2">Add to Cart</button>
            <button type="submit" name="buy_now" class="btn btn-success">Buy Now</button>
        </div>
    </form>
</div>

</div>




<div class="d-flex"">
<form method="post">
<div class="btn-group">
<?php if (isset($_SESSION['LoginUser']) && ($user['role'] === "administrator")): ?>
    <a class="btn btn-primary mx-2" href="editProduct.php?ID=<?=$product['ID'];?>">Edit Product</a>
    <button type="submit" class="btn btn-danger" name="delete">Delete Product</button>
<?php endif;?>
<input type="hidden" value="<?php $product['ID'];?>">
</form>
</div>
<div class="col">
<a class="mx-5 btn btn-primary" href="index.php"> Return </a>

</div>
</div>

<?php else: ?>
    <h3 class="mt-5">Product does not exist</h3>
<?php endif;?>
</div>
</main>

<?php include_once 'components/footer.php';?>
