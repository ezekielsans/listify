<?php
require_once '../../controllers/usersController.php';
require_once '../../controllers/productController.php';
require_once '../../controllers/ordersController.php';
$users->startSession();

$user = $users->getUserId($_SESSION['LoginUser']['ID']);
print_r($user);
$userId = $user['user_id'];

$itemCount = $orders->countCartItems($userId);
// echo "<br> Item Count";
// print_r($itemCount);
$items = $orders->showCartItems($userId);
//print_r($items);
$counter = 1;

//delete user
if (isset($_POST['delete'])) {
  $productId = $_POST['delete_id'];
  $orderId = $_POST['order_id'];
  if ($productId) {
    $orders->removeFromCart($userId, $productId, $orderId);
    echo "<div class='alert alert-success' role='alert'>Item removed!</div>";
  } else {
    echo "Error deleting";

  }
  //   echo"Error deleting ".error_reporting();
}


?>


<?php if ($user['role'] === "administrator"): ?>
  <?php include_once '../Navbar/adminNavbar.php'; ?>
<?php else: ?>
  <?php include_once '../Navbar/userNavbar.php'; ?>
<?php endif; ?>

<main>
  <div class="container">
    <div class="d-flex justify-content-between mt-5 gap-5">
      <h4>Your shopping Cart</h4>

    </div>

    <div class="row mt-3">
      <?php if ($items): ?>
        <div class="col-md-8 mb-4">
          <div class="card  px-3">
            <div class=" mt-3 gap-5">

              <h4>Cart Items</h4>
              <p>You have Items</p>

            </div>
            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">Product</th>
                  <th scope="col">Unit Price</th>
                  <th scope="col">Quantity</th>
                  <th scope="col">Total Price</th>

                </tr>
              </thead>
              <tbody>

                <?php foreach ($items as $item) { ?>
                  <tr>

                    <td>
                      <!-- Add the checkbox with the data attributes for price and quantity -->
                      <input type="checkbox" class="item-checkbox"
                        data-price="<?= $item['product_price'] * $item['quantity'] ?>"
                        id="selectItem-<?= $item['product_id'] ?>" class="me-2">
                      <img src="/uploads/<?= $item['product_image'] ?>" alt="Profile Image" width="50" height="50"
                        class="rounded">
                      <?= $item['product_name'] ?>
                    </td>

                    <td><?= "₱" . number_format($item['product_price'], 2) ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td id="productPrice-<?= $item['product_id'] ?>">
                      <?= "₱" . number_format($item['product_price'] * $item['quantity'], 2) ?>
                    </td>

                    <td>
                      <form method="post">
                        <input type="hidden" name="delete_id" value="<?= $item['product_id'] ?>" />
                        <input type="hidden" name="order_id" value="<?= $item['order_id'] ?>" />
                        <button type="submit" name="delete" class="btn ">
                          <svg width="30px" height="30px" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                              <path d="M10 12V17" stroke="#000000" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"></path>
                              <path d="M14 12V17" stroke="#000000" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"></path>
                              <path d="M4 7H20" stroke="#000000" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"></path>
                              <path d="M6 10V18C6 19.6569 7.34315 21 9 21H15C16.6569 21 18 19.6569 18 18V10"
                                stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                              <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z" stroke="#000000"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </g>
                          </svg></button>
                    </td>
                  </tr>
                  </form>
                <?php } ?>


              </tbody>
            </table>
          </div>
        </div>




        <div class="col-md-4 mb-4">
          <div class=" gap-5 card px-3">

            <div class="card-body">
              <h4 class="card-title">Order Summary</h4>
              <div class="d-flex justify-content-between mt-3">
                <h6 class="card-text">Subtotal</h6>
                <small>+20.1% from last month</small>
              </div>
              <div class="d-flex justify-content-between">
                <h6 class="card-text">Shipping</h6>
                <small>+20.1% from last month</small>
              </div>
              <div class="d-flex justify-content-between">
                <h6 class="card-text">Tax</h6>
                <small>+20.1% from last month</small>
              </div>
              <div class="d-flex justify-content-between mt-3">
                <h5 class="card-text">Total</h5>
                <h5>+20.1% from last month</h5>
              </div>
              <div class="mt-2">
                <button class="btn btn-primary  w-100">
                  Proceed to checkout
                </button>
              </div>
            </div>


          </div>

        </div>
      </div>

      <div class="card mt-4">
        <div class="mt-3 px-3">
          <h5>Your Information</h5>
        </div>
        <div class="card-body">
          <div class="mb-3">
            <strong>Name:</strong>
            <?php echo htmlspecialchars($user['first_name']) . ' ' . htmlspecialchars($user['last_name']); ?>
          </div>
          <div class="mb-3">
            <strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?>
          </div>
          <div class="mb-3">
            <strong>Shipping Address:</strong> <?php echo htmlspecialchars($user['address_line2']); ?>
          </div>

        </div>
      </div>
    </div>
    </div>
  </main>





  </footer>


