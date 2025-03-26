<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
include 'db.php';

$id = $_SESSION['id'];

$sql = "SELECT * FROM user WHERE id='$id'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 50%;
            margin: auto;
            overflow: hidden;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
            text-align: center;
        }
        h1 {
            text-align: center;
        }
        p {
            text-align: left;
            margin-left: 20px;
        }
        p strong {
            font-weight: bold; 
        }
        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #4CAF50;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Profile</h1>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
        <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
        <p><strong>Student ID:</strong> <?php echo htmlspecialchars($user['id']); ?></p>
        <a href="edit_profile.php">Edit Profile</a>
    </div>
</body>
</html>

<?php mysqli_close($conn); ?>
