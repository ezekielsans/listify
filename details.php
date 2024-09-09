<?php
error_reporting(E_ALL);
include_once 'productController.php';
$productId = $_GET['ID'];

if(isset($productId)){
    $product = $products->getProductById($productId);

    print_r($product);
}


if(isset($_POST['delete'])){
    //print_r($_POST);
    //print_r($productId );
    $products->deleteProduct($productId);
header("Location: index.php");
}

?>

<?php include_once('templates/header.php');?>

<main>

<div class="container">
<?php if($product): ?> 
<input type="hidden" value="<?= $product['ID'];?>">
 <h1 class="mt-5"><?=$product['product_category'];?> Details</h1>
 <div class="card mb-3">
  <img src="/uploads/<?=$product['product_image'];?>" class="card-img-top img-fluid" alt="..." >
  <div class="card-body">
    <h5 class="card-title"><?=$product['product_name'];?></h5>
    <p class="card-text"><?=$product['product_description'];?></p>
    <p class="card-text"><small class="text-body-secondary">Last updated <?=$product['updated_at'];?></small></p>
  </div>
</div>
<div class="d-flex"">
<form method="post">
<div class="btn-group">
<a class="btn btn-primary mx-2" href="editProduct.php?ID=<?=$product['ID'];?>">Edit Product</a>
<button type="submit" class="btn btn-danger" name="delete">Delete Product</button>
<input type="hidden" value="<?php $product['ID'];?>">
</form>
</div>
<div class="col">
<a class="mx-5 btn btn-primary" href="index.php"> Return </a>

</div>
</div>
<!-- <div class="mt-2">

<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Description</th>
        </tr>
        <tr>
            <th>Created At</th>
            <td><?=$products['createdAt'];?></td>
        </tr>
        <tr>
            <th>Updated At</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $item) {?>
            <tr>
            <td width="50px"> <a href="details.php?ID=<?=$item['ID'];?> " class="btn btn-sm bg-primary text-white">View</a></td></td>
            <td width="50px"> <a href="details.php?ID=<?=$item['ID'];?> " class="btn btn-sm bg-primary">Edit</a></td></td>
            <td> <?=$item['product_name'];?></td>
            <td> <?=$item['created_at'];?></td>
        </tr>
       <?php }?>
    </tbody>
</table>
</div> -->

<?php else:?>
    <h3 class="mt-5">Product does not exist</h3>
<?php endif;?>
</div>
</main>

<?php include_once('templates/footer.php');?>
