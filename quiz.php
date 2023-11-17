<?php
require_once("connect.php");
require_once("function.php");
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/quiz.css">
</head>

<body>
    <section class="main-section">

        <nav class="navbar navbar-expand-lg bg-body-tertiary bg-dark" data-bs-theme="dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="dashboard.php">Quiz</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="dashboard.php">Dashboard</a>
                        </li>
                    </ul>

                </div>
            </div>
        </nav>

        <form action="checkAnswer.php" method="post">
            <?php
            $selectedCategory = $_SESSION['selected_category'];

            // Use prepared statement to prevent SQL injection
            $questionSql = "SELECT * FROM questions WHERE cat = ?";

            $questionStmt = mysqli_prepare($conn, $questionSql);
            mysqli_stmt_bind_param($questionStmt, "s", $selectedCategory);
            mysqli_stmt_execute($questionStmt);
            $questionResult = mysqli_stmt_get_result($questionStmt);

            while ($row = mysqli_fetch_assoc($questionResult)) {
                $imageData = $row['q_images'];
                $questionId = $row['id'];  // Get the id of the current question
            ?>

                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card my-2 p-3">
                                <div class="card-body">
                                    <h5 class="card-title py-2"><?php echo $row["question"]; ?> </h5>

                                    <?php
                                    // Display the image if image data is available
                                    if ($imageData) {
                                        echo '<img src="' . $row["q_images"] . '" alt="" style="max-width: 300px; height: auto;">';
                                    }
                                    ?>

                                    <?php
                                    // Use prepared statement to fetch options based on category and question id
                                    $optionsSql = "SELECT * FROM answers WHERE cat = ? AND id = ?";
                                    $optionsStmt = mysqli_prepare($conn, $optionsSql);
                                    mysqli_stmt_bind_param($optionsStmt, "ss", $selectedCategory, $questionId);
                                    mysqli_stmt_execute($optionsStmt);
                                    $optionsResult = mysqli_stmt_get_result($optionsStmt);

                                    // Check if there are options for the given category and question id
                                    if (mysqli_num_rows($optionsResult) > 0) {
                                        while ($optionsRow = mysqli_fetch_assoc($optionsResult)) {
                                    ?>
                                            <div class="form-check">
                                                <input type="radio" class="form-check-input" name="checkanswer[<?php echo $optionsRow['id']; ?>]" value="<?php echo $optionsRow['bil']; ?>">
                                                <?php echo $optionsRow['answer']; ?>
                                            </div>
                                    <?php
                                        }
                                    } else {
                                        echo "<p>No options available for this question.</p>";
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <div class="col-md-8 mb-5">
                <button type="submit" class="btn btn-success" name="answer-submit">Submit Answers</button>
            </div>
        </form>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>