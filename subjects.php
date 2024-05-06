    <?php
    session_start();

    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "ipt101";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Function to fetch the logged-in user ID from the `profile` table
    function getLoggedInUserId() {
        if (isset($_SESSION['id'])) {
            // Standard login
            return $_SESSION['id'];
        } elseif (isset($_SESSION['fb_id'])) {
            // Facebook login
            global $conn;
            $fb_id = $_SESSION['fb_id'];
            $query = "SELECT id FROM user_profile1 WHERE fb_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $fb_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row['id'];
            } else {
                return null;
            }
        } else {
            return null;
        }
    }
    // Function to fetch all subjects/courses from the database
    function getAllSubjects() {
        global $conn;
        $sql = "SELECT * FROM subjects2 WHERE user_id = " . getLoggedInUserId();
        $result = $conn->query($sql);
        $subjects = array();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $subjects[] = $row;
            }
        }
        return $subjects;
    }

    // Function to add a new subject/course to the database
    function addSubject($name, $description, $credits) {
        global $conn;
        $name = mysqli_real_escape_string($conn, $name);
        $description = mysqli_real_escape_string($conn, $description);
        $credits = intval($credits);
        $user_id = getLoggedInUserId();
    
        // Check if the user_id exists in the user_profile1 table
        $sql = "SELECT * FROM user_profile1 WHERE id = $user_id";
        $result = $conn->query($sql);
        if ($result->num_rows == 0) {
            // User not found, do not insert into subjects2 table
            return false;
        }
    
        $sql = "INSERT INTO subjects2 (name, description, credits, user_id) VALUES ('$name', '$description', $credits, $user_id)";
        if ($conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }
    ?>

   
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Subject/Course Management</title>
<!-- Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<!-- Custom CSS -->
<style>
    .container { padding: 2rem; }
</style>
</head>
<body>
<div class="container">
    <h1>Subject/Course Management</h1>
    <p>Welcome, <?php echo isset($_SESSION['id']) ? $_SESSION['id'] : 'STUDENT'; ?>!</p>
    <hr>
    <!-- Form to add a new subject/course -->
    <h2>Add New Subject/Course</h2>
    <form id="addSubjectForm" method="post" action="">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" cols="50" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="credits">Credits:</label>
            <input type="number" id="credits" name="credits" class="form-control" required>
        </div>
        <button type="submit" name="add_subject" class="btn btn-primary">Add Subject/Course</button>
    </form>
    <hr>
    <!-- Display all subjects/courses -->
    <h2>Subjects/Courses</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Credits</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
    <?php
    // Add new subject/course if form is submitted
    if(isset($_POST['add_subject'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $credits = $_POST['credits'];
        if(addSubject($name, $description, $credits)) {
            echo "<div>Subject/Course added successfully.</div>";
        } else {
            echo "<div>Error adding subject/course.</div>";
        }
    }

    // Fetch and display all subjects/courses
    $subjects = getAllSubjects();
    foreach($subjects as $subject) {
        echo "<tr>";
        echo "<td>".$subject['id']."</td>";
        echo "<td>".$subject['name']."</td>";
        echo "<td>".$subject['description']."</td>";
        echo "<td>".$subject['credits']."</td>";
        echo "<td><a href='delete_subject.php?id=".$subject['id']."'>Delete</a></td>";
        echo "</tr>";
        
    }
    ?>
    </table>

    <!-- Link to go back to user profile -->
    <a href="standard-user-profile.php">Back to User Profile</a>
    <br>

    </body>
    </html>

    <?php
    // Close database connection
    $conn->close();
    ?>
