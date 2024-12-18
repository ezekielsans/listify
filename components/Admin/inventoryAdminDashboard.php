<?php

require_once '../../controllers/usersController.php';
require_once '../../controllers/productController.php';
$users->startSession();


$totalProductsCount = $products->countTotalProducts();
$totalProductsSum = $products->totalProductsSum();
$totalStocks = $products->totalStocks();



//$user =  $users->getUserId($_SESSION['LoginUser']['ID']);
$searchTerm = isset($_GET['search']) ? $_GET['search'] : "";
$currentPage = 1;
$itemsPerPage = 10;
$totalItems = $products->totalProducts($searchTerm);
$totalPages = ceil($totalItems / $itemsPerPage);

//get all products
$productsData = $products->getAllProducts($currentPage, $itemsPerPage, $searchTerm);
$pageLinks = $products->generatePageLinks($totalPages, $currentPage, $searchTerm);

$counter = 1;

//delete user
if (isset($_POST['delete'])) {
  $productId = $_POST['delete_id'];
  if ($productId) {
    $products->deleteProduct($productId);
    echo "<div class='alert alert-success' role='alert'>User deleted successfully!</div>";
  } else {
    echo "Error deleting";

  }
  //   echo"Error deleting ".error_reporting();
}

?>



<main>
  <div class="mx-5 my-5">
    <div class="d-flex justify-content-between mt-5 gap-5">
      <h2>Product Management Dashboard</h2>
      <form class="w-25" method="get">
        <div class="input-group mb-3 ">
          <input class="form-control" type="search" name="search" placeholder="Search a product..." required>
          <button type="submit" class="btn btn-primary text-white input-group-append">Search</button>
        </div>
      </form>
    </div>

    <div class="row mt-3">
      <div class="col-md-6 mb-4">
        <div class="card">
          <div class="card-body">
            <h6 class="card-title">Total Products</h6>
            <?php if ($totalProductsCount): ?>
              <h3 class="card-text"><?= $totalProductsCount ?></h3>
            <?php else: ?>
              <h3 class="card-text">0</h3>
            <?php endif ?>
            <small>Across 5 categories</small>
          </div>
        </div>
      </div>
      <div class="col-md-6 mb-4">
        <div class="card">
          <div class="card-body">
            <h6 class="card-title">Total Stock</h6>
            <?php if ($totalStocks): ?>
              <h3 class="card-text"><?= $totalStocks ?></h3>
              <small>Total number of items available</small>
            <?php else: ?>
              <h3 class="card-text">0</h3>
              <small>Total number of items available</small>
            <?php endif ?>
          </div>
        </div>
      </div>
    </div>


    <div class="row mt-3">
      <div class="col-md-6 mb-4">
        <div class="card">
          <div class="card-body">
            <h6 class="card-title">Total Value</h6>
            <?php if ($totalProductsSum): ?>
              <h3 class="card-text"><?= "₱" . number_format($totalProductsSum, 2) ?></h3>
            <?php else: ?>
              <h3 class="card-text">0</h3>
            <?php endif ?>
            <small>Inventory Worth</small>
          </div>
        </div>
      </div>
      <div class="col-md-6 mb-4">
        <div class="card">
          <div class="card-body">
            <h6 class="card-title">Average Rating</h6>
            <h3 class="card-text">$45,231.89</h3>
            <small>Out of 5 stars</small>
          </div>
        </div>
      </div>
    </div>




    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Name</th>
          <th scope="col">Description</th>
          <th scope="col">Category</th>
          <th scope="col">Price</th>
          <th scope="col">Quantity</th>
          <th scope="col">As Of</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($productsData as $product) { ?>
          <tr>
            <th scope="row"><?= $counter++ ?></th>
            <input type="hidden" name="ID" value="<?= $product['product_id'] ?>">
            <td><img src="/uploads/<?= $product['product_image'] ?>" alt="Profile Image" width="50" height="50"
                class="rounded"> <?= $product['product_name'] ?></td>
            <td><?= $product['product_description'] ?></td>
            <td><?= $product['product_category'] ?></td>
            <td><?= number_format($product['product_price'], 2) ?></td>



            <?php if (isset($product['product_stocks'])) { ?>
              <?php if ($product['product_stocks'] != 0 && $product['product_stocks'] <= 10) { ?>
                <td><?= $product['product_stocks'] ?>
                  <p class="text-muted" style="color:red">low stocks</p>
                </td>
              <?php } elseif ($product['product_stocks'] === 0) { ?>
                <td><?= $product['product_stocks'] ?>
                  <p style="color:red">out of stock</p>
                </td>

              <?php } else { ?>
                <td><?= $product['product_stocks'] ?></td>
              <?php } ?>
            <?php } ?>
            <td><?= $product['updated_at'] ?></td>
            <td>
              <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteConfirmModal"
                data-user-id="<?= $product['product_id'] ?>">Remove</button>
              <a class="btn btn-primary mx-2" href="editProduct.php?ID=<?= $product['product_id']; ?>">Edit</a>
            </td>
          </tr>
        <?php } ?>

      </tbody>
    </table>

    <div class="d-flex gap-5 align-items-center justify-content-center">
      <div class=" text-center">
        <nav aria-label="Page navigation">
          <ul class="pagination  justify-content-center">
            <?= $pageLinks; ?>
          </ul>
        </nav>
        <p>showing total of <?= $totalItems ?> products</p>
      </div>
    </div>

    <!-- Modal for delete -->
    <div class="modal fade mt-5" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel"
      aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteConfirmModalLabel">Confirm Deletion</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p> Are you sure you want to delete this product?</p>
          </div>
          <div class="modal-footer">
            <form action="" method="post">
              <input type="hidden" id="deleteId" name="delete_id">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" name="delete" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
            </form>
          </div>
        </div>
      </div>
    </div>


  </div>
</main>

<script>
  //referencing an id to a modal
  document.addEventListener("DOMContentLoaded", function () {
    var deleteModal = document.getElementById('deleteConfirmModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
      //whatever button i click
      var button = event.relatedTarget;
      //get something from this button
      var userId = button.getAttribute('data-user-id');

      var deleteInput = document.getElementById('deleteId');
      deleteInput.value = userId;
    });


  });

</script>
<?php include_once '../Footer/footer.php'; ?>