<?php
session_start();
include 'db.php';

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$report_id = mysqli_real_escape_string($conn, $_POST['report_id']);
		$new_status = mysqli_real_escape_string($conn, $_POST['new_status']);

		$sql = "UPDATE tracking_status SET status = '$new_status' WHERE tracking_number = '$report_id'";

		if (mysqli_query($conn, $sql)) {
			$_SESSION['message'] = '<div class="success">Status updated successfully!</div>';
		} else {
			$_SESSION['message'] = '<div class="error">Error updating status: ' . mysqli_error($conn) . '</div>';
		}

		mysqli_close($conn);
		header("Location: view_reports.php");
		exit();
	} 
	else {
		$_SESSION['message'] = '<div class="error">Invalid request method.</div>';
		header("Location: view_reports.php");
		exit();
	}
?>
