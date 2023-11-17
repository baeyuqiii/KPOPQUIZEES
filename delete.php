<?php
include("connect.php");


if (isset($_POST["delete"])) {
    $id = $_POST["questionid"];

    // Delete related records in the answers table
    $deleteAnswersSql = "DELETE FROM answers WHERE id=?";
    $deleteAnswersStmt = $conn->prepare($deleteAnswersSql);
    $deleteAnswersStmt->bind_param("s", $id);

    if ($deleteAnswersStmt->execute()) {
        // Now that related answers are deleted, delete the question
        $deleteQuestionSql = "DELETE FROM questions WHERE id=?";
        $deleteQuestionStmt = $conn->prepare($deleteQuestionSql);
        $deleteQuestionStmt->bind_param("s", $id);

        if ($deleteQuestionStmt->execute()) {
            $deleteMessage = "Question and related answers deleted successfully";
        } else {
            $deleteMessage = "Error deleting question: " . $deleteQuestionStmt->error;
        }

        $deleteQuestionStmt->close();
    } else {
        $deleteMessage = "Error deleting answers: " . $deleteAnswersStmt->error;
    }

    $deleteAnswersStmt->close();
}

// Fetch questions for display
$selectSql = "SELECT * FROM questions";
$selectResult = $conn->query($selectSql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Page</title>
    <link rel="stylesheet" href="product.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .page-header {
            background-color: black;
            color: white;
            text-align: center;
            padding: 10px;
            margin-bottom: 10px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 25px;
            background-color: #fff;
            border-radius: 5px;
            text-align: center;
        }

        #delete_container form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #delete_container form select {
            margin: 15px 0;
            padding: 10px;
            outline: none;
            background: white;
            border: 1px solid hotpink;
        }

        #delete_container form button {
            padding: 10px;
            background-color: coral;
            color: white;
            border: none;
            cursor: pointer;
        }

        #delete_container form button:hover {
            background-color: #ff6347;
        }

        .messages {
            text-align: center;
            font-size: 15px;
            margin-top: 10px;
            color: green;
        }

        .back-link {
            display: block;
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>

<body>

    <header class="page-header">
        <h1>Delete Question</h1>
    </header>

    <div class="container">
        <section id="delete_container">
            <form action="delete.php" method="POST">
                <select name="questionid" id="questionid" required>
                    <?php
                    while ($row = $selectResult->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . $row['question'] . "</option>";
                    }
                    ?>
                </select>
                <button type="submit" name="delete">Delete Question</button>
            </form>
            <?php
            if (isset($deleteMessage)) {
                echo "<div class='messages'>$deleteMessage</div>";
            }
            ?>
            <p class="back-link"><a href="home.txt.php">Back to Main Menu</a></p>
        </section>
    </div>
</body>

</html>