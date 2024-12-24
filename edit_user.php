<?php
session_start();
$page_title = "Edit User Information";
include('./dbcon.php');

include('./includes/header.php');
include('./includes/navbar.php');

?>

<div class="content py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="contents shadow col-md-6">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="alert">
                            <?php
                            if (isset($_SESSION['status'])) {
                            ?>
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <strong><?= $_SESSION['status']; ?></strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"> </button>
                                </div>
                            <?php
                                unset($_SESSION['status']);
                            }
                            ?>
                        </div>
                        <div class="mb-4">
                            <h3>Edit User Information</h3>

                            <?php

                            if (isset($_GET['uid'])) 
                            {

                                $uid = $_GET['uid'];
                                $query = "SELECT * FROM users WHERE uid='$uid'";
                                $query_run = mysqli_query($con, $query);

                                if (mysqli_num_rows($query_run) > 0) {
                                    foreach ($query_run as $user) {
                            ?>
                                    <form action="edit_user_code.php" method="POST">
                                        <input type="hidden" name="uid" value="<?=$uid; ?>">
                                        <div class="form-group mb-2">
                                            <label for="username">Name</label>
                                            <input type="text" name="name" class="form-control fname" value="<?=$user['name']; ?>" id="name">
                                            <small class="text-danger" id="error_fname"></small>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="phone">Phone Number</label>
                                            <input type="text" name="phone" class="form-control pnumber" value="<?=$user['phone']; ?>"     id="phone">
                                            <small class="text-danger" id="error_pnumber"></small>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="email">Email</label>
                                            <input type="text" name="email" class="form-control email_id" value="<?=$user['email']; ?>" id="email">
                                            <small class="text-danger" id="error_email"></small>
                                        </div>
                                        <div class="form-group d-flex">
                                            <a href='dashboard.php' class='back_btn btn btn-danger ' style="height: 42px; padding-left: 20px; padding-right: 20px; color: white; text-decoration: none">Back</a></td>

                                            <input type="submit" value="Update" name="update_user" id="update_btn" class="btn btn-primary bg-primary ml-2" style="height: 42px; padding-left: 20px; padding-right: 20px; color: white; text-decoration: none">
                                        </div>
                                    </form>
                                <?php
                                }
                            } else {
                                ?>
                                <h5>No record found</h5>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include('./includes/footer.php');
?>