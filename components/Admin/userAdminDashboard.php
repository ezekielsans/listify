<?php
require_once '../../controllers/usersController.php';
$users->startSession();




//count users

$usersCount = $users->countAllUsers();
$activeUsersCount = $users->countActiveUsers();
$adminUsersCount = $users->countAdminUsers();
$newUsersCount = $users->countNewUsers();







//$user = $users->getUserId($_SESSION['LoginUser']['ID']);
$searchTerm = isset($_GET['search']) ? $_GET['search'] : "";
$currentPage = $_GET['page'] ?? 1;
$itemsPerPage = 10;
$totalItems = $users->totalUsers($searchTerm);
$totalPages = ceil($totalItems / $itemsPerPage);





//get all users
$usersData = $users->getAllUsers($currentPage, $itemsPerPage, $searchTerm);
$pageLinks = $users->generatePageLinks($currentPage, $itemsPerPage, $searchTerm);
$counter = 1;

//delete user
if (isset($_POST['delete'])) {
  $userId = $_POST['delete_user_id'];
  if ($userId) {
    $users->deleteUser($userId);
    echo "<div class='alert alert-success' role='alert'>User deleted successfully!</div>";
  } else {
    echo "Error deleting";

  }
  //   echo"Error deleting ".error_reporting();
}



//deactivate user
if (isset($_POST['deactivate'])) {
  $userId = $_POST['deactivate_user_id'];
  if ($userId) {
    $users->deactivateUser($userId);
    echo "<div class='alert alert-success' role='alert'>Account deactivated successfully! </div>";
  } else {
    echo "Error deactivating account";

  }
  //   echo"Error deleting ".error_reporting();
}


?>


<main>
  <div class="mx-5 my-5">
    <div class="d-flex justify-content-between mt-5 gap-5">
      <h2>User Management Dashboard</h2>

    </div>
    <div class="row mt-3">
      <div class="col-md-6 mb-4">
        <div class="card">
          <div class="card-body">
            <h6 class="card-title">Total Users</h6>
            <?php if ($usersCount): ?>
              <h3 class="card-text"><?= $usersCount ?></h3>
              <small>+20.1% from last month</small>
            <?php else: ?>
              <h3 class="card-text">0</h3>
              <small>+20.1% from last month</small>
            <?php endif ?>
          </div>
        </div>
      </div>
      <div class="col-md-6 mb-4">
        <div class="card">
          <div class="card-body">
            <h6 class="card-title">Active Users</h6>
            <?php if ($activeUsersCount): ?>
              <h3 class="card-text"><?= $activeUsersCount ?></h3>
              <small>+20.1% from last month</small>
            <?php else: ?>
              <h3 class="card-text">0</h3>
              <small>No change from last month</small>
            <?php endif ?>
          </div>
        </div>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-6 mb-4">
        <div class="card">
          <div class="card-body">
            <h6 class="card-title">Admin Users</h6>
            <?php if ($adminUsersCount): ?>
              <h3 class="card-text"><?= $adminUsersCount ?></h3>
              <small>+20.1% from last month</small>
            <?php else: ?>
              <h3 class="card-text">0</h3>
              <small>No change from last month</small>
            <?php endif ?>
          </div>
        </div>
      </div>
      <div class="col-md-6 mb-4">
        <div class="card">
          <div class="card-body">
            <h6 class="card-title">New Users(This Month)</h6>
            <?php if ($newUsersCount): ?>
              <h3 class="card-text"><?= $newUsersCount ?></h3>
              <small>+20.1% from last month</small>
            <?php else: ?>
              <h3 class="card-text">0</h3>
              <small>No change from last month</small>
            <?php endif ?>
          </div>
        </div>
      </div>
    </div>
    <div class="d-flex justify-content-between mt-5 gap-5">
      <h2>User Management</h2>
      <form class="w-25" method="get">
        <div class="input-group mb-3 ">
          <input class="form-control" type="search" name="search" placeholder="Search a user..." required>
          <button type="submit" class="btn btn-primary text-white input-group-append">Search</button>
        </div>
      </form>
    </div>
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Name</th>
          <th scope="col">Email</th>
          <th scope="col">Date Created</th>
          <th scope="col">Role</th>
          <th scope="col">Status</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($usersData as $user) { ?>
          <tr>
            <th scope="row"><?= $counter++ ?></th>
            <input type="hidden" name="ID" value="<?= $user['user_id'] ?>">
            <td><img src="/uploads/<?= $user['user_image'] ?>" alt="Profile Image" width="32" height="32"
                class="rounded-circle"> <?= $user['first_name'] ?>   <?= $user['last_name'] ?></td>
            <td><?= $user['email'] ?></td>
            <td><?= $user['created_at'] ?></td>
            <td><?= $user['role'] ?></td>
            <?php if (isset($user['status'])) { ?>
              <?php if ($user['status'] === "active") { ?>
                <td><svg style="fill:green;" width="15px" height="15px" viewBox="-1.6 -1.6 19.20 19.20"
                    xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                      <circle cx="8" cy="8" r="8"></circle>
                    </g>
                  </svg>
                  <?= $user['status'] ?></td>
              <?php } elseif ($user['status'] === "inactive") { ?>
                <td><svg style="fill:red;" width="15px" height="15px" viewBox="-1.6 -1.6 19.20 19.20"
                    xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                      <circle cx="8" cy="8" r="8"></circle>
                    </g>
                  </svg>
                  <?= $user['status'] ?></td>
              <?php } else { ?>
                <td><svg style="fill:orangered;" width="15px" height="15px" viewBox="-1.6 -1.6 19.20 19.20"
                    xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                      <circle cx="8" cy="8" r="8"></circle>
                    </g>
                  </svg>
                  <?= $user['status'] ?></td>
              <?php } ?>
            <?php } ?>
            <td><button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteConfirmModal"
                data-user-id="<?= $user['user_id'] ?>">Delete</button>
              <?php if (isset($user['status'])) { ?>
                <?php if ($user['status'] === "inactive" || $user['status'] === "suspended") { ?>
                  <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#deactConfirmModal"
                    data-user-id="<?= $user['user_id'] ?>">Activate</button>
                </td>
              <?php } else { ?>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#deactConfirmModal"
                  data-user-id="<?= $user['user_id'] ?>">Deactivate</button></td>
              <?php } ?>
            <?php } ?>
          </tr>
        <?php } ?>
      </tbody>
    </table>
    <div class="d-flex gap-5 align-items-center justify-content-center">

      <nav aria-label="Page navigation">
        <ul class="pagination">
          <?= $pageLinks; ?>
        </ul>
      </nav>


      <p>showing total of <?= $totalItems ?> products</p>
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
            <p> Are you sure you want to delete this user?</p>
          </div>
          <div class="modal-footer">
            <form action="" method="post">
              <input type="hidden" id="deleteId" name="delete_user_id">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" name="delete" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal for deactivating account -->
    <div class="modal fade mt-5" id="deactConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel"
      aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteConfirmModalLabel">Confirm Deletion</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <?php if ($user['status'] === "active"): ?>
              <p> Are you sure you want to deactivate this account?</p>
            <?php else: ?>
              <p> Activate this account?</p>
            <?php endif; ?>

          </div>
          <div class="modal-footer">
            <form action="" method="post">
              <input type="hidden" id="deactId" name="deactivate_user_id">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" name="deactivate" class="btn btn-danger" id="confirmDeleteBtn">Deactivate</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<script src="modal.js"></script>