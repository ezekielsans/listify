<?php
require_once '../../controllers/productController.php';
require_once '../../controllers/usersController.php';
require_once '../../controllers/ordersController.php';


$users->startSession();

$user = $users->getUserId($_SESSION['LoginUser']['ID']);
// Redirect if user is an administrator
if (isset($user['role']) && $user['role'] === "administrator") {
    header('Location: ../Admin/adminHome.php');
    exit();
}



$searchTerm = isset($_GET['search']) ? $_GET['search'] : "";

$currentPage = $_GET['page'] ?? 1;
$itemsPerPage = 8;
$totalItems = $products->totalProducts($searchTerm);
$totalPages = ceil($totalItems / $itemsPerPage);

$reviews = 0;
$items = $products->getAllPromotionProducts($currentPage, $itemsPerPage, $searchTerm);
$pageLinks = $products->generatePageLinks($totalPages, $currentPage, $searchTerm);


?>

<?php include_once '../header.php'; ?>
<?php include_once '../Navbar/userNavbar.php'; ?>


<main>

    <div class="container">


        <!-- Banner -->
        <section class="banner my-4">
            <div class="container position-relative d-flex align-items-center justify-content-center"
                style="background-image: url('../../assets/banner_1.png'); background-position: center; height: 300px;">

                <a href="#" class="btn btn-dark position-absolute"
                    style="top: 75%; left: 50%; transform: translate(-50%, -50%); z-index: 1;">
                    Buy Now
                </a>
            </div>
        </section>




        <!-- Filters -->
        <div class="d-flex justify-content-between mt-5 mb-5 gap-5">
            <h4>Categories</h4>


        </div>
        <nav class="navbar navbar-expand-sm">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapsibleNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-center" id="collapsibleNavbar">
                    <div id="loadingMessage" style="font-size:1rem; color:white;">Loading categories...</div>
                    <ul id="categoryList" class="navbar-nav flex-row" style="display:flex; gap: 10px;"></ul>
                </div>
            </div>
        </nav>



        <div class="d-flex justify-content-between mt-5 gap-5">
            <h4>Hot Deals</h4>

        </div>

        <div class="mt-3 mb-5">
            <?php if (isset($_SESSION['LoginUser']) && ($user['role'] === "administrator")): ?>
                <a href="addProduct.php" class="btn btn-lg bg-primary text-white mb-5"> Add New Product</a>
            <?php endif; ?>
            <div class="d-flex flex-row-reverse">



            </div>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3 mb-5">
                <?php foreach ($items as $item) { ?>
                    <a href="../details.php?ID=<?= $item['product_id']; ?>" class="text-decoration-none">

                        <div class="card  h-100" style="width: 18rem;">
                            <img class="card-img-top" src="../../uploads/<?= $item['product_image'] ?>" height="300"
                                alt="Card image cap">
                            <div class="card-body">
                                <div class="d-flex flex-column">
                                    <h5 class="card-title"><?= $item['product_name'] ?></h5>
                                    <p class="card-text"><?= $item['product_description'] ?></p>

                                    <!-- Price display -->
                                    <div class="d-flex align-items-baseline">
                                        <?php if (!empty($item['discounted_price'])): ?>
                                            <!-- Show original price as strikethrough when on sale -->
                                            <h4 class="text-muted text-decoration-line-through me-2">
                                                <?= "₱" . number_format(round($item['product_price'], 2)) ?>
                                            </h4>
                                            <!-- Show sale price -->
                                            <h4 class="text-danger">
                                                <?= "₱" . number_format(round($item['discounted_price'], 2)) ?>
                                            </h4>
                                        <?php else: ?>
                                            <!-- Show only original price if not on sale -->
                                            <h5><?= "₱" . number_format(round($item['product_price'], 2)) ?></h5>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Display stars -->
                                    <div class="d-flex align-items-center mb-2">
                                        <?php
                                        $rating = 3.75; // Assuming you have this field
                                        $maxStars = 5;

                                        // Loop through 5 stars
                                        for ($i = 1; $i <= $maxStars; $i++) {
                                            if ($i <= floor($rating)) {
                                                // Full Star
                                                echo '<svg fill="#FFD700" height="20px" 
                                            viewBox="-1 0 19 19" xmlns="http://www.w3.org/2000/svg" class="cf-icon-svg"><path d="m12.673 10.779.798 4.02c.221 1.11-.407 1.566-1.395 1.013L8.5 13.81l-3.576 2.002c-.988.553-1.616.097-1.395-1.013l.397-2.001.401-2.02-1.51-1.397-1.498-1.385c-.832-.769-.592-1.507.532-1.64l2.026-.24 2.044-.242 1.717-3.722c.474-1.028 1.25-1.028 1.724 0l1.717 3.722 2.044.242 2.026.24c1.124.133 1.364.871.533 1.64L14.184 9.38z"></path></svg>';
                                            } elseif ($i - $rating <= 0.5) {
                                                // Half Star
                                                echo '<svg fill="url(#half)" height="20px" viewBox="-1 0 19 19" xmlns="http://www.w3.org/2000/svg" class="cf-icon-svg"><defs><linearGradient id="half"><stop offset="50%" stop-color="#FFD700"/><stop offset="50%" stop-color="#DEDEDE"/></linearGradient></defs><path d="m12.673 10.779.798 4.02c.221 1.11-.407 1.566-1.395 1.013L8.5 13.81l-3.576 2.002c-.988.553-1.616.097-1.395-1.013l.397-2.001.401-2.02-1.51-1.397-1.498-1.385c-.832-.769-.592-1.507.532-1.64l2.026-.24 2.044-.242 1.717-3.722c.474-1.028 1.25-1.028 1.724 0l1.717 3.722 2.044.242 2.026.24c1.124.133 1.364.871.533 1.64L14.184 9.38z"></path></svg>';
                                            } else {
                                                // Empty Star
                                                echo '<svg fill="#DEDEDE" height="20px" viewBox="-1 0 19 19" xmlns="http://www.w3.org/2000/svg" class="cf-icon-svg"><path d="m12.673 10.779.798 4.02c.221 1.11-.407 1.566-1.395 1.013L8.5 13.81l-3.576 2.002c-.988.553-1.616.097-1.395-1.013l.397-2.001.401-2.02-1.51-1.397-1.498-1.385c-.832-.769-.592-1.507.532-1.64l2.026-.24 2.044-.242 1.717-3.722c.474-1.028 1.25-1.028 1.724 0l1.717 3.722 2.044.242 2.026.24c1.124.133 1.364.871.533 1.64L14.184 9.38z"></path></svg>';
                                            }
                                        }
                                        ?>
                                        <span>(121)</span> <!-- Replace this with actual number of reviews -->
                                    </div>

                                    <button class="btn btn-outline-dark">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php } ?>
            </div>



            <div class="d-flex gap-5 align-items-center justify-content-center">

                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <?= $pageLinks; ?>
                    </ul>
                </nav>


                <p>showing total of <?= $totalItems ?> products</p>
            </div>
        </div>
    </div>

