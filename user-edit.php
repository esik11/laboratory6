<?php
include('includes/db-conn.php');
// Start session to manage user data
session_start();

// Check if user is logged in using Facebook or standard login
if (isset($_SESSION['id'])) {
    // Retrieve user ID from session
    $user_id = $_SESSION['id'];

    // Query to fetch user data based on user ID
    $query = "SELECT email, firstname, last_name, gender, phone, address FROM user_profile1 WHERE id = $user_id";

    // Execute query
    $result = mysqli_query($conn, $query);

    // Check if query is successful and user data is found
    if ($result && mysqli_num_rows($result) > 0) {
        // Fetch user details
        $user = mysqli_fetch_assoc($result);
    } else {
        // Handle error if no user found with the given user ID
        // For instance, redirect the user to a login page or display an error message
    }
} else {
    // Handle the case where the user is not logged in
    // For instance, redirect the user to a login page
    header("Location: login.php");
    exit();
}

// Handle form submission to update user profile
if (isset($_POST['update_profile'])) {
    // Escape user input to prevent SQL injection
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    // Update user profile in the database
    $query = "UPDATE user_profile1 SET firstname = '$firstname', last_name = '$last_name', email = '$email', phone = '$phone', address = '$address' WHERE id = $user_id";

    // Execute query
    $result = mysqli_query($conn, $query);

    // Check if query is successful
    if ($result) {
        // Handle successful update
        echo "Profile updated successfully!";
    } else {
        // Handle error
        echo "Error updating profile: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="content-wrapper">
    <section class="content-header">
        <!-- Header content -->
    </section>
    <section class="content">
        <?php ob_start(); ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">Update Profile</h5>
                        </div>
                        <div class="card-body">
                            <form method="post" action="" id="updateProfileForm">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" class="form-control" id="email"
                                           value="<?= isset($user['email']) ? $user['email'] : ''; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="firstname">First Name</label>
                                    <input type="text" name="firstname" class="form-control"
                                           id="firstname" value="<?= isset($user['firstname']) ? $user['firstname'] : ''; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" name="last_name" class="form-control"
                                           id="last_name" value="<?= isset($user['last_name']) ? $user['last_name'] : ''; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="gender">Gender</label>
                                    <input type="text" name="gender" class="form-control" id="gender" value="<?= isset($user['gender']) ? $user['gender'] : ''; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone Number</label>
                                    <input type="text" name="phone" class="form-control"
                                           id="phone" value="<?= isset($user['phone']) ? $user['phone'] : ''; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" name="address" class="form-control"
                                           id="address" value="<?= isset($user['address']) ? $user['address'] : ''; ?>">
                                </div>
                                <button type="submit" name="update_profile" class="btn btn-primary">Update</button>
                                <a href="standard-user-profile.php" class="btn btn-secondary">Go Back</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php ob_end_flush(); ?>
    </section>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    // Example form validation using jQuery
    $(document).ready(function () {
        $('#updateProfileForm').submit(function (event) {
            var email = $('#email').val();
            var firstname = $('#firstname').val();
            var lastname = $('#last_name').val();
            var phone = $('#phone').val();
            var address = $('#address').val();
            var isValid = true;

            // Simple email validation
            if (email === '') {
                isValid = false;
                $('#email').addClass('is-invalid');
            } else {
                $('#email').removeClass('is-invalid');
            }

            // You can add more validation rules here

            if (!isValid) {
                event.preventDefault();
            }
        });
    });
</script>

</body>
</html>
