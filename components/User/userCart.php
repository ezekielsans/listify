<?php
require_once '../../controllers/usersController.php';
require_once '../../controllers/productController.php';
$users->startSession();

$user = $users->getUserId($_SESSION['LoginUser']['ID']);
$userId = $user['ID'];

$itemCount = $products->countCartItems($userId);
// echo "<br> Item Count";
// print_r($itemCount);
$items = $products->showCartItems($userId);
$counter = 1;

//delete user
if (isset($_POST['delete'])) {
    $productId = $_POST['delete_id'];
    if ($productId) {
        $products->removeFromCart($userId,$productId);
        echo "<div class='alert alert-success' role='alert'>Item removed!</div>";
    } else {
        echo "Error deleting";

    }
    //   echo"Error deleting ".error_reporting();
}


?>


<?php if ($user['role'] === "administrator"): ?>
        <?php include_once '../Navbar/adminNavbar.php';?>
        <?php else: ?>
        <?php include_once '../Navbar/userNavbar.php';?>
        <?php endif;?>

<main>
<div class="container">
<div class="d-flex justify-content-between mt-5 gap-5" >
<h2>My Cart</h2>
<form class="w-25" method="get">
    <div class="input-group mb-3 ">
        <input class="form-control" type="search" name="search" placeholder="Search a product..." required>
        <button type="submit" class="btn btn-primary text-white input-group-append" >Search</button>
    </div>
</form>
</div>
<table class="table table-striped">
<thead>
    <tr>

      <th scope="col">Product</th>
      <th scope="col">Unit Price</th>
      <th scope="col">Quantity</th>
      <th scope="col">Total Price</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>

    <?php foreach ($items as $item) {?>
    <tr>

    <td>
    <!-- Add the checkbox with the data attributes for price and quantity -->
    <input type="checkbox" class="item-checkbox" data-price="<?=$item['product_price'] * $item['quantity']?>" id="selectItem-<?=$item['ID']?>" class="me-2">
    <img src="/uploads/<?=$item['product_image']?>" alt="Profile Image" width="50" height="50" class="rounded">
    <?=$item['product_name']?>
  </td>

  <td><?=number_format($item['product_price'], 2)?></td>
  <td><?=$item['quantity']?></td>
  <td id="productPrice-<?=$item['ID']?>"><?=number_format($item['product_price'] * $item['quantity'], 2)?></td>

  <td>
  <form method="post" >
      <input type="hidden" name="delete_id" value="<?=$item['ID']?>"/>
      <button type="submit"  name="delete" class="btn btn-danger">Delete</button>
    </td>
  </tr>
</form>
  <?php }?>

  </tbody>
</table>




<div class="d-flex gap-5 align-items-center justify-content-center">


</div>

 

</div>
</main>

<footer>


<div class="fixed-bottom  container-fluid p-3 bg-white border w-75">
    <div class="row justify-content-between align-items-center">
        <!-- Left Section (Select All, Delete, Move to My Likes) -->
        <div class="col-md-6 d-flex align-items-center">
        <input type="checkbox" id="select-all-item-checkbox" class="me-2">
        <label for="select-all-item-checkbox" class="me-3">Select All (<?=$itemCount?>)</label>
            <button class="btn btn-link text-muted">Delete</button>
            <button class="btn btn-link text-muted">Remove inactive products</button>
            <button class="btn btn-link text-danger">Move to My Likes</button>
        </div>

        <!-- Right Section (Total, Check Out Button) -->
        <form id="checkoutForm" method="post" action="userCheckout.php">
        <div class="col  d-flex justify-content-end align-items-center">
            <div class="me-4">
                <span  id="totalItem" class="text-muted">Total (0 item):</span>
                <span id="totalPrice" class="fw-bold">₱0</span>
            </div>

  <!-- Hidden fields to store item IDs and total price for checkout -->
  <form id="checkoutForm" method="post" action="userCheckout.php">
   <input type="hidden" name="selected_items" id="selectedItems" value="">
   <input type="hidden" name="total_price" id="hiddenTotalPrice" value="">
   <button type="submit" name="checkout" class="btn btn-danger btn-lg">Check Out</button>
  </form>
    </div>
</div>



</footer>

<script>
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

</script>
  <?php include_once '../Footer/footer.php';?>