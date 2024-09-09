<?php
error_reporting(E_ALL);
include_once 'productController.php';

$items = $products->getAllProducts();
//print_r($items);
?>

<?php include_once 'templates/header.php';?>


<main>

<div class="container">
<h1 class="mt-5">Products</h1>

<div class="mt-3 mb-5">
<a href="addProduct.php" class="btn btn-lg bg-primary text-white mb-5"> Add New Product</a>
<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th colspan="2">ID</th>
        <th>Product Name</th>
        <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($items as $item) {?>
            <tr>
            <td width="50px"> <a href="details.php?ID=<?=$item['ID'];?> " class="btn btn-sm bg-primary text-white">View</a></td></td>
            <td width="50px"> <a href="details.php?ID=<?=$item['ID'];?> " class="btn btn-sm bg-primary">Edit</a></td></td>
            <td> <?=$item['product_name'];?></td>
            <td> <?=$item['created_at'];?></td>
        </tr>


       <?php }?>

    </tbody>

</table>
</div>
</div>
</main>
<?php include_once 'templates/footer.php';?>