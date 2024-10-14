<?php
include_once '../../controllers/productController.php';
include_once '../../controllers/usersController.php';
//$users->startSession();
$productId = $_GET['ID'];

if (isset($productId)) {
    $product = $products->getProductById($productId);

    //print_r($product);
}

if (isset($_POST['save'])) {
    //print_r($_POST);
    $products->editProduct($_POST['product_name'], $_POST['product_category'],$_POST['product_price'], $_POST['quantity'], $_POST['product_description'], $_SESSION['LoginUser'], $_POST['ID']);
    if ($_FILES['image']['name']) {

        $milliseconds = intval(microtime(true) * 1000);
        $imageName = $products->uploadImage('image', 'uploads', $milliseconds . "_" . $_POST['ID']);
        if ($imageName != "Failed") {
            $products->updateImageData($_POST['ID'], $imageName);
        }

    }
    // header('Location: details.php?ID=' . $_POST['ID']);

}
?>
<link rel="stylesheet" href="editProduct.css">
<?php include_once '../../components/header.php';?>

<main>

<div class="container">
<div class="row">
    <div class="col-12 d-flex justify-content-between align-items-center my-5">
        <h1>Edit Product Form</h1>
        <a href="../../components/Admin/inventoryAdminDashboard.php" class="btn btn-primary">Return</a>
    </div>
</div>

<?php if ($product): ?>
<form method="POST"  enctype="multipart/form-data">
<input type="hidden" name="ID" id="product_id" class="form-control form-control-lg" value="<?=$product['product_id'];?>">
<div class="mb-3">
<label class="form-label">Product Name</label>
<input type="text" name="product_name" id="product_name" class="form-control form-control-lg" value="<?=$product['product_name'];?>">
</div>
<div class="mb-3">
    <label class="form-label">Product Category</label>
    <input type="text" name="product_category" id="product_category" class="form-control form-control-lg" value="<?=$product['product_category'];?>">
</div>

<div class="mb-3">
    <label class="form-label">Product Price</label>
    <input type="text" name="product_price" id="product_price" class="form-control form-control-lg" value="<?=$product['product_price'];?>">
</div>
<div class="mb-3">
<label class="form-label">Quantity</label>
<div class="input-group w-25">
        <button class="btn btn-outline-secondary" type="button" id="btn-decrement">-</button>
        <input type="number" name="quantity" id="quantity" class="form-control form-control-lg" value="<?=$product['product_stocks'];?>" min="0" max="9999">
        <button class="btn btn-outline-secondary" type="button" id="btn-increment">+</button>
</div>
</div>
<div class="mb-3">
<label class="form-label">Product Image</label>
<input type="file" name="image" id="image" class="form-control form-control-lg">
</div>
<div class="mb-3">
    <label class="form-label">Product Description</label>
<textarea rows="5" name="product_description" id="product_description" class="form-control" ><?=$product['product_description'];?>
</textarea>
</div>


<button type="submit" name="save" class="bg-primary btn btn-lg my-4">Update</button>

</form>

<?php else: ?>
    <h1 class="my-5">Product Does not exist</h1>
    <?php endif;?>
</div>
</main>
<script>

 const subtractBtn =    document.getElementById('btn-decrement');
const quantityInput =    document.getElementById('quantity');
const addBtn =     document.getElementById('btn-increment');

   
    // Handle increment
    addBtn.addEventListener('click', function () {
            var currentValue = parseInt(quantityInput.value);
            if (!isNaN(currentValue) && currentValue < parseInt(quantityInput.max)) {
                quantityInput.value = currentValue + 1;
            }
        });



    // Handle decrement
    subtractBtn.addEventListener('click', function () {
            var currentValue = parseInt(quantityInput.value);
            if (!isNaN(currentValue) && currentValue > 0) {
                quantityInput.value = currentValue - 1;
            }
        });





</script>
<?php include_once '../../components/Footer/footer.php';?>
