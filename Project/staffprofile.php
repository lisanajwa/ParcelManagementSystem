<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

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
        .container {
            width: 50%;
            margin: auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
            text-align: center;
        }
        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
        }
        .button-container {
            display: flex;
            justify-content: center;
            gap: 20px; 
            margin-top: 20px;
        }
        .button {
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .edit-button {
            background-color: #4CAF50;
        }
        .edit-button:hover {
            background-color: #45a049;
        }
        .delete-button {
            background-color: #ff0000;
        }
        .delete-button:hover {
            background-color: #cc0000;
        }
    </style>
</head>
<body>
    <?php include 'menustaff.php'; ?>
    <div class="container">
        <h1>Profile</h1>
        <?php if (!empty($user['profile_picture']) && file_exists("uploads/" . $user['profile_picture'])): ?>
            <img src="uploads/<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Profile Picture" class="profile-picture">
        <?php else: ?>
            <img src="default_profile.png" alt="Default Profile" class="profile-picture">
        <?php endif; ?>

        <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
        <p><strong>Staff ID:</strong> <?php echo htmlspecialchars($user['id']); ?></p>
        <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>

        <div class="button-container">
            <a href="staff_edit_profile.php">
                <button class="button edit-button">Edit Profile</button>
            </a>
            <form action="delete_account.php" method="post">
                <button type="submit" class="button delete-button" name="delete_account">Delete Account</button>
            </form>
        </div>
    </div>
</body>
</html>

<?php mysqli_close($conn); ?>
