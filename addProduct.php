<?php
if(isset($_POST['submit'])){
    print_r($_POST);
}


?>

<?php include_once('templates/header.php');?>

<main>

<div class="container">
<h1 class="my-5">Add New Product Form</h1>
<form action="" method="post" enctype="multipart/form">
<div class="mb-3">
<input type="text" name="product_name" id="product_name" class="form-control form-control-lg"  placeholder="Specify product name..." required>
</div>
<div class="mb-3">
    <label class="form-label">Product Description</label>
<textarea rows="5" name="description" id="description" class="form-control" placeholder="Specify product description..." required>
</textarea>
</div>

<button type="submit" name="submit" class="bg-primary btn btn-lg my-4">Save</button>

</form>
</div>
</main>

<?php include_once('templates/footer.php');?>
