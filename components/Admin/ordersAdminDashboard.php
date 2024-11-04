<?php

require_once '../../controllers/usersController.php';
require_once '../../controllers/productController.php';
require_once '../../controllers/ordersController.php';

$users->startSession();
$user = $users->getUserId($_SESSION['LoginUser']['ID']);
$searchTerm = isset($_GET['search']) ? $_GET['search'] : "";
$currentPage = $_GET['page'] ?? 1;
$itemsPerPage = 10;
$totalItems = $products->totalProducts($searchTerm);
$totalPages = ceil($totalItems / $itemsPerPage);


$ordersCount = $orders->countOrders();
$pendingOrdersCount = $orders->countPendingOrders();


$orders = $orders->showOrders();



print_r($orders);
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
      <h2>Order Management Dashboard</h2>
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
            <h6 class="card-title">Total Orders</h6>
            <?php if ($ordersCount): ?>
              <h3 class="card-text"><?= $ordersCount ?></h3>
            <?php else: ?>
              <h3 class="card-text">0</h3>
            <?php endif ?>
            <small>+20.1% from last month</small>
          </div>
        </div>
      </div>
      <div class="col-md-6 mb-4">
        <div class="card">
          <div class="card-body">
            <h6 class="card-title">Total Revenue</h6>
            <h3 class="card-text">$45,231.89</h3>
            <small>+20.1% from last month</small>
          </div>
        </div>
      </div>
    </div>

    <div class="row mt-3">
      <div class="col-md-6 mb-4">
        <div class="card">
          <div class="card-body">
            <h6 class="card-title">Average Order Value</h6>
            <h3 class="card-text">$45,231.89</h3>
            <small>+20.1% from last month</small>
          </div>
        </div>
      </div>
      <div class="col-md-6 mb-4">
        <div class="card">
          <div class="card-body">
            <h6 class="card-title">Pending Orders</h6>
            <?php if ($pendingOrdersCount): ?>
              <h3 class="card-text"><?= $pendingOrdersCount ?></h3>
            <?php else: ?>
              <h3 class="card-text">0</h3>
            <?php endif ?>
            <small>+20.1% from last month</small>
          </div>
        </div>
      </div>
    </div>



    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Customer Name</th>
          <th scope="col">Customer Order</th>
          <th scope="col">Quantity</th>
          <th scope="col">Total Price</th>
          <th scope="col">Order Status</th>
          <th scope="col">As Of</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($orders as $order) { ?>
          <tr>
            <th scope="row"><?= $counter++ ?></th>
            <input type="hidden" name="ID" value="<?= $order['order_id'] ?>">
            <td><?= $order['first_name'] ?>   <?= $order['last_name'] ?></td>
            <td><?= $order['product_name'] ?></td>
            <td><?= $order['quantity'] ?></td>
            <td><?= number_format($order['total_price'], 2) ?></td>
            <td>
              <?php if ($order['order_status'] == 'pending'): ?>
              <?php endif ?>


            </td>


            <td><?= $order['created_at'] ?></td>
            <td>
              <a class="btn btn-primary mx-2" href="editProduct.php?ID=<?= $product['product_id']; ?>">Update</a>
              <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteConfirmModal"
                data-user-id="<?= $product['product_id'] ?>">Remove</button>
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