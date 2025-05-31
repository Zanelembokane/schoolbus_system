<?php

// Function to sanitize input data
function sanitize_input($data) {
    global $conn;
    return mysqli_real_escape_string($conn, $data);
}

// Function to authenticate admin login
function admin_login($username, $password) {
    global $conn;
    $username = sanitize_input($username);
    $password = sanitize_input($password);

    // Replace 'admin_table' with your actual admin table name
    $query = "SELECT * FROM administration WHERE email = '$username' AND Password = '$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        return true; // Admin authentication successful
    } else {
        return false; // Admin authentication failed
    }
}

// Function to authenticate parent login
function parent_login($email, $password) {
    global $conn;
    $email = sanitize_input($email);
    $password = sanitize_input($password);

    // Replace 'parent_table' with your actual parent table name
    $query = "SELECT * FROM parent WHERE ParentEmail = '$email' AND Password = '$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        return true; // Parent authentication successful
    } else {
        return false; // Parent authentication failed
    }
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['admin'])) {
        // Admin login form is submitted
        $admin_username = $_POST['username'];
        $admin_password = $_POST['password'];

        if (admin_login($admin_username, $admin_password)) {
            echo "Admin login successful!";
            // Redirect to admin dashboard or perform desired actions
        } else {
            echo "Admin login failed. Please check your credentials.";
        }
    } elseif (isset($_POST['parent'])) {
        // Parent login form is submitted
        $parent_email = $_POST['email'];
        $parent_password = $_POST['password'];

        if (parent_login($parent_email, $parent_password)) {
            echo "Parent login successful!";
            // Redirect to parent dashboard or perform desired actions
        } else {
            echo "Parent login failed. Please check your credentials.";
        }
    }
}

// Close the database connection
//$conn->close();
?>