<?php else: ?>


  <div class="text-muted d-flex justify-content-center align-items-center vh-100 mb-5">
    <div class="text-center">
      <h3 class="text-muted mb-3">Seems so empty here...
        <svg viewBox="0 0 24 24" height="40px" width="40px" role="img" xmlns="http://www.w3.org/2000/svg"
          aria-labelledby="sadFaceIconTitle" stroke="#828282" stroke-width="2" stroke-linecap="round"
          stroke-linejoin="round" fill="none" color="#000000">
          <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
          <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
          <g id="SVGRepo_iconCarrier">
            <title id="sadFaceIconTitle">sad Face</title>
            <line stroke-linecap="round" x1="9" y1="9" x2="9" y2="9"></line>
            <line stroke-linecap="round" x1="15" y1="9" x2="15" y2="9"></line>
            <path
              d="M8,16 C9.33333333,15.3333333 10.6656028,15.0003822 11.9968085,15.0011466 C13.3322695,15.0003822 14.6666667,15.3333333 16,16">
            </path>
            <circle cx="12" cy="12" r="10"></circle>
          </g>
        </svg>
      </h3>
      <a class="btn btn-success w-50" href="../Homepage/homepage.php">Shop now</a>
    </div>
  </div>
<?php endif; ?>


<script>
  /*
//referencing an id to a modal
document.addEventListener("DOMContentLoaded", function () {


  // Select all checkboxes and total price/item elements
  const checkboxes = document.querySelectorAll('.item-checkbox'); // All product checkboxes
    const totalPriceElement = document.getElementById('totalPrice'); // The span that shows total price
    const totalItemsElement = document.getElementById('totalItem');  // The span that shows total items
    const hiddenTotalPrice = document.getElementById('hiddenTotalPrice'); 
    const selectedItemsField = document.getElementById('selectedItems'); 
    let totalPrice = 0;
    let totalItems = 0;
    let selectedItems = [];

    // Function to calculate total price and items
    function updateTotal() {
        totalPrice = 0;
        totalItems = 0;
        selectedItems = [];

        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                const itemPrice = parseFloat(checkbox.getAttribute('data-price'));
                const itemId = checkbox.id.split('-')[1];
                selectedItems.push(itemId); // Collect selected item IDs




                totalPrice += itemPrice;
                totalItems++;
            }
        });

        // Update the total price and item count in the footer
        totalPriceElement.textContent = `₱${totalPrice.toFixed(2)}`;
        totalItemsElement.textContent = `Total (${totalItems} item${totalItems > 1 ? 's' : ''}):`;

         // Update hidden fields for checkout
         hiddenTotalPrice.value = totalPrice.toFixed(2); // Pass total price to hidden field
        selectedItemsField.value = selectedItems.join(','); // Pass selected item IDs as a comma-separated string

    }

    // Add event listeners to all checkboxes
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('click', updateTotal);
    });



    // Select all functionality
    const selectAllCheckbox = document.getElementById('select-all-item-checkbox');
    selectAllCheckbox.addEventListener('click', function () {
        checkboxes.forEach(checkbox => {
            checkbox.checked = selectAllCheckbox.checked;
        });
        updateTotal();
    });

  });

   */


</script>
<?php include_once '../Footer/footer.php'; ?>