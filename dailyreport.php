
<!DOCTYPE html>
<html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<body>

<canvas id="myChart" style="width:100%;max-width:600px"></canvas>
<?php
    // php code that calls data from the database
    include "database.php";

    $query = "SELECT Grade, COUNT(*) as count FROM learner GROUP BY Grade";
    $result = $conn->query($query);
    $data = array('xLearnerGrade' => array(), 'yNumberOfStudents' => array());
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $data['xLearnerGrade'][] = $row['Grade'];
        $data['yNumberOfStudents'][] = $row['count'];
    }
    $conn = null;
?>

<script>
var data = <?php echo json_encode($data); ?>;
var barColors = ['rgba(75, 192, 192, 0.2)', 'rgba(255, 99, 132, 0.2)', 'rgba(255, 206, 86, 0.2)', 'rgba(54, 162, 235, 0.2)'];

new Chart("myChart", {
    type: "bar",
    data: {
        labels: data.xLearnerGrade,
        datasets: [{
            backgroundColor: barColors,
            data: data.yNumberOfStudents
        }]
    },
    options: {
        legend: { display: false },
        title: {
            display: true,
            text: "Registered Students"
        }
    }
});

</script>
<a href="admin_dashboard.php">MIS Reports</a><br><br>
<a href="parent_dashboard.php">REGISTRATION</a><br><br>
<a href="Home.php">HOME</a><br><br>

</body>
</html>