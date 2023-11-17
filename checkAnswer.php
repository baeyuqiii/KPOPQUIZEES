<?php
require_once("connect.php");
session_start();

if (isset($_POST['answer-submit'])) {

    // Checking if our Questions are even attempted
    if (!empty($_POST['checkanswer'])) {

        // Set a flag for correct answers
        $correctAnswers = 0;
        $selected = $_POST['checkanswer'];

        // Fetch correct answers from the database based on the selected category
        $sql = "SELECT id, bil FROM questions WHERE cat = ?";
        $stmt = mysqli_prepare($conn, $sql);
        $selectedCategory = $_SESSION['selected_category'];
        mysqli_stmt_bind_param($stmt, "s", $selectedCategory);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // Compare selected answers with correct answers
        while ($row = mysqli_fetch_assoc($result)) {
            $questionId = $row['id'];

            // Fetch the correct bil for the current question from the questions table
            $correctBil = $row['bil'];

            // Check if the question ID exists in the selected answers array
            if (isset($selected[$questionId])) {
                $selectedBil = $selected[$questionId];

                // Compare the selected bil with the correct bil
                if ($correctBil == $selectedBil) {
                    $correctAnswers++;
                }
            }
        }

        // Stored our score and attempted question value in session to be used on Result page
        $_SESSION['attempted'] = count($_POST['checkanswer']);
        $_SESSION['score'] = $correctAnswers;

        header("Location: result.php");
        exit();
    } else {
        // If Question not attempted set these variable like this
        $_SESSION['attempted'] = 0;
        $_SESSION['score'] = 0;
        header("Location: result.php");
        exit();
    }
}
?>
