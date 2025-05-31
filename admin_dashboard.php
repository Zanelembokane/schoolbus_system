<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>
<style>
// css stylesheet for dashboard page

  body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
  }
  #sidebar {
    width: 250px;
    background-color: MediumSeaGreen;
    color: #fff;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    padding-top: 20px;
  }
  #content {
    margin-left: 250px;
    padding: 20px;
  }
  ul {
    list-style: none;
    padding: 0;
  }
  li {
    padding: 10px 0;
  }
  a {
    color: #fff;
    text-decoration: none;
    display: block;
    padding: 10px 20px;
  }
  a:hover {
    background-color: #555;
  }
</style>
</head>
<body>
  <div id="sidebar">
    <ul>
      <li><a href="#">Dashboard</a></li>
      <li><a href="dailyreport.php">Daily Report</a></li>
      <li><a href="weeklyreport.php">Weekly Report</a></li>
      <li><a href="monthlyreport.php">Other Report</a></li>
    </ul>
  </div>
  <div id="content">
    <h1>Dashboard</h1>
    <p>Welcome to the admin dashboard.</p>
  </div>
</body>
</html>

<a href="parent_dashboard.php">REGISTRATION</a><br><br>

<a href="Home.php">HOME</a><br><br>