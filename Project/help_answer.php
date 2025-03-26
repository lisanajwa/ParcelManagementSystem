<?php
session_start();

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'staff') {
    header("Location: login.php");
    exit();
}

include 'db.php';

$sql = "SELECT hq.*, u.name as student_name, s.name as staff_name 
        FROM help_question hq
        LEFT JOIN user u ON hq.user_id = u.id
        LEFT JOIN user s ON hq.staff_id = s.id
        ORDER BY hq.answer IS NOT NULL, hq.timestamp DESC";

$result = mysqli_query($conn, $sql);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['question_id'], $_POST['answer']) && !empty($_POST['answer'])) {
        $questionId = mysqli_real_escape_string($conn, $_POST['question_id']);
        $answer = mysqli_real_escape_string($conn, $_POST['answer']);
        $staffId = $_SESSION['id'];

        $updateSql = "UPDATE help_question SET answer = ?, staff_id = ? WHERE question_id = ?";
        $stmt = mysqli_prepare($conn, $updateSql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sii", $answer, $staffId, $questionId);
            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['message'] = '<div class="success">Answer submitted successfully!</div>';
            } else {
                $_SESSION['message'] = '<div class="error">Error: ' . mysqli_stmt_error($stmt) . '</div>';
            }
            mysqli_stmt_close($stmt);
        } else {
            $_SESSION['message'] = '<div class="error">Error: ' . mysqli_error($conn) . '</div>';
        }

        header("Location: help_answer.php");
        exit();
    } else {
        $_SESSION['message'] = '<div class="error">Answer field cannot be empty.</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Answer Help Questions</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
            padding-top: 20px;
        }
        .question {
            background: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .question p {
            margin: 10px 0;
        }
        .answer-form {
            display: flex;
            flex-direction: column;
        }
        .answer-form label {
            margin-top: 10px;
        }
        .answer-form textarea {
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ddd;
            width: 100%;
        }
        .answer-form button {
            padding: 10px;
            margin-top: 10px;
            border: none;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        .answer-form button:hover {
            background-color: #45a049;
        }
        .success {
            color: green;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .error {
            color: red;
            font-weight: bold;
            margin-bottom: 20px;
        }
		a {
            display: center;
			text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #4CAF50;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<?php include 'menustaff.php'; ?>
<div class="container">
  <h1>Answer Help Questions</h1>
    <p>
        <?php
        if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        ?>
          
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="question">';
                echo '<p><strong>Question ID:</strong> ' . $row['question_id'] . '</p>';
                echo '<p><strong>Student Name:</strong> ' . htmlspecialchars($row['student_name']) . '</p>';
                echo '<p><strong>Question:</strong> ' . htmlspecialchars($row['question']) . '</p>';
                echo '<p><strong>Timestamp:</strong> ' . $row['timestamp'] . '</p>';
                
                if ($row['answer']) {
                    echo '<p><strong>Answer:</strong> ' . htmlspecialchars($row['answer']) . '</p>';
                    echo '<p><strong>Answered by:</strong> ' . htmlspecialchars($row['staff_name']) . '</p>';
                } else {
                    echo '<p><strong>Answer:</strong> <i>No answer yet</i></p>';
                    echo '<form class="answer-form" action="" method="post">';
                    echo '<input type="hidden" name="question_id" value="' . $row['question_id'] . '">';
                    echo '<label for="answer">Answer:</label>';
                    echo '<textarea id="answer" name="answer" rows="4" required></textarea>';
                    echo '<button type="submit">Submit Answer</button>';
                    echo '</form>';
                }
                echo '</div>';
            }
        } else {
            echo '<p>No questions found.</p>';
        }
        ?>
    </p>
</div>
</body>
</html>
