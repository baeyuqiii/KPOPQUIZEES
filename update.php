<?php
include("connect.php");

if (isset($_POST["submit"])) {
    $id = $_POST["questionid"];
    $question = $_POST["question"];
    $answer = $_POST["answer"];
    $cat = $_POST["category"];

    // For uploads photos
    $upload_dir = "uploads/";
    $q_images = $upload_dir . $_FILES["imageUpload"]["name"];
    $upload_file = $upload_dir . basename($_FILES["imageUpload"]["name"]);
    $imageType = strtolower(pathinfo($upload_file, PATHINFO_EXTENSION));
    $check = $_FILES["imageUpload"]["size"];
    $upload_ok = 1; // Initialize to 1

    // Check if it's an update or insert
    if (!empty($id)) {
        // It's an update
        $updateSql = "UPDATE questions SET q_images=?, question=?, answer=?, cat=? WHERE id=?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("ssssi", $q_images, $question, $answer, $cat, $id);

        if ($updateStmt->execute()) {
            echo "<script>alert('Question updated successfully')</script>";
        } else {
            echo "<script>alert('Error updating question: " . $updateStmt->error . "')</script>";
        }

        $updateStmt->close();
    } else {
        // It's an insert
        if (file_exists($upload_file)) {
            echo "<script>alert('The file already exists')</script>";
            $upload_ok = 0; // Set to 0 to indicate an issue
        } else {
            if ($check === 0) {
                echo '<script>alert("The photo size is 0 or the file is empty. Please select a valid photo.")</script>';
                $upload_ok = 0;
            } else {
                if (!in_array($imageType, ['jpg', 'jpeg', 'png', 'gif'])) {
                    echo '<script>alert("Please change the image format to jpg, jpeg, png, or gif.")</script>';
                    $upload_ok = 0;
                }
            }
        }

        if ($upload_ok === 1) { // Check for a successful check
            if ($question !== "") {
                move_uploaded_file($_FILES["imageUpload"]["tmp_name"], $upload_file);

                // Use prepared statement to prevent SQL injection
                $insertSql = "INSERT INTO questions (id, q_images, question, answer, cat) VALUES (?, ?, ?, ?, ?)";
                $insertStmt = $conn->prepare($insertSql);
                $insertStmt->bind_param("sssss", $id, $q_images, $question, $answer, $cat);

                if ($insertStmt->execute()) {
                    echo "<script>alert('Your question was added successfully')</script>";
                } else {
                    echo "<script>alert('Error: " . $insertStmt->error . "')</script>";
                }

                $insertStmt->close();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Question</title>
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

        #upload_container form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #upload_container form input,
        #upload_container form select {
            margin: 15px 0;
            padding: 10px;
            outline: none;
            background: white;
            border: 1px solid hotpink;
        }

        #upload_container form button {
            padding: 10px;
            background-color: coral;
            color: white;
            border: none;
            cursor: pointer;
        }

        #upload_container form button:hover {
            background-color: #ff6347;
        }

        .messages {
            text-align: center;
            font-size: 15px;
            margin-top: 10px;
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
        <h1>Update Question</h1>
    </header>

    <div class="container">
        <section id="upload_container">
            <form action="upload.php" method="POST" enctype="multipart/form-data">
                <input type="text" name="questionid" id="questionid" placeholder="Question ID" required>
                <input type="text" name="question" id="question" placeholder="Question" required>
                <input type="text" name="answer" id="answer" placeholder="Answer" required>
                <select name="category" id="category" required>
                    <option value="easy">Easy</option>
                    <option value="medium">Medium</option>
                    <option value="hard">Hard</option>
                    <option value="expert">Expert</option>
                </select>
                <input type="file" name="imageUpload" id="imageUpload" required hidden>
                <button id="choose" onclick="upload();">Choose Image</button>
                <input type="submit" value="Submit" name="submit">
            </form>
            <div class="messages">
                <p class="back-link"><a href="homeA.php">Back to Main Menu</a></p>
            </div>
        </section>

        <script>
            var questionid = document.getElementById("questionid");
            var question = document.getElementById("question");
            var answer = document.getElementById("answer");
            var choose = document.getElementById("choose");
            var uploadImage = document.getElementById("imageUpload");

            function upload() {
                uploadImage.click();
            }

            uploadImage.addEventListener("change", function () {
                var file = this.files[0];
                if (question.value == "") {
                    question.value = file.name;
                }
                choose.innerHTML = "You can change(" + file.name + ") picture";
            })
        </script>
    </div>
</body>

</html>