</main>
<script>document.addEventListener('DOMContentLoaded', requestCategories);

    function requestCategories() {
        const loadingMessage = document.getElementById('loadingMessage');
        if (!loadingMessage) {
            console.error('Loading Message element not found');
            return;
        }

        const categoryList = document.getElementById('categoryList');

        if (!categoryList) {
            console.error('Category list element not found');
            return;
        }

        fetch("http://localhost/api/loadCategories.php", { method: "GET" })
            .then((res) => res.json())
            .then((data) => {
                loadingMessage.style.display = 'none';
                categoryList.style.display = 'flex';

                if (data.error) {
                    console.error(data.error);
                    return;
                }

                data.forEach((category) => {
                    const listItem = document.createElement('li');
                    listItem.classList.add('nav-item');

                    const button = document.createElement('button');
                    button.classList.add('btn', 'category-btn');
                    button.style.borderRadius = '20px';
                    button.style.color = 'white';
                    button.style.backgroundColor = '#2E7D32';

                    // const link = document.createElement('a');
                    // link.classList.add('nav-link');
                    // link.textContent = category.product_category;
                    button.textContent = category.product_category;
                    button.onclick = () => {
                        window.location.href = `../Category/category.php?id=${encodeURIComponent(category.product_category_id)}`;
                    }

                    listItem.appendChild(button);
                    categoryList.appendChild(listItem);
                });
            })
            .catch((err) => console.error('Failed to fetch categories:', err));
    }


</script>

<?php include_once '../Footer/footer.php'; ?>