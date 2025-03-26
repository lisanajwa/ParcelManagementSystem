<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $id = $_POST['id'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); 
    $role = $_POST['role'];

    $query = "INSERT INTO user (id, name, phone, password, role) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssss", $id, $name, $phone, $password, $role);

    if ($stmt->execute()) {
        echo "New account created successfully. Redirecting to login page...";
        header("refresh:3;url=login.php");
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
