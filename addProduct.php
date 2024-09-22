<?php
include_once 'productController.php';
include_once 'usersController.php';
$users->startSession();
// if(!){

// header("Location: login.php");

// }


if (isset($_POST['submit'])) {
    $productName = $_POST['productName'];
    $productDescription = $_POST['productDescription'];
    $productCategory = $_POST['productCategory'];
    $id = $products->insertProduct($productName, $productDescription, $productCategory,$_SESSION['LoginUser']);
    if ($id) {
        $imageName = $products->uploadImage('image', 'uploads', $id);
        if ($imageName != "Failed") {
            $products->updateImageData($id,$imageName);
        }
        header("Location: details.php?ID= " . $id);
    }
}

?>

<?php include_once 'components/header.php';?>

<main>

<div class="container">
<h1 class="my-5">Add New Product Form</h1>
<form action="" method="post" enctype="multipart/form-data">
<div class="mb-3">
<label class="form-label">Product Name</label>
<input type="text" name="productName" id="product_name" class="form-control form-control-lg"  placeholder="Specify product name..." required>
</div>
<div class="mb-3">
<label class="form-label">Product Category</label>
<input type="text" name="productCategory" id="product_category" class="form-control form-control-lg"  placeholder="Specify product category..." required>
</div>

<div class="mb-3">
<label class="form-label">Product Image</label>
<input type="file" name="image" id="image" class="form-control form-control-lg">
</div>
<div class="mb-3">
    <label class="form-label">Product Description</label>
<textarea rows="5" name="productDescription" id="product_description" class="form-control" placeholder="Specify product description..." required>
</textarea>
</div>

<button type="submit" name="submit" class="bg-primary btn btn-lg my-4">Save</button>

</form>
</div>
</main>

<?php include_once 'components/footer.php';?>
