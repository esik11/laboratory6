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
        return $_SESSION['id'];
    } else {
        return null;
    }
}

// Function to fetch all subjects/courses from the database
function getAllSubjects() {
    global $conn;
    $sql = "SELECT * FROM subjects1 WHERE user_id = " . getLoggedInUserId();
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
    $sql = "INSERT INTO subjects1 (name, description, credits, user_id) VALUES ('$name', '$description', $credits, $user_id)";
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
</head>
<body>
<h1>Subject/Course Management</h1>
<p>Welcome, <?php echo isset($_SESSION['id']) ? $_SESSION['id'] : 'STUDENT'; ?>!</p>
<hr>

<!-- Form to add a new subject/course -->
<h2>Add New Subject/Course</h2>
<form method="post" action="">
<label for="name">Name:</label>
<input type="text" id="name" name="name" required><br><br>
<label for="description">Description:</label><br>
<textarea id="description" name="description" rows="4" cols="50" required></textarea><br><br>
<label for="credits">Credits:</label>
<input type="number" id="credits" name="credits" required><br><br>
<input type="submit" name="add_subject" value="Add Subject/Course">
</form>
<hr>

<!-- Display all subjects/courses -->
<h2>Subjects/Courses</h2>
<table border="1">
<tr>
<th>ID</th>
<th>Name</th>
<th>Description</th>
<th>Credits</th>
<th>Action</th>
</tr>

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

</body>
</html>

<?php
// Close database connection
$conn->close();
?>