<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['role'] !== 'student') {
    $_SESSION['message'] = '<div class="error">Access denied. Only students can ask questions.</div>';
    header("Location: index.php");
    exit();
}

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ask_question'])) {
    $question = mysqli_real_escape_string($conn, $_POST['question']);
    $user_id = $_SESSION['id'];

    $sql = "INSERT INTO help_question (user_id, question) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "is", $user_id, $question);
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['message'] = '<div class="success">Your question has been submitted successfully.</div>';
    } else {
        $_SESSION['message'] = '<div class="error">Failed to submit your question.</div>';
    }
    mysqli_stmt_close($stmt);
}

$sql = "SELECT hq.*, u.name as student_name, s.name as staff_name 
        FROM help_question hq
        LEFT JOIN user u ON hq.user_id = u.id
        LEFT JOIN user s ON hq.staff_id = s.id
        WHERE hq.user_id = ? 
        ORDER BY hq.timestamp DESC";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $_SESSION['id']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Help Questions</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            max-width: 800px;
            margin: auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
        h1 {
            text-align: center;
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
        .answer {
            background: #f4f4f4;
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
            font-style: italic;
        }
        .message {
            text-align: center;
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
        }
        .success {
            background-color: #e0ffe0;
            border: 1px solid #b2d8b2;
        }
        .error {
            background-color: #ffe0e0;
            border: 1px solid #d8b2b2;
        }
        .form-container {
            margin-bottom: 20px;
        }
        .form-container textarea {
            width: 100%;
            height: 100px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            resize: vertical;
        }
        .form-container button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <?php include 'menustudent.php'; ?>
    <div class="container">
        <h1>Your Help Questions</h1>

        <?php
        if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        ?>

        <div class="form-container">
            <h2>Ask a New Question</h2>
            <form action="" method="POST">
                <textarea name="question" required placeholder="Enter your question here..."></textarea><br>
                <button type="submit" name="ask_question">Ask Question</button>
            </form>
        </div>

        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="question">';
                echo '<p><strong>Question ID:</strong> ' . $row['question_id'] . '</p>';
                echo '<p><strong>Question:</strong> ' . htmlspecialchars($row['question']) . '</p>';
                echo '<p><strong>Timestamp:</strong> ' . $row['timestamp'] . '</p>';

                if ($row['answer']) {
                    echo '<div class="answer">';
                    echo '<strong>Answer:</strong> ' . htmlspecialchars($row['answer']) . '<br>';
                    echo '<strong>Answered by:</strong> ' . htmlspecialchars($row['staff_name']);
                    echo '</div>';
                } else {
                    echo '<p><strong>Answer:</strong> <i>No answer yet</i></p>';
                }

                echo '</div>';
            }
        } else {
            echo '<p>No questions found.</p>';
        }

        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        ?>
    </div>
</body>
</html>
