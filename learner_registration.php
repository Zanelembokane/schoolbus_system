

<?php
// database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bus_registration";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // extract form data
    $learnerName = $_POST['learner_name'];
    $learnerSurname = $_POST['learner_surname'];
    $learnerCellphone = $_POST['learner_cellphone'];
    $grade = $_POST['grade'];
    $busNumber = $_POST['bus_number'];
	$pickupOption = $_POST['pickup_option'];
	$pickupTime = $_POST['pickup_time'];
	$dropoffTime = $_POST['dropoff_time'];
	$pickupName = $_POST['pickup_name'];
	$dropoffName = $_POST['dropoff_name'];
	
}
// Save learner data to database

$sqlLearner = "INSERT INTO leaner (LeanerName, LearnerSurname, LearnerCellNo, LearnerGrade) VALUES (?, ?, ?, ?)";
$stmtLearner = $conn->prepare($sqlLearner);
$stmtLearner->bind_param("ssss", $learnerName, $learnerSurname, $learnerCellphone, $grade);

$sqlBusRoute = "INSERT INTO busroute (BusNumber, PickupOption, PickupTime, DropOffTime, PickupName, DropoffName) VALUES (?, ?, ?, ?, ?, ?)";
$stmtBusRoute = $conn->prepare($sqlBusRoute);
$stmtBusRoute->bind_param("ssssss", $busNumber, $pickupOption, $pickupTime, $dropoffTime, $pickupName, $dropoffName);

if ($stmtLearner->execute() && $stmtBusRoute->execute()) {
    echo "Data inserted successfully";
} else {
    echo "Error: " . $sqlLearner . "<br>" . $stmtLearner->error;
    echo "Error: " . $sqlBusRoute . "<br>" . $stmtBusRoute->error;
}

$stmtLearner->close();
$stmtBusRoute->close();

header('Location: learner_registration.html'); // Redirect to learner registration form after submiting data
exit();

$conn->close();

?>
