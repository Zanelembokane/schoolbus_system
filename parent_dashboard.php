<?php 
session_start();
include "database.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function sendEmailNotification($to, $message)
{
    $mail = new PHPMailer;

    // Set up your Gmail credentials
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls'; // Enable if using TLS
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587; // Use 465 for SSL
    $mail->Username = 'zanelembokane01@gmail.com'; // Your Gmail address
    $mail->Password = 'vnfi hiyq pamv ptwo'; // Your Gmail password

    $mail->setFrom('zanelembokane01@gmail.com', 'Zanele');
    $mail->addAddress($to);

    $mail->Subject = 'Learner Registration Notification';
    $mail->Body = $message;

    if (!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'Message has been sent';
    }
}

  // Retrieve form data

$bus_statement = $conn->prepare("SELECT * FROM bus");
$bus_statement->execute();

$parent_statement = $conn->prepare("SELECT * FROM parent");
$parent_statement->execute();

$learner_statement = $conn->prepare("SELECT * FROM learner");
$learner_statement->execute();


// Fetch the selected BusRoute from the form
$selectedBusRoute = isset($_POST['busRoute']) ? $_POST['busRoute'] : null;

$selectedLearner = isset($_POST['Learner_ID']) ? $_POST['Learner_ID'] : null;


// Fetch the selected Learner from the form
$email = isset($_POST['email']) ? $_POST['email'] : null;



// Define the query to fetch Learner Name
$bus_query = "SELECT Learner_ID, LearnerFullNames FROM learner 
              WHERE Learner_ID IN (SELECT Learner_ID FROM parent WHERE ParentEmail = :email)
              ";
$bus_statement = $conn->prepare($bus_query);
$bus_statement->bindParam(':email', $email, PDO::PARAM_INT);
$bus_statement->execute();


