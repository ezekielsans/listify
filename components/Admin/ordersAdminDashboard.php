<?php

require_once '../../controllers/usersController.php';
require_once '../../controllers/productController.php';
require_once '../../controllers/ordersController.php';

$users->startSession();
//$user = $users->getUserId($_SESSION['LoginUser']['ID']);
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
}
//   echo"Error deleting ".error_reporting();

//update order status
//   if (isset($_POST['save'])) {
//     $orderId = $_POST['order_id'];
//     $orderStatus = $_POST['order_status'];
//     $notes = $_POST['notes'];
// }

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
          <th scope="col">Shipping Status</th>
          <th scope="col">Order Date</th>
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
            <td><?= "₱" . number_format($order['total_price'], 2) ?></td>
            <td>
              <?php if ($order['order_status'] == 'pending'): ?>
                <span class=" badge-warning p-2 px-3 rounded-pill" style=" background-color: #ffcc80; color: #9c5600;">
                  <?= $order['order_status'] ?> </span>
              <?php elseif ($order['order_status'] == 'placed'): ?>
                <span class="badge badge-warning p-2 px-3 rounded-pill" style="background-color: #80c8ff; color: #004b99;">
                  <?= $order['order_status'] ?> </span>
              <?php elseif ($order['order_status'] == 'shipped'): ?>
                <span class="badge badge-warning p-2 px-3 rounded-pill"
                  style=" background-color: #ffcc80; color: #9c5600; "> <?= $order['order_status'] ?> </span>
              <?php elseif ($order['order_status'] == 'paid'): ?>
                <span class="badge badge-warning p-2 px-3 rounded-pill" style="background-color: #b3e5fc; color: #007bb5;">
                  <?= $order['order_status'] ?> </span>
              <?php elseif ($order['order_status'] == 'completed'): ?>
                <span class="badge badge-warning p-2 px-3 rounded-pill" style="background-color: #b2dfdb; color: #004d40;">
                  <?= $order['order_status'] ?> </span>
              <?php elseif ($order['order_status'] == 'canceled'): ?>
                <span class="badge badge-secondary p-2 px-3 rounded-pill"
                  style="background-color: #ffcdd2; color: #b71c1c;"> <?= $order['order_status'] ?> </span>
              <?php endif ?>
            </td>
            <td>
              <?= $order['delivery_status'] ?>
            </td>
            <td><?= $order['created_at'] ?></td>
            <td>
              <!-- <a class="btn btn-primary mx-2" href="editProduct.php?ID=">Update</a>
              <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteConfirmModal"
                data-user-id="">Remove</button> -->


              <!-- Dropdown for Actions -->
              <div class="dropdown">
                <button class="btn   btn-sm" type="button" id="dropdownMenuButton<?= $order['order_id'] ?>"
                  data-bs-toggle="dropdown" aria-expanded="false">
                  &#8230;
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton<?= $order['order_id'] ?>">
                  <li><a class="dropdown-item" href="view_order.php?order_id=<?= $order['order_id'] ?>">View details</a>
                  </li>
                  <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#updateStatusModal"
                    data-order-id="<?= $order['order_id'] ?>" data-order-status="<?= $order['order_status'] ?>">
                    Update status
                  </button>
                </ul>
              </div>
            </td>
          </tr>
        <?php } ?>

      </tbody>
    </table>



    <!-- view order Status Modal -->
    <div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-labelledby="orderDetailsModalLabel"
      aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="orderDetailsModalLabel">Order Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>



          <div class="modal-body">
            <h6><strong>Customer:</strong> <span id="customerName"></span></h6>
            <p><strong>Total Price:</strong> $<span id="totalPrice"></span></p>
            <p><strong>Order Status:</strong> <span id="orderStatus"></span></p>
            <p><strong>Shipping Status:</strong> <span id="shippingStatus"></span></p>
            <p><strong>Order Date:</strong> <span id="orderDate"></span></p>
            <p><strong>Last Updated:</strong> <span id="updatedDate"></span></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>

        </div>
      </div>
    </div>


    <form id="updateStatusForm" method="post" action="update_status.php">

      <!-- Update Status Modal -->
      <div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="updateStatusModalLabel">Update Order Status</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateStatusForm" method="post" action="update_status.php">
              <div class="modal-body">
                <input type="hidden" id="orderId" name="order_id">

                <div class="mb-3">
                  <label for="orderStatus" class="form-label">Status</label>
                  <select class="form-select" id="orderStatus" name="order_status">
                    <option value="Processing">Processing</option>
                    <option value="Shipped">Shipped</option>
                    <option value="Delivered">Delivered</option>
                    <option value="Cancelled">Cancelled</option>
                  </select>
                </div>

                <div class="mb-3">
                  <label for="orderNotes" class="form-label">Notes</label>
                  <textarea class="form-control" id="orderNotes" name="notes"
                    placeholder="Add any notes about this status change"></textarea>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button name="save" type="submit" class="btn btn-primary">Save changes</button>
              </div>
            </form>
          </div>
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
      var button = event.relatedTarget;
      var orderId = button.getAttribute('data-order-id'); // Corrected from 'data-user-id'
      var deleteInput = document.getElementById('deleteId');
      deleteInput.value = orderId;
    });

    const updateStatusModal = document.getElementById('updateStatusModal');
    updateStatusModal.addEventListener('show.bs.modal', (event) => {
      const button = event.relatedTarget;
      const orderId = button.getAttribute('data-order-id');
      const orderStatus = button.getAttribute('data-order-status');

      console.log("Order ID:", orderId);
      console.log("Order Status:", orderStatus);

      const modalOrderId = updateStatusModal.querySelector('#orderId');
      const modalOrderStatus = updateStatusModal.querySelector('#orderStatus');

      modalOrderId.value = orderId;
      modalOrderStatus.value = orderStatus;
    });



    const orderDetailsModal = document.getElementById('orderDetailsModal');

    orderDetailsModal.addEventListener('show.bs.modal', (event) => {
      const button = event.relatedTarget;

      // Extract data attributes
      const orderId = button.getAttribute('data-order-id');
      const customerName = button.getAttribute('data-customer');
      const totalPrice = button.getAttribute('data-total-price');
      const orderStatus = button.getAttribute('data-order-status');
      const shippingStatus = button.getAttribute('data-shipping-status');
      const orderDate = button.getAttribute('data-order-date');
      const updatedDate = button.getAttribute('data-updated-date');

      // Populate modal fields
      orderDetailsModal.querySelector('#customerName').textContent = customerName;
      orderDetailsModal.querySelector('#totalPrice').textContent = totalPrice;
      orderDetailsModal.querySelector('#orderStatus').textContent = orderStatus;
      orderDetailsModal.querySelector('#shippingStatus').textContent = shippingStatus;
      orderDetailsModal.querySelector('#orderDate').textContent = orderDate;
      orderDetailsModal.querySelector('#updatedDate').textContent = updatedDate;
    });


  });








</script>