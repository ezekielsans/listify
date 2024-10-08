<?php
require_once '../controllers/usersController.php';
require_once '../controllers/productController.php';
require_once '../controllers/ordersController.php';

$users->startSession();
$user = $users->getUserId($_SESSION['LoginUser']['ID']);


$userOrders = $orders->showUserOrders($user['user_id']);
echo "<br/> user orders <br/>";
print_r($userOrders);
$counter = 1;
?>
  
  <?php if ($user['role']==="administrator"):?>
        <?php include_once './Navbar/adminNavbar.php';?>
        <?php else:?>
        <?php include_once './Navbar/userNavbar.php';?>
        <?php endif; ?>

<div class="container mt-5 mb-5">
  <!-- <h1 class="mb-5">My Profile</h1> -->

  <div class="row">
    <!-- Left Side (Profile Section) -->
    <div class="col-lg-4">
      <!-- Profile Image -->
      <div class="mb-3">
        <img src="/uploads/<?=$user['user_image']?>" alt="Profile Image" height="150px" class="img-fluid rounded" style="height:230px;">
      </div>
      <!-- Edit Profile Button -->
      <div class="mb-3">
        <a href="editProfile.php?ID=<?=$user['user_id']?>" class="btn btn-primary" >Edit Profile</a>
      </div>

      <!-- Profile Info -->
      <div class="mb-1">
      
      <span class="text-muted"><?=$user['first_name']?> <?= $user['last_name']?></span>
        
      </div>
      <div class="mb-1">
      <span class="text-muted"><?=$user['email']?></span>
      </div>
      <div class="mb-3">
      <span class="text-muted"><?=$user['role']?></span>
      </div>
    </div>

    <!-- Right Side (Shopping Cart Section) -->
    <div class="col-lg-8 ">
    <!-- Navigation Tabs with Underline Style -->
    <ul class="nav nav-underline mb-3" id="pills-tab" role="tablist" style="display:flex;align-items:center; text-align:center;">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">My Orders</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">To Pay</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">To Ship</button>
  </li>  
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">To Receive</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Completed</button>
  </li> 
   <li class="nav-item" role="presentation">
    <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Cancelled</button>
  </li>
  
  
</ul>




<!-- Shopping Cart Table -->
<div class="tab-content" id="pills-tabContent">
  <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
<?php  include_once '../components/User/userOrders.php';?>
  </div>
  <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
  <?php  include_once '../components/User/userOrdersToReceive.php';?>
</div>
  <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab" tabindex="0">
  <?php  include_once '../components/User/userOrdersToShip.php';?>
</div>
  <div class="tab-pane fade" id="pills-disabled" role="tabpanel" aria-labelledby="pills-disabled-tab" tabindex="0">
  <?php  include_once '../components/User/userOrdersToShip.php';?>
</div>
</div>
 


    

  
    </div>
    
  </div>
</div>


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
      <script>
//referencing an id to a modal
document.addEventListener("DOMContentLoaded", function () {
  const deleteModal = document.getElementById('deleteConfirmModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
      //whatever button i click
      const button = event.relatedTarget;
      //get something from this button
      const userId = button.getAttribute('data-user-id');
      
      const deleteInput = document.getElementById('deleteId');
      deleteInput.value = userId;
    });
    


    const triggerTabList = document.querySelectorAll('#myTab button')
triggerTabList.forEach(triggerEl => {
  const tabTrigger = new bootstrap.Tab(triggerEl)

  triggerEl.addEventListener('click', event => {
    event.preventDefault()
    tabTrigger.show()
  })
})

    
  });
  
</script>

<?php include_once '../components/Footer/footer.php';?>