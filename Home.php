<!DOCTYPE html>
<html lang="en">+
<meta charset="UTF-8">
<title>Bus System</title>
<meta name="viewport" content="width=device-width,initial-scale=1"> 
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<style>

   

</style>

<body>
<div class="w3-container w3-center w3-teal">
  <h1>IMpumelelo High School</h1>
  <p>Bus Registration System</p>
</div>

<?php include 'login_form.html'?>;


</body>
</html>


<?php
include 'database.php';


function validateFormData($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $conn = connectToDatabase();

        $username = validateFormData($_POST['username']);
        $password = validateFormData($_POST['password']);

        $query = "SELECT * FROM administrator WHERE email=? LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(1, $username, PDO::PARAM_STR);

        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
      

        if ($result && $password === $result['Password']) {
            header("Location: admin_dashboard.php");
            exit();
        } else {
            echo "Invalid admin credentials";
        }
        

         $stmt->closeCursor(); 
        $conn = null;
    }

    if (isset($_POST['email']) && isset($_POST['parentPassword'])) {
        $conn = connectToDatabase();

        $username = validateFormData($_POST['email']);
        $password = validateFormData($_POST['parentPassword']);

        $query = "SELECT * FROM Parent WHERE ParentEmail=? LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(1, $username, PDO::PARAM_STR);

        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
       

        if ($result && $password === $result['Password']) {
            header("Location: parent_dashboard.php");
            exit();
        } else {
            echo "Invalid parent credentials";
        }

        $stmt->closeCursor();
        $conn = null; 
    }
}
?>


