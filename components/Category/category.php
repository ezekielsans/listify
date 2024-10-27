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




if (isset($_GET['id'])) {
    
    $categoryId = $_GET['id'];

    // Perform different actions based on the ID value
    if ($categoryId == 1) {
        $pageContent = '../Products/entertainment.php';
    } elseif ($categoryId == 2) {
        $pageContent = '../Products/cameras.php';
    } elseif ($categoryId == 3) {
        $pageContent = '../Products/laptopsAndComputers.php';
    } 
    elseif ($categoryId == 4) {
        $pageContent = '../Products/homeAppliances.php';
    }
    elseif ($categoryId == 5) {
        $pageContent = '../Products/motorGears.php';
    }
    elseif ($categoryId == 6) {
        $pageContent = '../Products/hobbiesAndStationery.php';
    } elseif ($categoryId == 7) {
        $pageContent = '../Products/mensApprarel.php';
    }else {
        // If the category ID does not match any known values, set a default content
        $pageContent = '../Products/womensApprarel.php';
    }
} else {
    // If no 'id' parameter, set a default content
    $pageContent = '../Homepage/homepage.php';
}

$items = $products->getProductByCategory($categoryId,$currentPage, $itemsPerPage, $searchTerm);
print_r($items);
$pageLinks = $products->generatePageLinks($totalPages, $currentPage, $searchTerm);


?>

<?php include_once '../header.php';?>
<?php if ($user['role']==="administrator"):?>
        <?php include_once '../Navbar/adminNavbar.php';?>
        <?php else:?>
        <?php include_once '../Navbar/userNavbar.php';?>
        <?php endif; ?>

<main>

<div class="container mt-4">
    <div class="row">
           <!-- Filter Sidebar -->
           <div class="col-md-3">
            <div class="border-end pe-3">
                <h5>Filter</h5>
                <!-- Apparel Filter -->
                <div class="mb-4">
                    <h6>Apparel</h6>
                    <form>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="apparel" value="jackets" id="apparelJackets">
                            <label class="form-check-label" for="apparelJackets">Jackets</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="apparel" value="gloves" id="apparelGloves">
                            <label class="form-check-label" for="apparelGloves">Gloves</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="apparel" value="pants" id="apparelPants">
                            <label class="form-check-label" for="apparelPants">Pants</label>
                        </div>
                        <!-- Add more apparel options as needed -->
                    </form>
                </div>
                <!-- Brand Filter -->
                <div class="mb-4">
                    <h6>Shop by Brand</h6>
                    <form>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="brand" value="100%" id="brand100">
                            <label class="form-check-label" for="brand100">100%</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="brand" value="dainese" id="brandDainese">
                            <label class="form-check-label" for="brandDainese">Dainese</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="brand" value="evs" id="brandEvs">
                            <label class="form-check-label" for="brandEvs">EVS</label>
                        </div>
                        <!-- Add more brand options as needed -->
                    </form>
                </div>
            </div>
        </div>
        <!-- Product List and Sort Options -->
        <div class="col-md-9">
            
                    <label for="sort-by" class="form-label me-2">Sort by:</label>
                    <select class="form-select d-inline-block w-auto" id="sort-by">
                        <option value="featured">Featured</option>
                        <option value="price-low-high">Price: Low to High</option>
                        <option value="price-high-low">Price: High to Low</option>
                        <option value="newest">Newest</option>
                    </select>
            
      



<div class="row mt-3 mb-5">
    <?php if (isset($_SESSION['LoginUser']) && ($user['role'] === "administrator")) : ?>
        <a href="addProduct.php" class="btn btn-lg bg-primary text-white mb-5"> Add New Product</a>
        <?php endif;?>
        <div class="d-flex flex-row-reverse">



        </div>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3 mb-5 gap-5">
<?php foreach ($items as $item) { ?>
    <a href="../details.php?ID=<?=$item['product_id'];?>" class="text-decoration-none">

    <div class="card" style="width: 18rem;">
        <img class="card-img-top" src="/uploads/<?=$item['product_image']?>" height="300" alt="Card image cap">
        <div class="card-body">
            <div class="d-flex flex-column">
                <h5 class="card-title"><?=$item['product_name']?></h5>
                <p class="card-title"><?=$item['product_description']?></p>
                <h4 class="card-title"><?="₱".number_format(round($item['product_price'], 2))?></h4>

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
</div>
</div>
</div>

</main>
<?php include_once '../Footer/footer.php';?>