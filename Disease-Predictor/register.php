<?php
session_start();
include("C:/xampp/htdocs/login/db.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($email) && !empty($password) && !is_numeric($email)) {
        // Use prepared statement to prevent SQL injection
        $query = "INSERT INTO form (email, pass) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $query);

        if ($stmt) {
            // Bind parameters
            mysqli_stmt_bind_param($stmt, "ss", $email, $password);

            // Execute the statement
            try {
                mysqli_stmt_execute($stmt);
                echo "<script type='text/javascript'>alert('Your registration is complete. Please go to the login page.')</script>";
               
            } catch (mysqli_sql_exception $e) {
                // Check if the error is due to a duplicate entry
                if ($e->getCode() == 1062) {
                    echo "<script type='text/javascript'>alert('Email already exists. Please use a different email.')</script>";
                } else {
                    echo "<script type='text/javascript'>alert('Failed to execute statement.')</script>";
                }
            }

            // Close the statement
            mysqli_stmt_close($stmt);
        } else {
            echo "<script type='text/javascript'>alert('Failed to prepare statement.')</script>";
        }
    } else {
        echo "<script type='text/javascript'>alert('Enter valid details.')</script>";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Disease Predictor</title>
  <link href="login.css" rel="stylesheet" type="text/css" />
</head>

<body>
  <header>
    <h1>Disease Predictor</h1>
    
  </header>
  <!--html for login-->
  <form method="post">
  <div class="wrapper">
    <!--main class ie, all the below stuff will be enclosed by this-->
    <div class="form-box register">
      <h2>Register</h2>
      <form action="#">
        <div class="inputbox">
          <span class="icon">
            <ion-icon name="mail-outline"></ion-icon>
          </span>
          <!--email-->
          <input type="email" required name="email">
          <label>Email</label>
        </div>
        <div class="inputbox">
          <!--password-->
          <span class="icon">
            <ion-icon name="lock-closed-outline"></ion-icon>
          </span>
          <input type="password" required name="password">
          <label>Password</label>
        </div>
          <!-- <label><input type="checkbox">I agree to T&C</label> -->
          <div class="sub">
            <button type="submit" class="btn">Register</button>
            <div class="login-register">
              <p>Have an account?<a href="login.php"> Login</p>

            </div>
      </form>
    </div>
  </div>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>

</html>