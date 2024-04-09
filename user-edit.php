<?php
include('includes/db-conn.php');
// Start session to manage user data
session_start();

// Check if user is logged in using Facebook or standard login
if (isset($_SESSION['id'])) {
    // Retrieve user ID from session
    $user_id = $_SESSION['id'];

    // Query to fetch user data based on user ID
    $query = "SELECT email, password, firstname , last_name, full_name, gender, phone, address FROM profile WHERE id = $user_id";

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
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    // Update user profile in the database
    $query = "UPDATE profile SET firstname = '$firstname', last_name = '$last_name', email = '$email', password = '$password', phone = '$phone', address = '$address' WHERE id = $user_id";

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
                        <div class="card-body">
                            <?php
                            // Display the form
                            ?>
                            <form method="post" action="">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" class="form-control" id="email"
                                           value="<?php echo isset($userinfo['email']) ? $userinfo['email'] : ''; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="firstname">First Name</label>
                                    <input type="text" name="firstname" class="form-control"
                                           id="firstname" value="<?php echo isset($userinfo['firstname']) ? $userinfo['firstname'] : ''; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="lastname">Last Name</label>
                                    <input type="text" name="lastname" class="form-control"
                                           id="lastname" value="<?php echo isset($userinfo['last_name']) ? $userinfo['last_name'] : ''; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="gender">Gender</label>
                                    <input type="text" name="gender" class="form-control"
                                           id="gender" value="<?php echo isset($userinfo['gender']) ? $userinfo['gender'] : ''; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone Number</label>
                                    <input type="text" name="phone" class="form-control"
                                           id="phone" value="<?php echo isset($userinfo['phone']) ? $userinfo['phone'] : ''; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" name="address" class="form-control"
                                           id="address" value="<?php echo isset($userinfo['address']) ? $userinfo['address'] : ''; ?>">
                                </div>
                                <input type="submit" name="update_profile"
                                       class="btn btn-primary" value="Update">
                                <a href="standard-user-profile.php" class="d-block">go back</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php ob_end_flush(); ?>
    </section>
</div>

<?php include('includes/footer.php'); ?>
