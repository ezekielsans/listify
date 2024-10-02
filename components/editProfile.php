<?php
include_once '../controllers/productController.php';
include_once '../controllers/usersController.php';

$users->startSession();

$userId = $_GET['ID'];
print_r($_SESSION['LoginUser']['ID']);
if (isset($userId)) {
    $user = $users->getUserId(userId: $_SESSION['LoginUser']['ID']);

    print_r($user);
}

if (isset($_POST['save'])) {
    //print_r($_POST);
    $users->editUserProfile($_POST['first_name'],
                                $_POST['last_name'],
                                   $_POST['email'],
                                     $_POST['role'],
                                     $_POST['ID']);
    if ($_FILES['image']['name']) {

        $milliseconds = intval(microtime(true) * 1000);
        $imageName = $users->uploadImage('image', 'uploads', $milliseconds . "_" . $_POST['ID']);
        if ($imageName != "Failed") {
            $users->updateUserImage($_POST['ID'], $imageName);
        }

    }
    // header('Location: details.php?ID=' . $_POST['ID']);

}
?>

<?php if ($user['role'] === "administrator"): ?>
        <?php include_once '../components/Navbar/adminNavbar.php';?>
        <?php else: ?>
        <?php include_once '../components/Navbar/userNavbar.php';?>
        <?php endif;?>
        <link rel="stylesheet" href="../editProfile.css">
        <main>
    <div class="container py-5 px-5">
        <h1 class="my-5 text-center">Edit Profile</h1>
        <?php if ($user): ?>
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="ID" id="user_id" class="form-control form-control-lg" value="<?=$user['user_id'];?>">

                <!-- Profile Picture -->
                <div class="row mb-4 justify-content-center">
                    <div class="col-md-3 text-center">
                        <img src="../uploads/<?=$user['user_image'];?>" alt="Profile Picture" class="img-fluid" width="150px" height="150px">
                        <input type="file" name="image" id="image" class="form-control mt-2">
                    </div>
                </div>

                <!-- Form Inputs -->
                <div class="row">
                    <!-- Full Name -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="first_name" id="first_name" class="form-control form-control-lg" value="<?=$user['first_name'];?> <?=$user['last_name'];?>">
                    </div>
                    
                    <!-- Email -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control form-control-lg" value="<?=$user['email'];?>">
                    </div>
                </div>

                <div class="row">
                    <!-- Present Address -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Present Address</label>
                        <input  type="text" name="present_address" id="present_address" class="form-control form-control-lg text-muted" value="<?=$user['address_line1'];?>">
                    </div>

                    <!-- Permanent Address -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Permanent Address</label>
                        <input type="text" name="address" id="address" class="form-control form-control-lg text-muted" value="<?=$user['address_line2'];?>">
                    </div>
                </div>

                <div class="row">
                    <!-- City -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">City</label>
                        <input type="text" name="city" id="city" class="form-control form-control-lg text-muted" value="<?=$user['city'];?>">
                    </div>

                    <!-- Country -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Country</label>
                        <input type="text" name="country" id="country" class="form-control form-control-lg text-muted" value="<?=$user['country'];?>">
                    </div>

                    <!-- Postal Code -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Postal Code</label>
                        <input type="text" name="postal_code" id="postal_code" class="form-control form-control-lg text-muted" value="<?=$user['postal_code'];?>">
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="row">
                <div class="col-md-12 text-end">
                    <button type="submit" name="save" class="btn btn-primary btn-lg " style="width: fit-content;">Save</button>
                </div>
                </div>
            </form>
        <?php else: ?>
            <h1 class="my-5">User Does not exist</h1>
        <?php endif; ?>
    </div>
</main>


<?php include_once '../components/Footer/footer.php';?>
