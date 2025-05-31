<?php
// Include the database connection file
require 'database.php';


// Check if the request is a POST request and contains valid JSON data
$data = json_decode(file_get_contents("php://input"));

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($data->busRoute)) {
    // Get the selected bus route from the JSON data
    $selectedBusRoute = $data->busRoute;

    // Fetch morning pickups based on the selected BusRoute
    $pickup_query = "SELECT Pickup_Number FROM bus WHERE busRoute_ID = :selectedBusRoute";
    $pickup_statement = $conn->prepare($pickup_query);
    $pickup_statement->bindParam(':selectedBusRoute', $selectedBusRoute, PDO::PARAM_INT);
    $pickup_statement->execute();
    
    // Fetch afternoon drop-offs based on the selected BusRoute
    $dropoff_query = "SELECT Dropoff_Number FROM bus WHERE busRoute_ID = :selectedBusRoute";
    $dropoff_statement = $conn->prepare($dropoff_query);
    $dropoff_statement->bindParam(':selectedBusRoute', $selectedBusRoute, PDO::PARAM_INT);
    $dropoff_statement->execute();

    // Fetch bus number based on the selected BusRoute
    $busNumber_query = "SELECT bus_Number FROM bus WHERE busRoute_ID = :selectedBusRoute";
    $busNumber_statement = $conn->prepare($busNumber_query);
    $busNumber_statement->bindParam(':selectedBusRoute', $selectedBusRoute, PDO::PARAM_INT);
    $busNumber_statement->execute();

    // Prepare the response data
    $response = array(
        'pickOptions' => array(),
        'dropOptions' => array(),
        'busOptions' => array()
    );

    // Fetch and store pick-up options
    while ($row = $pickup_statement->fetch(PDO::FETCH_ASSOC)) {
        $response['pickOptions'][] = array(
            'name' => $row['Pickup_Number'],
            'value' => $row['Pickup_Number']
        );
    }

    // Fetch and store drop-off options
    while ($row = $dropoff_statement->fetch(PDO::FETCH_ASSOC)) {
        $response['dropOptions'][] = array(
            'name' => $row['Dropoff_Number'],
            'value' => $row['Dropoff_Number']
        );
    }

     // Fetch and store bus Number options
     while ($row = $busNumber_statement->fetch(PDO::FETCH_ASSOC)) {
        $response['busOptions'][] = array(
            'name' => $row['bus_Number'],
            'value' => $row['bus_Number']
        );
    }

    // Set the response content type to JSON
    header('Content-Type: application/json');

    // Send the JSON response
    echo json_encode($response);
} else {
    // Handle invalid or missing POST data
    http_response_code(400); // Bad Request
    echo json_encode(array('error' => 'Invalid or missing data.'));
}
?>
