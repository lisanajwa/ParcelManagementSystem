<?php
session_start();
include 'db.php';

header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

$sql_users = "SELECT id, name FROM user WHERE role = 'student'";
$result_users = mysqli_query($conn, $sql_users);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tracking_number = mysqli_real_escape_string($conn, $_POST['tracking_number']);
    $arrival_date = mysqli_real_escape_string($conn, $_POST['arrival_date']);
    $arrival_time = mysqli_real_escape_string($conn, $_POST['arrival_time']);
    $status = 'Arrived';  
    $user_id = intval($_POST['user_id']); 
    $sql = "INSERT INTO tracking_status (tracking_number, arrival_date, arrival_time, status, user_id) 
            VALUES (?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssssi", $tracking_number, $arrival_date, $arrival_time, $status, $user_id);
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['message'] = '<div class="success">New tracking information added successfully!</div>';
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            header("Location: add_tracking.php");
            exit();
        } else {
            $_SESSION['message'] = '<div class="error">Error: ' . mysqli_stmt_error($stmt) . '</div>';
        }
    } else {
        $_SESSION['message'] = '<div class="error">Error: ' . mysqli_error($conn) . '</div>';
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    header("Location: add_tracking.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Tracking Information</title>
    <style>
        .container {
            width: 50%;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-top: 15px;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="date"], input[type="time"], select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 20px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
        }
        .footer a {
            text-decoration: none;
            color: #4CAF50;
        }
        .footer a:hover {
            color: #45a049;
        }
        .message {
            text-align: center;
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
        }
        .success {
            background-color: #e0ffe0;
            border: 1px solid #b2d8b2;
        }
        .error {
            background-color: #ffe0e0;
            border: 1px solid #d8b2b2;
        }
    </style>
    <script>
        function redirectAfterDelay() {
            setTimeout(function() {
                window.location.href = 'add_tracking.php';
            }, 3000); 
        }
    </script>
</head>
<body>
	<?php include 'menustaff.php'; ?>
    <div class="container">
        <h1>Add Tracking Information</h1>
        <?php
        if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
            echo '<script>redirectAfterDelay();</script>';
            unset($_SESSION['message']);
        }
        ?>
        <form method="post" action="">
            <label for="tracking_number">Tracking Number:</label>
            <input type="text" id="tracking_number" name="tracking_number" required>

            <label for="arrival_date">Arrival Date:</label>
            <input type="date" id="arrival_date" name="arrival_date" required>

            <label for="arrival_time">Arrival Time:</label>
            <input type="time" id="arrival_time" name="arrival_time" required>

            <input type="hidden" id="status" name="status" value="Arrived">

            <label for="user_id">Assigned Student:</label>
            <select id="user_id" name="user_id" required>
                <?php 
                while ($row = mysqli_fetch_assoc($result_users)) {
                    echo '<option value="' . $row['id'] . '">' . $row['id'] . '</option>';
                } 
                ?>
            </select>

            <button type="submit">Add</button>
        </form>
    </div>
</body>
</html>
