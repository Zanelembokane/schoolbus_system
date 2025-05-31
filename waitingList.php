<?php

include 'database.php';

// Select learners and waiting list information
$sql = "SELECT l.LearnerFullNames, l.Grade, l.CellPhoneNumber, w.waitingDate, w.waitingListID
        FROM learner l
        JOIN waitinglist w ON l.Learner_ID = w.learner_ID";
$result = $conn->query($sql);

$data = $result->fetchAll(PDO::FETCH_ASSOC);

// Select learners from the waiting list
$sql = "SELECT l.Learner_ID, w.waitingListID 
        FROM learner l
        JOIN waitinglist w ON l.Learner_ID = w.learner_ID";
$result = $conn->query($sql);

// Fetch Learner_IDs and waitingList_IDs from the waiting list
$waitingListData = $result->fetchAll(PDO::FETCH_ASSOC);

// Prepare Learner_IDs and waitingList_IDs for the WHERE clause
$waitingListIDs = array_column($waitingListData, 'Learner_ID');
$waitingListIDsString = implode(',', $waitingListIDs);

// Update the "bus" table
$updateSql = "UPDATE bus
              SET application_status = CASE
                                       WHEN Learner_ID IN ($waitingListIDsString) THEN 'Waiting list'
                                       ELSE 'Approved'
                                     END,
                  waitingList_Number = CASE
                                       WHEN Learner_ID IN ($waitingListIDsString) THEN (
                                           SELECT waitingListID
                                           FROM waitinglist
                                           WHERE learner_ID = bus.Learner_ID
                                       )
                                       ELSE waitingList_Number
                                     END
              WHERE Learner_ID IN ($waitingListIDsString)";

$updateResult = $conn->exec($updateSql);

?>


<!DOCTYPE html>
<html>
<head>
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
			
    <h1>All current learners placed on the waiting list</h1>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        table {
            width: 60%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <th>Learner Full Name</th>
            <th>Learner Grade</th>
            <th>Learner Cellphone Number</th>
            <th>Waiting List Date</th>
        </tr>
        <?php foreach ($data as $row): ?>
            <tr>
                <td><?php echo $row['LearnerFullNames']; ?></td>
                <td><?php echo $row['Grade']; ?></td>
                <td><?php echo $row['CellPhoneNumber']; ?></td>
                <td><?php echo $row['waitingDate']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <a href="parent_dashboard.php">REGISTRATION</a><br><br>

    <a href="Home.php">HOME</a><br><br>
</body>
</html>
