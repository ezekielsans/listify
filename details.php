<?php
error_reporting(E_ALL);
include_once 'productController.php';
$id = $_GET['iID'];

if(isset($id)){
    $items = $products->getProductById($id);
}

?>

<?php include_once('templates/header.php');?>

<main>

<div class="container">
<?php if($product): ?> 

    <h1 class="mt-5"><?=$product['product_name'];?></h1>
<div class="mt-2">

<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Description</th>
        </tr>
        <tr>
            <th>Created At</th>
            <td><?=$product['createdAt'];?></td>
        </tr>
        <tr>
            <th>Updated At</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($items as $item) {?>
            <tr>
            <td width="50px"> <a href="details.php?ID=<?=$product['ID'];?> " class="btn btn-sm bg-primary text-white">View</a></td></td>
            <td width="50px"> <a href="details.php?ID=<?=$product['ID'];?> " class="btn btn-sm bg-primary">Edit</a></td></td>
            <td> <?=$item['product_name'];?></td>
            <td> <?=$item['created_at'];?></td>
        </tr>
       <?php }?>
    </tbody>
</table>
</div>
<?php else:?>
    <h3 class="mt-5">Product does not exist</h3>
<?php endif;?>
</div>
</main>

<?php include_once('templates/footer.php');?>