// Define the query to fetch bus routes
$busroute_query = "SELECT busRoute_ID, busRoute FROM busroute";
$busroute_statement = $conn->prepare($busroute_query);
$busroute_statement->execute();

  

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve form data
  $selectedLearner = isset($_POST['Learner_ID']) ? $_POST['Learner_ID'] : null;
  $busRouteID = isset($_POST['busRoute_ID']) ? $_POST['busRoute_ID'] : null;
  $busNumber = isset($_POST['bus_Number']) ? $_POST['bus_Number'] : null;
  $pickupNumber = isset($_POST['Pickup_Number']) ? $_POST['Pickup_Number'] : null;
  $dropoffNumber = isset($_POST['Dropoff_Number']) ? $_POST['Dropoff_Number'] : null;
  $email = isset($_POST['ParentEmail']) ? $_POST['ParentEmail'] : null;

   // Check if the learner is already registered in the bus table
   $checkLearnerStatement = $conn->prepare("SELECT COUNT(*) FROM bus WHERE Learner_ID = ?");
   $checkLearnerStatement->bindParam(1, $selectedLearner, PDO::PARAM_INT);
   $checkLearnerStatement->execute();
   $learnerExists = $checkLearnerStatement->fetchColumn();

   // Check if the learner is already in the waiting list
   $checkWaitingListStatement = $conn->prepare("SELECT COUNT(*) FROM waitinglist WHERE Learner_ID = ?");
   $checkWaitingListStatement->bindParam(1, $selectedLearner, PDO::PARAM_INT);
   $checkWaitingListStatement->execute();
   $learnerInWaitingList = $checkWaitingListStatement->fetchColumn();

   if ($learnerExists > 0) {
       // Learner already registered
       echo "Learner already registered";
   } elseif ($learnerInWaitingList > 0) {
       // Learner already in the waiting list
       echo "Learner already in the waiting list";
   } else {
       // Insert data into the bus table
       $insertBusStatement = $conn->prepare("INSERT INTO bus (Learner_ID, busRoute_ID, bus_Number, Pickup_Number, Dropoff_Number) VALUES (?, ?, ?, ?, ?)");

       // Bind parameters
       $insertBusStatement->bindParam(1, $selectedLearner, PDO::PARAM_INT);
       $insertBusStatement->bindParam(2, $busRouteID, PDO::PARAM_INT);
       $insertBusStatement->bindParam(3, $busNumber, PDO::PARAM_STR);
       $insertBusStatement->bindParam(4, $pickupNumber, PDO::PARAM_STR);
       $insertBusStatement->bindParam(5, $dropoffNumber, PDO::PARAM_STR);

       // Execute the statement
       $insertBusStatement->execute();

      // Check the conditions for adding to the waiting list
        $busCountQuery = "SELECT COUNT(*) FROM bus WHERE busRoute_ID = :busRouteID AND bus_Number = :busNumber";
        $busCountStatement = $conn->prepare($busCountQuery);
        $busCountStatement->bindParam(':busRouteID', $busRouteID, PDO::PARAM_INT);
        $busCountStatement->bindParam(':busNumber', $busNumber, PDO::PARAM_STR);
        $busCountStatement->execute();
        $learnerCount = $busCountStatement->fetchColumn();

        if (($busNumber == 'Bus 1' && $learnerCount > 35) ||
            (($busNumber == 'Bus 2' || $busNumber == 'Bus 3') && $learnerCount > 15)) {
            // Insert into the waiting list
            $insertWaitingListStatement = $conn->prepare("INSERT INTO waitinglist (Learner_ID) VALUES (?)");
            $insertWaitingListStatement->bindParam(1, $selectedLearner, PDO::PARAM_INT);
            $insertWaitingListStatement->execute();

            // Email the user about the successful application
            $to = 'nqobile.unisaproject@gmail.com';
            $subject = "Learner Placed on the waiting List";
            $message = "Dear Parent,<br><br>Your child's application for using our bus for the 2024 academic year has received. They have been placed on the waiting list.<br><br>Thank you for choosing our transportation service.";

            $emailResult = sendEmailNotification($to, $subject, $message);

            if ($emailResult === true) {
                echo "An email confirmation has been sent to your email address.";
            } else {
                echo $emailResult; // Display the email error message
            }

            echo "Learner added to the waiting list";
        } else {
                  // Email the user about the successful application
                  $to = 'nqobile.unisaproject@gmail.com';
                  $subject = "Learner registered successfully";
                  $message = "Dear Parent,<br><br>Your child's application for using our bus for the 2024 academic year has been successfully. They have been approved for the bus service.<br><br>Thank you for choosing our transportation service.";

                  $emailResult = sendEmailNotification($to, $subject, $message);

                  if ($emailResult === true) {
                      echo "An email confirmation has been sent to your email address.";
                  } else {
                      echo $emailResult; // Display the email error message
                  }


           echo "Learner registered successfully";

           echo '<br><br><a href="Home.php">Home</a><br>';

           echo '<br><br><a href="parent_dashboard.php">Registration</a><br>';

           exit();
       }
   }
}
?>




<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {
  font-family: Arial, Helvetica, sans-serif;
  background-color: MediumSeaGreen; /* Change background color to match admin.php */
  margin: 0;
  padding: 0;
}

.container {
  padding: 20px; /* Increase padding for better spacing */
  background-color: white;
  border-radius: 10px; /* Add border radius for rounded corners */
  margin-top: 50px; /* Adjust margin for better alignment */
  margin-bottom: 50px; /* Adjust margin for better alignment */
}

label {
    margin-top: 10px;
    font-weight: bold;
}

h1, p {
  color: #000000; /* Change text color to white */
}

label {
  color: #000000; /* Change label text color to white */
}

/* Set background color and text-align for the "log in" section */
.login {
  background-color: MediumSeaGreen; /* Match admin.php background color */
  text-align: center;
  padding: 10px; /* Add padding for better spacing */
  border-radius: 5px; /* Add border radius for rounded corners */
}

/* Set a style for the submit button */
.registerbtn {
  background-color: MediumSeaGreen; /* Match admin.php background color */
  color: white;
  padding: 16px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 50%;
  opacity: 0.9;
  border-radius: 5px; /* Add border radius for rounded corners */
}

.registerbtn:hover {
  opacity: 1;
}

/* Add a blue text color to links */
a {
  color: dodgerblue;
}

