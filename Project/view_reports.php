<?php
session_start();
include 'db.php';

header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Reports</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
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
        .update-status-form {
            display: inline-block;
        }
        .update-status-form select {
            padding: 5px;
        }
        .update-status-form button {
            padding: 5px 10px;
            cursor: pointer;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
        }
        .update-status-form button:hover {
            background-color: #45a049;
        }
        .notification-button {
            padding: 5px 10px;
            cursor: pointer;
            background-color: #2196F3;
            color: white;
            border: none;
            border-radius: 4px;
        }
        .notification-button:hover {
            background-color: #0b7dda;
        }
        .search-form {
            margin: 20px 0;
            text-align: center;
        }
        .search-form input[type="text"] {
            padding: 10px;
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .search-form button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .search-form button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <?php include 'menustaff.php'; ?>
    <div class="container">
        <h1>View Reports</h1>
        <div class="search-form">
            <form action="" method="get">
                <input type="text" name="search" placeholder="Enter Tracking Number" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <button type="submit">Search</button>
            </form>
        </div>

        <?php
        if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        ?>
        <table>
            <tr>
                <th>Tracking Number</th>
                <th>Arrival Date</th>
                <th>Arrival Time</th>
                <th>Status</th>
                <th>Assigned Student</th>
                <th>Action</th>
                <th>Send Notification</th>
            </tr>

            <?php
            $searchQuery = "";
            if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
                $searchTerm = mysqli_real_escape_string($conn, trim($_GET['search']));
                $searchQuery = "WHERE ts.tracking_number LIKE '%$searchTerm%'";
            }

            $sql = "SELECT ts.tracking_number, ts.arrival_date, ts.arrival_time, ts.status, ts.user_id, u.name AS student_name
                    FROM tracking_status ts
                    INNER JOIN user u ON ts.user_id = u.id
                    $searchQuery
					ORDER BY ts.arrival_date DESC, ts.arrival_time DESC";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["tracking_number"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["arrival_date"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["arrival_time"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["status"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["student_name"]) . "</td>";
                    echo "<td>";
                    echo "<form class='update-status-form' action='update_status.php' method='post'>";
                    echo "<input type='hidden' name='report_id' value='" . $row['tracking_number'] . "'>";
                    echo "<select name='new_status'>";
                    echo "<option value='Picked-up'>Picked-up</option>";
                    echo "<option value='Ready to Pick-up'>Ready to Pick-up</option>";
                    echo "<option value='Arrived'>Arrived</option>";
                    echo "</select>";
                    echo "<button type='submit'>Update Status</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "<td>";
                    echo "<button class='notification-button' onclick='simulateNotification(" . $row['user_id'] . ")'>Send Notification</button>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No records found</td></tr>";
            }

            mysqli_close($conn);
            ?>
        </table>
    </div>

    <script>
        function simulateNotification(userId) {
            alert("Notification sent to User ID: " + userId);
        }
    </script>
</body>
</html>
