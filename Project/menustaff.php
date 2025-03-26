<style>
	body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
}

.header {
    background-color: #4CAF50;
    color: white;
    padding: 10px 0;
    text-align: center;
}

.nav {
    display: flex;
    justify-content: center;
    background-color: #333;
    margin: 0;
    padding: 0;
    list-style: none;
}

.nav a {
    padding: 14px 20px;
    display: block;
    color: white;
    text-align: center;
    text-decoration: none;
    margin: 0;
}

.nav a:hover {
    background-color: #ddd;
    color: black;
}

.nav a.active {
    background-color: #4CAF50;
    color: white;
    font-weight: bold;
}
</style>

<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<div class="header">
    <h1>Staff Portal</h1>
</div>
<div class="nav">
    <a href="staffhomepage.php" class="<?php echo ($currentPage == 'staffhomepage.php') ? 'active' : ''; ?>">Home</a>
    <a href="add_tracking.php" class="<?php echo ($currentPage == 'add_tracking.php') ? 'active' : ''; ?>">Add Tracking</a>
    <a href="view_reports.php" class="<?php echo ($currentPage == 'view_reports.php') ? 'active' : ''; ?>">View Reports</a>
    <a href="staffprofile.php" class="<?php echo ($currentPage == 'staffprofile.php') ? 'active' : ''; ?>">Profile</a>
    <a href="help_answer.php" class="<?php echo ($currentPage == 'help_answer.php') ? 'active' : ''; ?>">Help</a>
    <a href="logout.php">Logout</a>
</div>