/* Overwrite default styles of hr */
hr {
  border: 1px solid #f1f1f1;
  margin-bottom: 25px;
}

  /* Style for the link */
  a {
    font-weight: bold;  /* Make the text bold */
    color: #ff0000;     /* Set the color to red (you can choose a different color) */
    text-decoration: none;  /* Remove the underline (optional) */
  }

  /* Style for the link when hovered over */
  a:hover {
    text-decoration: underline;  /* Add underline on hover (optional) */
  }

/* Style the select dropdown */
select {
  padding: 10px;
  border-radius: 5px;
  margin-bottom: 10px;
}

/* Style the form inputs */
input[type="text"] {
  padding: 10px;
  border-radius: 5px;
  margin-bottom: 10px;
}

</style>
</head>
<body>

<div class="container">
  <h1>Register</h1>
  <p>Please Complete the form to Register a learner.</p>

  <form action="" method="post"> 


      <label>Learner Full Name:</label>
          <select name="Learner_ID" id="Learner_ID">
        <?php
        while ($row = $learner_statement->fetch(PDO::FETCH_ASSOC)) {
            $learnerID = $row['Learner_ID'];  
            $learnerFullName = $row['LearnerFullNames'];
            $selected = ($learnerID == $selectedLearner) ? 'selected' : '';
            echo "<option value='$learnerID' $selected>$learnerFullName</option>";
        }
        ?>
    </select><br><br>

    
            <label>Bus Route:</label>
            <select name="busRoute_ID" id="busRoute_ID">
            <?php
            // Loop through the available bus routes
            while ($row = $busroute_statement->fetch(PDO::FETCH_ASSOC)) {
                $busRouteID = $row['busRoute_ID'];  
                $busRouteName = $row['busRoute'];
                $selected = ($busRouteID == $selectedBusRoute) ? 'selected' : '';
                echo "<option value='$busRouteID' $selected>$busRouteName</option>";
            }
            ?>
        </select><br><br>

        <label>Bus Number:</label>
        <select name="bus_Number" id="bus_Number">
        <option value="">Choose a bus Number</option> 
        </select><br><br>

        <label>Pick up Number:</label>
        <select name="Pickup_Number" id="Pickup_Number">
        <option value="">Choose a pickup</option> 
        </select><br><br>

        <label>Drop Off Number:</label>
        <select name="Dropoff_Number" id="Dropoff_Number">
        <option value="">Choose a dropoff</option> 
        </select><br><br>



    <button type="submit" class="register">Register</button>
	</form> 
	<script>
    // JavaScript to handle dynamic population of pick-up and drop-off options based on bus route selection
        const busRouteSelect = document.getElementById('busRoute_ID');
        const pickNumberSelect = document.getElementById('Pickup_Number');
        const dropNumberSelect = document.getElementById('Dropoff_Number');
        const busNumberSelect = document.getElementById('bus_Number');
     

    // Event listener to trigger when a new bus route is selected
        busRouteSelect.addEventListener('change', function() {
        const selectedBusRoute = busRouteSelect.value;

    // Send a request to the server to get pick-up and drop-off options
    fetch('get_pick_drop_options.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json', // Set content type to JSON
        },
        body: JSON.stringify({ busRoute: selectedBusRoute }), // Send data as JSON
    })
    .then(response => response.json())
    .then(data => {
        // Clear existing options in the pickNumberSelect and dropNumberSelect and busNumberSelect
        pickNumberSelect.innerHTML = '';
        dropNumberSelect.innerHTML = '';
        busNumberSelect.innerHTML = '';

        // Populate the pickNumberSelect, dropNumberSelect and busNumberSelect based on the response data
        data.pickOptions.forEach(option => {
            const pickOption = new Option(option.name, option.value);
            pickNumberSelect.add(pickOption);
        });

        data.dropOptions.forEach(option => {
            const dropOption = new Option(option.name, option.value);
            dropNumberSelect.add(dropOption);
        });

        data.busOptions.forEach(option => {
            const busOption = new Option(option.name, option.value);
            busNumberSelect.add(busOption);
        });
    })
    .catch(error => {
        console.error('Error:', error);
    });
});

</script>

</div>


</body>
</html><br>

<a href="Home.php">Home</a><br>


<a href="WaitingList.php">Waiting List</a>