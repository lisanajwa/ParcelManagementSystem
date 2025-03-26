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
    <title>Staff Homepage</title>
	<style>
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
	<?php include 'menustaff.php'; ?>
    <div class="container">
        <div class="welcome">
            <h2>Welcome, <?php echo $_SESSION['name']; ?>!</h2>
        </div>
        <div class="content">
            <div class="box">
                <h3>Add Tracking Information</h3>
                <p>Enter new tracking information for shipments.</p>
                <a href="add_tracking.php">Go to Add Tracking</a>
            </div>
            <div class="box">
                <h3>View Reports</h3>
                <p>Check detailed reports of tracking information.</p>
                <a href="view_reports.php">Go to View Reports</a>
            </div>
            <div class="box">
                <h3>Profile</h3>
                <p>View and edit your profile information.</p>
                <a href="staffprofile.php">Go to Profile</a>
            </div>
			<div class="box">
                <h3>Help Answer</h3>
                <p>View and answer questions asked by students.</p>
                <a href="help_answer.php">Go to Help Answer</a>
            </div>
        </div>
    </div>
</body>
</html>
