<?php
require_once("connect.php");
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quiz Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
       <style>
        .navbar-nav .nav-item {
            margin-right: 15px; 
        }
    </style>
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
              <a class="nav-link active" aria-current="page" href="#">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="upload.php">Insert Question</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="update.php">Update Question</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="delete.php">Delete Question</a>
            </li>
          </ul>

          <div class="d-flex">
            <a class="btn btn-danger" href="adminLogin.html">Logout</a>
          </div>
        </div>
      </div>
    </nav>


    <div class="container">

      <?php if (isset($_SESSION['msg'])) : ?>
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
          <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header <?php echo $_SESSION['class']; ?>">
              <strong class="me-auto">Success</strong>
              <button type="button" class="btn-close text-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
              <?php
              $message = $_SESSION['msg'];
              unset($_SESSION['msg']);
              echo $message;
              ?>
            </div>
          </div>
        </div>
      <?php endif; ?>

      <div class="row justify-content-center">
        <h2 class="pt-4">Welcome to Admin KpopQuizees!!</h2>
  </section>
<?php
    include("connect.php");
    $username = "julie";
    ?>

    <div class="profile">
    <div class="profile-image">
    </div>
    <div class="profile-info">
        <p class="profile-username"><strong><?php echo $username; ?></strong></p>
        <p class="profile-description">Administrator</p>
    </div>
</div>

    
    <div class="header2">
        <div class="content-wrapper">
            
            <div class="content">
                <p style="font-family: georgia; font-size: 53px; color: black; text-align: center;"><strong>Welcome To Admin Site</strong></p>
                <p style="font-family: georgia; font-size: 30px; color: black;">KpopQuizees</p>
                <br>
                <br>
                
            </div>
        </div>
    </div>
</body>

</html>

<style>
    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    body {
        background: white;
        background-size: cover;
        background-position: center;
        font-family: sans-serif;
        margin: 0;
    }

    .header {
        background:black;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 30px 40px;
    }

    .profile {
    display: flex;
    align-items: center;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 10px;
    background-color: #f9f9f9;
}

.profile-image {
    margin-right: 20px;
}

.profile-image img {
    width: 140px;
    height: 130px;
    border-radius: 50%;
}

.profile-info {
    text-align: left;
}

.profile-username {
    font-size: 24px;
    color: black;
    margin-bottom: 5px;
}

.profile-description {
    font-size: 18px;
    color: #555;
}


    .header2 {
        display: flex;
        align-items: center;
        padding: 20px;
        justify-content: space-between;
    }

    .content-wrapper {
        display: flex;
        align-items: center;
    }

    .content {
        flex: 1;
    }

    .btn-wrapper {
        text-align: center;
        margin-top: 20px;
        flex: 1;
    }

    .btn {
        background-color: maroon;
        color: black;
        border-radius: 5px;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        font-family: "Times New Roman";
        font-size: 20px;
        cursor: pointer;
        display: block;
    }

    .btn:hover {
        color: lightgrey;
        border-color: lightgrey;
        transition: 0.1s;
    }

    .container {
        width: 1000px;
        margin: 0 auto;
        background: white;
        margin-left: 20px;
        padding: 40px;
        border: 3px solid black;
        border-radius: 10px;
        box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.6);
    }
</style>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>