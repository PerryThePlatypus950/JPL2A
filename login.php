
<?php

session_start();

// Check if form is submitted
if(isset($_POST['submit'])){
    // Include the connection file
    include 'connection.php';

    // Get and sanitize user inputs
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Hash the password (consider using stronger hashing methods)
    $hashed_password = md5($password);

    // Query to check user credentials
    $select = "SELECT * FROM user WHERE username = '$username' AND password = '$hashed_password'";
    $result = mysqli_query($conn, $select);

    if(mysqli_num_rows($result) == 1){
        // Fetch user details
        $row = mysqli_fetch_assoc($result);

        // Set session variables
        $_SESSION['username'] = $row['username'];
        $_SESSION['firstname'] = $row['firstname'];       header('Location:index.html');
      
    } else {
        // Invalid credentials
        echo 'Incorrect email or password!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="styles.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<style>
/* Style all input fields */
input {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  margin-top: 6px;
  margin-bottom: 16px;
}

/* Style the submit button */
input[type=submit] {
  background-color: #04AA6D;
  color: white;
}

/* Style the container for inputs */
.container {
  background-color: #f1f1f1;
  padding: 20px;
}


</style>
</head>
<body>
  <div class="wrapper">
    <form action="" method="post" onsubmit="return validateForm()">
      <h1>Login</h1>
      <div class="input-box">
        <input type="text" placeholder="Username"id="usrname"
         name="username" value="" >
        <i class='bx bxs-user'></i>
      </div>
      <div class="input-box">
        <input type="password" placeholder="Password"id="psw" name="password" value="" >
        <i class='bx bxs-lock-alt' ></i>
      </div>
      <button type="submit" name="submit" class="btn">Login</button>
      <div class="register-link">
        <p>Dont have an account? <a href="register.php">Register</a></p>
      </div>
    </form>
<script>
    function validateForm() {
      var username = document.getElementById("usrname").value;
      var password = document.getElementById("psw").value;

      if (username === "" || password === "") {
        alert("Please enter both username and password");
        return false;
      }

      // You can add more complex validation logic here if needed

      return true;
    }
  </script>    
  </div>
  
</body>
</html>
