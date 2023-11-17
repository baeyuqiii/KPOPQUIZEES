<?php
include("connect.php");

$message = ""; // Initialize an empty message

if (isset($_POST["submit"])) {
    $question_id = $_POST["id"];

    // Loop through four sets of answers
    for ($i = 1; $i <= 4; $i++) {
        $answer_id = $_POST["bil" . $i];
        $answer_text = $_POST["answer" . $i];
        $category = $_POST["cat"];

        // Use prepared statement to prevent SQL injection
        $sql = "INSERT INTO answers (bil, answer, cat, id) VALUES (?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $answer_id, $answer_text, $category, $question_id);

        if ($stmt->execute()) {
            $message = "Your answers were inserted successfully";
        } else {
            $message = "Error: " . $stmt->error;
            break; // If an error occurs, break out of the loop
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Answer</title>
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
        }

        .container {
            align-items: center;
            max-width: 420px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"],
        select {
            width: 400px;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: deeppink;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: darkorange;
        }

        .pop-up {
            border: 1px solid green;
            padding: 10px;
            margin-top: 10px;
            background-color: lightgreen;
        }

        .messages {
            text-align: center;
            margin-top: 10px;
        }

        .back-link {
            display: block;
            margin-top: 20px;
            text-align: center;
      </style>
</head>

<body>

    <header class="page-header">
        <h1>Insert Answer</h1>
    </header>

    <div class="container">
        <?php
        // Display the message only if it is not empty
        if (!empty($message)) {
            echo '<div class="pop-up">' . $message . '</div>';
        }
        ?>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label for="id">Question ID:</label>
            <input type="text" name="id" id="id" placeholder="Question ID" required>

            <?php
            // Create four sets of input fields for answer_id and answer_text
            for ($i = 1; $i <= 4; $i++) {
                echo '<label for="bil' . $i . '">Answer ID ' . $i . ':</label>';
                echo '<input type="text" name="bil' . $i . '" id="bil' . $i . '" placeholder="Answer ID ' . $i . '" required>';

                echo '<label for="answer' . $i . '">Answer ' . $i . ':</label>';
                echo '<input type="text" name="answer' . $i . '" id="answer' . $i . '" placeholder="Answer ' . $i . '" required>';
            }
            ?>

            <label for="cat">Category:</label>
            <select name="cat" id="cat" required>
                <option value="easy">Easy</option>
                <option value="medium">Medium</option>
                <option value="hard">Hard</option>
                <option value="expert">Expert</option>
            </select>

            <input type="submit" value="Submit" name="submit">
        </form>

        <div class="messages">
            <p class="back-link"><a href="home.txt.php">Back to Main Menu</a></p>
        </div>
    </div>
</body>

</html>