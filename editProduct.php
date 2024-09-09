<?php
error_reporting(E_ALL);
include_once 'productController.php';
$productId = $_GET['ID'];

if (isset($productId)) {
    $product = $products->getProductById($productId);

    //print_r($product);
}

if (isset($_POST['save'])) {
    //print_r($_POST);
    $products->editProduct($_POST['product_name'], $_POST['product_category'], $_POST['product_description'], $_POST['ID']);
    if ($_FILES['image']['name']) {

        $milliseconds = intval(microtime(true)*1000);
        $imageName = $products->uploadImage('image', 'uploads',$milliseconds."_".$_POST['ID']);
        if ($imageName != "Failed") {
            $products->updateImageData($_POST['ID'], $imageName);
        }

    }
   // header('Location: details.php?ID=' . $_POST['ID']);

}
?>

<?php include_once 'templates/header.php';?>

<main>

<div class="container">
<h1 class="my-5">Edit Product Form</h1>
<?php if ($product): ?>
<form method="POST"  enctype="multipart/form-data">
<input type="hidden" name="ID" id="product_id" class="form-control form-control-lg" value="<?=$product['ID'];?>">
<div class="mb-3">
<label class="form-label">Product Name</label>
<input type="text" name="product_name" id="product_name" class="form-control form-control-lg" value="<?=$product['product_name'];?>">
</div>
<div class="mb-3">
<label class="form-label">Product Category</label>
<input type="text" name="product_category" id="product_category" class="form-control form-control-lg" value="<?=$product['product_category'];?>">
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

<?php include_once 'templates/footer.php';?>
