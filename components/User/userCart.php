<?php
require_once '../../controllers/usersController.php';
require_once '../../controllers/productController.php';
$users->startSession();

$user = $users->getUserId($_SESSION['LoginUser']['ID']);
$userId = $user['ID'];



$itemCount = $products->countCartItems($userId);
 echo "<br> Item Count";
print_r($itemCount);
$items =  $products->showCartItems($userId);
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

<?php include_once '../header.php';?>

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
     
      <input type="hidden" name="ID" value="<?=$item['ID']?>">
      
      <td> 
        <input type="checkbox" id="selectAll" class="me-2"> 
        <img src="/uploads/<?=$item['product_image']?>" alt="Profile Image" width="50" height="50" class="rounded">  
        <?=$item['product_name']?>
      </td>
      <td><?=number_format($item['product_price'], 2)?></td>
      <td><?=$item['quantity'] ?></td>
      <td><?= number_format($item['product_price']  *  $item['quantity'],2)?></td>

      <td>
        <form  method="post">
            <input type="hidden" name="delete_id" value="<?=$product['ID']?>"/>
        <button type="submit" class="btn btn-danger">Delete</button>
        </form>
      </td>
    </tr>
    <?php }?>
       
  </tbody>
</table>




<div class="d-flex gap-5 align-items-center justify-content-center">

<!-- <nav  aria-label="Page navigation">
    <ul class="pagination">
        <?=$pageLinks;?>
    </ul>
</nav> -->

<!-- 
<p>showing total of <?=$totalItems?> products</p> -->
</div>

   <!-- Modal for delete -->
   <div class="modal fade mt-5" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
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

<footer>
<div class="fixed-bottom  container-fluid p-3 bg-white border w-75">
    <div class="row justify-content-between align-items-center">
        <!-- Left Section (Select All, Delete, Move to My Likes) -->
        <div class="col-md-6 d-flex align-items-center">
        <input type="checkbox" class="item-checkbox" data-price="<?= $item['product_price'] * $item['quantity'] ?>" id="selectItem-<?= $item['ID'] ?>" class="me-2">
            <label for="selectAll" class="me-3">Select All (<?=$itemCount?>)</label>
            <button class="btn btn-link text-muted">Delete</button>
            <button class="btn btn-link text-muted">Remove inactive products</button>
            <button class="btn btn-link text-danger">Move to My Likes</button>
        </div>

        <!-- Right Section (Total, Check Out Button) -->
        <div class=" col-md-6 d-flex justify-content-end align-items-center">
            <div class="me-4">
                <span class="text-muted">Total (0 item):</span>
                <span class="fw-bold">₱0</span>
            </div>
            <button class=" btn btn-danger btn-lg">Check Out</button>
        </div>
    </div>
</div>



</footer>

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



    //handle checkbox
const checkboxes = document.querySelectorAll('.item-checkbox');
    const totalPriceElement = document.querySelector('.fw-bold'); // The span that shows total price
    const totalItemsElement = document.querySelector('.text-muted'); // The span that shows total items
    let totalPrice = 0;
    let totalItems = 0;

    // Function to calculate total price and items
    function updateTotal() {
        totalPrice = 0;
        totalItems = 0;
        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                const itemPrice = parseFloat(checkbox.getAttribute('data-price'));
                totalPrice += itemPrice;
                totalItems++;
            }
        });

        // Update the total price and item count in the footer
        totalPriceElement.textContent = `₱${totalPrice.toFixed(2)}`;
        totalItemsElement.textContent = `Total (${totalItems} item):`;
    }

    // Add event listeners to all checkboxes
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateTotal);
    });

    // Select all functionality
    const selectAllCheckbox = document.getElementById('selectAll');
    selectAllCheckbox.addEventListener('change', function () {
        checkboxes.forEach(checkbox => {
            checkbox.checked = selectAllCheckbox.checked;
        });
        updateTotal();
    });
    
    
  });
  
</script>
  <?php include_once '../Footer/footer.php';?>