<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_account'])) {
        $userId = $_SESSION['id'];

        $deleteSql = "DELETE FROM user WHERE id = ?";
        $stmt = mysqli_prepare($conn, $deleteSql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $userId);
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_close($stmt);

                session_destroy();
                header("Location: login.php");
                exit();
            } else {
                $_SESSION['message'] = '<div class="error">Error deleting account: ' . mysqli_stmt_error($stmt) . '</div>';
            }
            mysqli_stmt_close($stmt);
        } else {
            $_SESSION['message'] = '<div class="error">Error preparing statement: ' . mysqli_error($conn) . '</div>';
        }
    } elseif (isset($_POST['cancel'])) {
        if ($_SESSION['role'] === 'staff') {
            header("Location: staffprofile.php");
        } elseif ($_SESSION['role'] === 'student') {
            header("Location: studentprofile.php");
        } else {
            $_SESSION['message'] = '<div class="error">Invalid user role.</div>';
        }
        exit();
    } else {
        $_SESSION['message'] = '<div class="error">Invalid request.</div>';
    }
}
header("Location: login.php");
exit();
?>
