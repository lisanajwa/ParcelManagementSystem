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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);

    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $target_dir = "uploads/";
        $file_name = uniqid() . "_" . basename($_FILES["profile_picture"]["name"]);
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
            $sql_update = "UPDATE user SET name='$name', phone='$phone', profile_picture='$file_name' WHERE id='$id'";
        } else {
            $_SESSION['message'] = "Error uploading file.";
            header("Location: staffprofile.php");
            exit();
        }
    } else {
        $sql_update = "UPDATE user SET name='$name', phone='$phone' WHERE id='$id'";
    }
	
	if (mysqli_query($conn, $sql_update)) {
        header("Location: staffprofile.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input[type="text"], input[type="tel"], input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .button-group {
            display: flex;
            justify-content: space-between;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-bottom: 10px;
        }
        button:hover {
            background-color: #45a049;
        }
        .delete-button {
            background-color: #ff0000;
            border-radius: 4px;
            width: 100%;
        }
        .delete-button:hover {
            background-color: #cc0000;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Profile</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required><br>

            <label for="phone">Phone Number</label>
            <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required><br>

            <label for="profile_picture">Profile Picture</label>
            <input type="file" id="profile_picture" name="profile_picture"><br>

            <div class="button-group">
                <button type="submit">Save</button>
            </div>
        </form>
    </div>
</body>
</html>

<?php mysqli_close($conn); ?>
