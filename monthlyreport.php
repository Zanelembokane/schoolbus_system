<!DOCTYPE html>
<html>
<head>
    <title>Registered Learners Report</title>
</head>
<body>
    <h1>Registered Learners Report</h1>
    <div id="chart_div"></div>
    
<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bus_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve learner data from the database
$query = "SELECT * FROM learner";
$result = $conn->query($query);

$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = array(
        'LearnerFullNames' => $row['LearnerFullNames'],
		'CellPhoneNumber' => $row['CellPhoneNumber'],
		'Grade' => $row['Grade'],
		
        
    );
}

echo json_encode($data);

$conn->close();
?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Month');
        data.addColumn('number', 'Registered Learners');
        data.addRows(<?php echo json_encode($dataArray); ?>);

        var options = {
            title: 'Registered Learners Monthly Report',
            curveType: 'function',
            legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }
</script>
</body>
</html>

<br><br>
<a href="admin_dashboard.php">MIS Reports</a><br><br>

<a href="parent_dashboard.php">REGISTRATION</a><br><br>

<a href="Home.php">HOME</a><br><br>



