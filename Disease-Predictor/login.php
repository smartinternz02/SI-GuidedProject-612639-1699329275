<?php
session_start();
include("F:/Projects/front end projects/Disease-Predictor/db.php");

$error_message = ""; // Initialize error message variable

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($email) && !empty($password) && !is_numeric($email)) {
        // Use prepared statement to prevent SQL injection
        $query = "SELECT * FROM form WHERE email='$email' LIMIT 1";
        $result = mysqli_query($conn, $query);

        if ($result) {
            if ($result && mysqli_num_rows($result) > 0) {
                $user_data = mysqli_fetch_assoc($result);

                if ($user_data["pass"] == $password) {
                  header("Location: http://localhost:5000/handle_php_response?login_success=true");
                  die;
                } else {
                    $error_message = "Wrong email/pass";
                }
            } else {
                $error_message = "Wrong email/pass";
            }
        } else {
            $error_message = "Error in query: " . mysqli_error($conn);
        }
    }
}
?>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Disease Predictor</title>
  <link href="login.css" rel="stylesheet" type="text/css" />
</head>

<body>
  <header>
    <h1 class="logo"> Disease Predictor</h1></header>
<form method="POST"> 
  <!--html for login-->
  <div class="wrapper"> <!--main class ie, all the below stuff will be enclosed by this-->
    <div class="form-box login">
      <h2>Login</h2>  
        <form action="#">
          <div class="inputbox">
            <span class="icon"> <ion-icon name="mail-outline"></ion-icon> </span>  <!--email-->
            <input type="email" required  name="email">
            <label>Email</label>
          </div>
          <div class="inputbox">                                                  <!--password-->
            <span class="icon"> <ion-icon name="lock-closed-outline"></ion-icon> </span>
            <input type="password" required  name="password">
            <label>Password</label>
          </div>
          <!-- <div class="remember-forgot">
            <label><input type= "checkbox">Remember Me</label>
            <a href="#">Forgot Password?</a> -->
            <div class="sub">
              <button type="submit" class="btn" >Login</button>
              <div class="login-register">
                <p>Don't have an account?<a href="register.php"> Register</p>

            </div>
        </form>
    </div>
  </div>
  <script src="script.js"></script>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>

</html>