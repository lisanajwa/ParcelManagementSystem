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

<?php $currentPage = basename($_SERVER['PHP_SELF']); ?>

<div class="header">
    <h1>Student Portal</h1>
</div>
<div class="nav">
    <a href="studenthomepage.php" class="<?php echo ($currentPage == 'studenthomepage.php') ? 'active' : ''; ?>">Home</a>
    <a href="tracking_status.php" class="<?php echo ($currentPage == 'tracking_status.php') ? 'active' : ''; ?>">View Tracking Status</a>
    <a href="studentprofile.php" class="<?php echo ($currentPage == 'studentprofile.php') ? 'active' : ''; ?>">Profile</a>
    <a href="help_question.php" class="<?php echo ($currentPage == 'help_question.php') ? 'active' : ''; ?>">Help</a>
    <a href="logout.php">Logout</a>
</div>
