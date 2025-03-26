<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 90%;
            max-width: 600px;
            margin: auto;
            overflow: hidden;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
        h1 {
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-top: 15px;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .radio-group {
            margin: 10px 0;
            text-align: center;
        }
        .radio-group label {
            display: inline-block;
            margin-right: 10px;
        }
        button {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 20px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            margin-top: 10px;
            text-align: center;
        }
		.footer {
            text-align: center;
            margin-top: 20px;
        }
    </style>
    <script>
        function updateLabel(role) {
            var idLabel = document.getElementById("idLabel");
            if (role === 'staff') {
                idLabel.textContent = "Staff ID";
                document.getElementById("loginForm").action = "login_process.php?role=staff";
            } else if (role === 'student') {
                idLabel.textContent = "Student ID";
                document.getElementById("loginForm").action = "login_process.php?role=student"; 
            }
        }

        window.onload = function() {
            updateLabel('staff');
        };
    </script>
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <?php
        session_start();
        $error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
        unset($_SESSION['error']); 
        ?>
        <?php if (!empty($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form id="loginForm" action="login_process.php" method="post"> 
            <div class="radio-group">
                <label><input type="radio" name="role" value="staff" onclick="updateLabel('staff')" checked required> Staff</label>
                <label><input type="radio" name="role" value="student" onclick="updateLabel('student')" required> Student</label>
            </div>
            
            <label id="idLabel" for="id">Staff/Student ID</label>
            <input type="text" id="id" name="id" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>
		<div class="footer">
            <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
        </div>
    </div>
</body>
</html>
