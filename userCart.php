<?php
require_once 'usersController.php';
require_once 'productController.php';
$users->startSession();

$user = $users->getUserId($_SESSION['LoginUser']['ID']);
$userId = $user['ID'];

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

<?php include_once 'components/header.php';?>

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
      <td><img src="/uploads/<?=$item['product_image']?>" alt="Profile Image" width="50" height="50" class="rounded">  <?=$item['product_name']?></td>
      <td><?=number_format($item['product_price'], 2)?></td>
      <td><?=number_format($item['quantity'], 2)?></td>
      <td><?= number_format($item['product_price']  *  $item['quantity'],2)?></td>




      <td>
        <form  method="post">
            <input type="hidden" value="<?=$product['ID']?>"/>
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
  <?php include_once 'components/footer.php';?>