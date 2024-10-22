<?php
require_once '../../controllers/productController.php';
require_once '../../controllers/usersController.php';
require_once '../../controllers/ordersController.php';


$users->startSession();

$user = $users->getUserId($_SESSION['LoginUser']['ID']);




$searchTerm = isset($_GET['search']) ? $_GET['search'] : "";

$currentPage = $_GET['page'] ?? 1;
$itemsPerPage = 8;
$totalItems = $products->totalProducts($searchTerm); 
$totalPages = ceil($totalItems / $itemsPerPage);

$reviews = 0;
$items = $products->getAllProducts($currentPage, $itemsPerPage, $searchTerm);
$pageLinks = $products->generatePageLinks($totalPages, $currentPage, $searchTerm);


?>

<?php include_once '../header.php';?>
<?php if ($user['role']==="administrator"):?>
        <?php include_once '../Navbar/adminNavbar.php';?>
        
        <?php else:?>

        <?php include_once '../Navbar/userNavbar.php';?>
        <?php endif; ?>

<main>

<div class="container">


<!-- Banner -->
<section class="banner my-4">
    <div class="container position-relative">
        <h2>Grab Up to 50% Off On Selected Headphones</h2>
        <a href="#" class="btn btn-primary mt-3">Buy Now</a>
        <img src="../../assets/login-page-design-1.png"   class="img-fluid mt-4 w-100" alt="..." >
    </div>
</section>


<!-- Filters -->
<div class="container mb-4">
    <div class="d-flex justify-content-between">
        <div class="btn-group">
            <button type="button" class="btn btn-outline-secondary">Headphone Type</button>
            <button type="button" class="btn btn-outline-secondary">Price</button>
            <button type="button" class="btn btn-outline-secondary">Review</button>
            <button type="button" class="btn btn-outline-secondary">Color</button>
            <button type="button" class="btn btn-outline-secondary">Material</button>
            <button type="button" class="btn btn-outline-secondary">Offer</button>
        </div>
        <button class="btn btn-outline-secondary">Sort By</button>
    </div>
</div>

<div class="d-flex justify-content-between mt-5 gap-5" >
<h1 >Products</h1>

</div>

<div class="mt-3 mb-5">
    <?php if (isset($_SESSION['LoginUser']) && ($user['role'] === "administrator")) : ?>
        <a href="addProduct.php" class="btn btn-lg bg-primary text-white mb-5"> Add New Product</a>
        <?php endif;?>
        <div class="d-flex flex-row-reverse">



        </div>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3 mb-5">
<?php foreach ($items as $item) { ?>
    <a href="../details.php?ID=<?=$item['product_id'];?>" class="text-decoration-none">

    <div class="card" style="width: 18rem;">
        <img class="card-img-top" src="/uploads/<?=$item['product_image']?>" height="300" alt="Card image cap">
        <div class="card-body">
            <div class="d-flex flex-column">
                <h4 class="card-title"><?=$item['product_name']?></h4>
                <h5 class="card-title"><?="₱".number_format(round($item['product_price'], 2))?></h5>

                <!-- Display stars -->
                <div class="d-flex align-items-center mb-2">
                    <?php 
                    //$item['average_rating']
                    $rating =3.75;  // Assuming you have this field
                    $maxStars = 5;

                    // Loop through 5 stars
                    for ($i = 1; $i <= $maxStars; $i++) {
                        if ($i <= floor($rating)) {
                            // Full Star
                            echo '<svg fill="#FFD700" height="25px" 
                                    viewBox="-1 0 19 19" xmlns="http://www.w3.org/2000/svg" class="cf-icon-svg"><path d="m12.673 10.779.798 4.02c.221 1.11-.407 1.566-1.395 1.013L8.5 13.81l-3.576 2.002c-.988.553-1.616.097-1.395-1.013l.397-2.001.401-2.02-1.51-1.397-1.498-1.385c-.832-.769-.592-1.507.532-1.64l2.026-.24 2.044-.242 1.717-3.722c.474-1.028 1.25-1.028 1.724 0l1.717 3.722 2.044.242 2.026.24c1.124.133 1.364.871.533 1.64L14.184 9.38z"></path></svg>';
                        } elseif ($i - $rating <= 0.5) {
                            // Half Star
                            echo '<svg fill="url(#half)" height="25px" viewBox="-1 0 19 19" xmlns="http://www.w3.org/2000/svg" class="cf-icon-svg"><defs><linearGradient id="half"><stop offset="50%" stop-color="#FFD700"/><stop offset="50%" stop-color="#DEDEDE"/></linearGradient></defs><path d="m12.673 10.779.798 4.02c.221 1.11-.407 1.566-1.395 1.013L8.5 13.81l-3.576 2.002c-.988.553-1.616.097-1.395-1.013l.397-2.001.401-2.02-1.51-1.397-1.498-1.385c-.832-.769-.592-1.507.532-1.64l2.026-.24 2.044-.242 1.717-3.722c.474-1.028 1.25-1.028 1.724 0l1.717 3.722 2.044.242 2.026.24c1.124.133 1.364.871.533 1.64L14.184 9.38z"></path></svg>';
                        } else {
                            // Empty Star
                            echo '<svg fill="#DEDEDE" height="25px" viewBox="-1 0 19 19" xmlns="http://www.w3.org/2000/svg" class="cf-icon-svg"><path d="m12.673 10.779.798 4.02c.221 1.11-.407 1.566-1.395 1.013L8.5 13.81l-3.576 2.002c-.988.553-1.616.097-1.395-1.013l.397-2.001.401-2.02-1.51-1.397-1.498-1.385c-.832-.769-.592-1.507.532-1.64l2.026-.24 2.044-.242 1.717-3.722c.474-1.028 1.25-1.028 1.724 0l1.717 3.722 2.044.242 2.026.24c1.124.133 1.364.871.533 1.64L14.184 9.38z"></path></svg>';
                        }
                    }
                    ?>
                <?php if($reviews):?>
                    ()
                    <?php else:?>
                        (0) Review
                    <?php endif;?>
                </div>

            </div>
        </div>
    </div>
    </a>
<?php } ?>
</div>


<div class="d-flex gap-5 align-items-center justify-content-center">

<nav  aria-label="Page navigation">
    <ul class="pagination">
        <?=$pageLinks;?>
    </ul>
</nav>


<p>showing total of <?=$totalItems?> products</p>
</div>
</div>
</div>

</main>

<?php include_once '../Footer/footer.php';?>