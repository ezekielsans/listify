<?php
require_once 'productController.php';
require_once 'usersController.php';
$users->startSession();
$user = $users->getUserId($_SESSION['LoginUser']['ID']);

// print_r($user);
// echo " user details <br>";
$searchTerm = isset($_GET['search']) ? $_GET['search'] : "";

$currentPage = $_GET['page'] ?? 1;
$itemsPerPage = 10;
$totalItems = $products->totalProducts($searchTerm);
$totalPages = ceil($totalItems / $itemsPerPage);
// print_r($currentPage);
// echo " currentPage <br>";
// print_r($totalItems);
// echo " total Items <br>";
// print_r($totalPages);
// echo " totalPages <br>";

$items = $products->getAllProducts($currentPage, $itemsPerPage, $searchTerm);
$pageLinks = $products->generatePageLinks($totalPages, $currentPage, $searchTerm);

// print_r($pageLinks);
print_r($_SESSION['LoginUser']);
?>

<?php include_once './components/header.php';?>


<main>

<div class="container">
<div class="d-flex justify-content-between mt-5 gap-5" >
<h1 >Products</h1>
<form class="w-25" method="get">
    <div class="input-group mb-3 ">
        <input class="form-control" type="search" name="search" placeholder="Search a product..." required>
        <button type="submit" class="btn btn-primary text-white input-group-append" >Search</button>
    </div>
</form>

</div>

<div class="mt-3 mb-5">
    <?php if (isset($_SESSION['LoginUser']) && ($user['role'] === "administrator")) : ?>
        <a href="addProduct.php" class="btn btn-lg bg-primary text-white mb-5"> Add New Product</a>
        <?php endif;?>
        <div class="d-flex flex-row-reverse">



        </div>


<div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3 mb-5">
<?php foreach ($items as $item) {?>
 <div class="col">
 <div class="card" style="width: 18rem;">
  <img class="card-img-top" src="/uploads/<?=$item['product_image']?>" height="300" alt="Card image cap">
  <div class="card-body">
    <div class="d-flex">
        <div class="col">
    <h5 class="card-title"><?=$item['product_name']?></h5>
    <!-- <p class="card-text"><?=$item['product_description']?></p> -->
</div>
<h5 class="card-title"><?="₱".number_format(round($item['product_price'],2))?></h5>
    </div>
    <div class="d-flex text-center mt-3 justify-content-between">
    <a href="details.php?ID=<?=$item['ID'];?>" class="btn btn-primary">View Product</a>
    <a href="details.php?ID=<?=$item['ID'];?>" class="btn btn-success">Add to Cart </a>
  </div>
  </div>
</div>
</div>
<?php }?>
</div>

<div class="d-flex gap-5 align-items-center justify-content-center">

<nav  aria-label="Page navigation">
    <ul class="pagination">
    <!-- <li class="page-item"><a class="page-link" href="#">Previous</a></li>
    <li class="page-item"><a class="page-link" href="#">1</a></li>
    <li class="page-item"><a class="page-link" href="#">2</a></li>
    <li class="page-item"><a class="page-link" href="#">3</a></li>
    <li class="page-item"><a class="page-link" href="#">Next</a></li> -->
        <?=$pageLinks;?>
    </ul>
</nav>


<p>showing total of <?=$totalItems?> products</p>
</div>
</div>
</div>

</main>
<?php include_once 'components/footer.php';?>