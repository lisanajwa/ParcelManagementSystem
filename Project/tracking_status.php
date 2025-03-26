<?php
session_start();

include 'db.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

$user_id = $_SESSION['id'];
$sql = "SELECT * FROM tracking_status WHERE user_id = ? ORDER BY 
        CASE 
            WHEN status = 'Ready to pick-up' THEN 1
            WHEN status = 'Arrived' THEN 2
            WHEN status = 'Picked-up' THEN 3
            ELSE 4
        END";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
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
        .container {
            width: 90%;
            max-width: 800px;
            margin: auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
            color: black;
        }
        .status-ready {
            color: green;
        }
        .box {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
        .box-title {
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
	<?php include 'menustudent.php'; ?>
    <div class="container">
        <div class="box">
            <h1>Tracking Status</h1>
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tracking Number</th>
                        <th>Arrival Date</th>
                        <th>Arrival Time</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result && mysqli_num_rows($result) > 0) {
                        $i = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $i . "</td>";
                            echo "<td>" . htmlspecialchars($row['tracking_number']) . "</td>";
                            echo "<td>" . date("j M Y", strtotime($row['arrival_date'])) . "</td>";
                            echo "<td>" . date("g:i A", strtotime($row['arrival_time'])) . "</td>";
                            echo "<td class='" . ($row['status'] == 'Ready to pick-up' ? 'status-ready' : '') . "'>" . htmlspecialchars($row['status']) . "</td>";
                            echo "</tr>";
                            $i++;
                        }
                    } else {
                        echo "<tr><td colspan='5'>No tracking information available.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

<?php
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>

