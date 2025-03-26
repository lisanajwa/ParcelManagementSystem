<?php
session_start();

include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $password = $_POST['password'];
    $role = $_POST['role']; 

    $query = "SELECT * FROM user WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $hashedPassword = $user['password'];

        if (password_verify($password, $hashedPassword)) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] === 'staff') {
                header("Location: staffhomepage.php");
                exit();
            } else {
                header("Location: studenthomepage.php");
                exit();
            }
        } else {
            $_SESSION['error'] = "Invalid password.";
            $_SESSION['id'] = $id; 
            header("Location: login.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "No user found with this ID.";
        header("Location: login.php");
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: login.php");
    exit();
}
?>
