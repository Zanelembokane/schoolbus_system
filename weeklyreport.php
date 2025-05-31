<!DOCTYPE html>
<html>
<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
</head>
<body>

<canvas id="myChart" style="width:100%;max-width:600px"></canvas>

<?php
include 'database.php';

// Modify this query to fetch weekly data from the database
$sqlWeekly = "SELECT Grade, COUNT(*) as NumberOfStudents
              FROM learner
              WHERE registrationDate BETWEEN CURDATE() - INTERVAL 1 WEEK AND CURDATE()
              GROUP BY Grade";
$resultWeekly = $conn->query($sqlWeekly);

$dataWeekly = $resultWeekly->fetchAll(PDO::FETCH_ASSOC);

// Prepare data for JavaScript chart
$xLearnerGradeWeekly = [];
$yNumberOfStudentsWeekly = [];
$barColorsWeekly = ["red", "green", "blue", "orange", "brown"];

foreach ($dataWeekly as $row) {
    $xLearnerGradeWeekly[] = $row['Grade'];
    $yNumberOfStudentsWeekly[] = $row['NumberOfStudents'];
}
?>

<script>
var xLearnerGradeWeekly = <?php echo json_encode($xLearnerGradeWeekly); ?>;
var yNumberOfStudentsWeekly = <?php echo json_encode($yNumberOfStudentsWeekly); ?>;
var barColorsWeekly = <?php echo json_encode($barColorsWeekly); ?>;

new Chart("myChart", {
  type: "bar",
  data: {
    labels: xLearnerGradeWeekly,
    datasets: [{
      backgroundColor: barColorsWeekly,
      data: yNumberOfStudentsWeekly
    }]
  },
  options: {
    legend: {display: false},
    title: {
      display: true,
      text: "Registered Students (Last Week)"
    }
  }
});
</script>

<a href="admin_dashboard.php">MIS Reports</a><br><br>

<a href="parent_dashboard.php">REGISTRATION</a><br><br>

<a href="Home.php">HOME</a><br><br>

</body>
</html>




