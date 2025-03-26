<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Homepage</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .header {
            background-color: #4CAF50;
            color: white;
            padding: 10px 0;
            text-align: center;
        }
        .nav {
            display: flex;
            justify-content: center;
            background-color: #333;
        }
        .nav a {
            padding: 14px 20px;
            display: block;
            color: white;
            text-align: center;
            text-decoration: none;
        }
        .nav a:hover {
            background-color: #ddd;
            color: black;
        }
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }
        .content {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }
        .box {
            background: white;
            padding: 20px;
            margin: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 30%;
            text-align: center;
        }
        h1 {
            text-align: center;
        }
        .welcome {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <?php include 'menustudent.php'; ?>
    <div class="container">
        <div class="welcome">
            <h2>Welcome, <?php echo $_SESSION['name']; ?>!</h2>
        </div>
        <div class="content">
            <div class="box">
                <h3>View Tracking Status</h3>
                <p>Check the status of your packages.</p>
                <a href="tracking_status.php">Go to Tracking Status</a>
            </div>
            <div class="box">
                <h3>Profile</h3>
                <p>View and edit your profile information.</p>
                <a href="studentprofile.php">Go to Profile</a>
            </div>
            <div class="box">
                <h3>Help</h3>
                <p>Get help and support for any issues.</p>
                <a href="help_question.php">Go to Help</a>
            </div>
        </div>
    </div>
</body>
</html>
