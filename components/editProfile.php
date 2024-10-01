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

<main>

<div class="container">
<h1 class="my-5">Edit Profile</h1>
<?php if ($user): ?>
<form method="POST"  enctype="multipart/form-data">
<input type="hidden" name="ID" id="product_id" class="form-control form-control-lg" value="<?=$user['user_id'];?>">
<div class="mb-3">
<label class="form-label">First Name</label>
<input type="text" name="first_name" id="first_name" class="form-control form-control-lg" value="<?=$user['first_name'];?>">
</div>
<div class="mb-3">
<label class="form-label">Last Name</label>
<input type="text" name="last_name" id="last_name" class="form-control form-control-lg" value="<?=$user['last_name'];?>">
</div>
<div class="mb-3">
<label class="form-label">Profile Picture</label>
<input type="file" name="image" id="image" class="form-control form-control-lg">
</div>
<div class="mb-3">
<label class="form-label">Email</label>
<input type="text" name="email" id="email" class="form-control form-control-lg" value="<?=$user['email'];?>">
</div>
<?php if($user['role'] === 'administrator'):?>
<div class="mb-3">
<label class="form-label">Role</label>
<input type="text" name="role" id="role" class="form-control form-control-lg" value="<?=$user['role'];?>">
</div>
<?php endif;?>

<button type="submit" name="save" class="bg-primary btn btn-lg my-4">Update</button>

</form>

<?php else: ?>
    <h1 class="my-5">User Does not exist</h1>
    <?php endif;?>
</div>
</main>

<?php include_once '../components/Footer/footer.php';?>
