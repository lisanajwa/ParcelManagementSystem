<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create New Account</title>
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
        .footer {
            text-align: center;
            margin-top: 20px;
        }
        .password-feedback {
            color: red;
            font-size: 14px;
            display: none;
        }
        .password-feedback.valid {
            color: green;
        }
        .eye-icon {
            cursor: pointer;
            position: absolute;
            right: 15px;
            top: 35px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Create New Account</h1>
        <form action="signup_process.php" method="post" onsubmit="return validatePassword()">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" required>

            <label for="phone">Phone Number</label>
            <input type="text" id="phone" name="phone" required>

            <div class="radio-group">
                <label><input type="radio" name="role" value="staff" required> Staff</label>
                <label><input type="radio" name="role" value="student" required> Student</label>
            </div>

            <label for="id">Staff/Student ID</label>
            <input type="text" id="id" name="id" required>

            <label for="password">Password</label>
            <div style="position: relative;">
                <input type="password" id="password" name="password" required pattern="(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}">
                <span id="eye-icon" class="eye-icon" onclick="togglePasswordVisibility()">👁️</span>
            </div>
            <div id="password-feedback" class="password-feedback">Password must be at least 8 characters long, contain at least 1 capital letter, and 1 number.</div>

            <button type="submit">Sign Up</button>
        </form>
        <div class="footer">
            <p>Already Registered? <a href="login.php">Login</a></p>
        </div>
    </div>

    <script>
        const passwordInput = document.getElementById('password');
        const feedback = document.getElementById('password-feedback');
        const eyeIcon = document.getElementById('eye-icon');

        passwordInput.addEventListener('input', () => {
            const passwordValue = passwordInput.value;
            const regex = /^(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/;

            if (regex.test(passwordValue)) {
                feedback.textContent = "Strong password!";
                feedback.classList.add("valid");
                feedback.classList.remove("invalid");
                feedback.style.display = "block";
                feedback.style.color = "green";
            } else {
                feedback.textContent = "Password must be at least 8 characters long, contain at least 1 capital letter, and 1 number.";
                feedback.classList.remove("valid");
                feedback.classList.add("invalid");
                feedback.style.display = "block";
                feedback.style.color = "red";
            }
        });

        function validatePassword() {
            const passwordValue = passwordInput.value;
            const regex = /^(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/;

            if (!regex.test(passwordValue)) {
                alert("Please enter a valid password that meets the required criteria.");
                return false;
            }

            return true;
        }

        function togglePasswordVisibility() {
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.textContent = "🙈"; 
            } else {
                passwordInput.type = "password";
                eyeIcon.textContent = "👁️"; 
            }
        }
    </script>
</body>
</html>
