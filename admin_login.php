
<?php

//database connection code
$dsn = 'mysql:host=localhost;dbname=bus_registration';
$username = 'root';
$password = '';

try{
    $db = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
    $error_message = $e->getMessage();
    echo "<p>An error occured while connecting to the database: $error_message </p>";
}
?>

<?php
session_start();

$validUsername = 'dnkosi@impumelelo.high.school.co.za'; //admin login that ensures that its only this details that can login as admin no one else
$validPassword = 'DNkosi123@';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === $validUsername && $password === $validPassword) {
        $_SESSION['admin'] = true;
        header('Location: dashboard.php');
        exit();
    } else {
        echo 'Invalid credentials.';
    }
}
?>
