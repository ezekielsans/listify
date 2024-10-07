<?php
include_once '../controllers/productController.php';
include_once '../controllers/usersController.php';
include_once '../controllers/ordersController.php';

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
        $_POST['ID'],
        $_POST['present_address'],
        $_POST['permanent_address'],
        $_POST['city'],
        $_POST['postal_code'],
        $_POST['country']);

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
        <?php include_once './Navbar/adminNavbar.php';?>
        <?php else:?>
        <?php include_once './Navbar/userNavbar.php';?>
        <?php endif; ?>


        <link rel="stylesheet" href="../editProfile.css">
        <main>
    <div class="container py-5 px-5">
        <h1 class=" text-center">Edit Profile</h1>
        <?php if ($user): ?>
            <form method="POST" class="py-5 px-5" enctype="multipart/form-data">
                <input type="hidden" name="ID" id="user_id" class="form-control form-control-lg" value="<?=$user['user_id'];?>">

                <!-- <div class="row mb-4 justify-content-center"> -->

                    <!-- </div> -->

                <!-- Form Inputs -->
                <div class="row">
                
                    <!-- Profile Picture -->
                <div class="col-md-4  text-center mt-3">
                        <img src="../uploads/<?=$user['user_image'];?>" alt="Profile Picture" class="img-fluid " width="150px" height="150px">
                        <input type="file" name="image" id="image" class="form-control mt-2">

               
                </div>
             

                <div class="col-md-8 py-5 px-5">
                    <!-- Full Name -->
                    <div class="col-md-12 mb-3">
                        <label class="form-label">First Name</label>
                        <input type="text" name="first_name" id="first_name" class="form-control form-control-lg" value="<?=$user['first_name'];?>">
                    </div>
                     <div class="col-md-12 mb-3">
                        <label class="form-label">Last Name</label>
                        <input type="text" name="last_name" id="last_name" class="form-control form-control-lg" value="<?=$user['last_name'];?>">
                     </div>

                     <!-- Email -->
                     <div class="col-md-12 mb-3">
                         <label class="form-label">Email</label>
                         <input type="email" name="email" id="email" class="form-control form-control-lg" value="<?=$user['email'];?>">
                     </div>
                <div class="row">
                    <!-- Present Address -->
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Present Address</label>
                        <input  type="text" name="present_address" id="present_address" class="form-control form-control-lg text-muted" value="<?=$user['address_line1'];?>">
                    </div>
                    </div>



                   
                    <!-- Permanent Address -->
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Permanent Address</label>
                        <input type="text" name="permanent_address" id="address" class="form-control form-control-lg text-muted" value="<?=$user['address_line2'];?>">
                    </div>  
                    
                <?php if($user['role'] === "administrator"):?>
                    <!-- Role -->
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Role</label>
                        <input type="text" name="role" id="role" class="form-control form-control-lg text-muted" value="<?=$user['role'];?>">
                    </div>
                    <?php else: ?>
                        <input type="hidden" name="role" id="role" class="form-control form-control-lg text-muted" value="<?=$user['role'];?>">

                <?php endif;?>
               
                    <div class="row">
                    <!-- City -->
                    <div class="col-md-5 mb-3">
                        <label class="form-label">City</label>
                        <input type="text" name="city" id="city" class="form-control form-control-lg text-muted" value="<?=$user['city'];?>">
                    </div>
                  
                    <!-- Country -->
                    <div class="col-md-5 mb-3">
                        <label class="form-label">Country</label>
                        <input type="text" name="country" id="country" class="form-control form-control-lg text-muted" value="<?=$user['country'];?>">
                    </div>
                  
                    <!-- Postal Code -->
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Postal Code</label>
                        <input type="text" name="postal_code" id="postal_code" class="form-control form-control-lg text-muted" value="<?=$user['postal_code'];?>">
                    </div>
                </div>
               

                <!-- Submit Button -->
                <div class="row">
                <div class="col-md-12 text-end mt-5">
                    <button type="submit" name="save" class="btn btn-primary btn-lg " style="width: fit-content;">Save</button>
                </div>
                </div>
            </form>
        <?php else: ?>
            <h1 class="my-5">User Does not exist</h1>
        <?php endif;?>
    </div>
</main>


<?php include_once '../components/Footer/footer.php';?>
