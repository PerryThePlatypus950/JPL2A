<?php

@include 'connection.php';

if(isset($_POST['submit'])){
  
   $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
   $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
   $username = mysqli_real_escape_string($conn, $_POST['username']);
   $password = md5($_POST['password']);

	

   
      function validate($data){
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
   }
      $username = validate($_POST['username']);
      $password = validate($_POST['password']);

      $uppercase = preg_match("#[A-Z]+#", $password);
      $lowercase = preg_match("#[a-z]+#", $password);
      $number = preg_match("#[0-9]+#", $password);
      $specialChars = preg_match("#[^/w]+#", $password);

      
      $user_data = 'username='. $username. '&password='.$password;

      if (empty($username)) {
         header("Location: Register.php?error=User Name is required&$user_data");
          exit();
      }else if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password)<8){
        header("Location:Register.php?error=Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character&$user_data");
          exit();
      }
      else{
       $password = md5($password);

  

   $select = " SELECT * FROM user WHERE username = '$username' && password = '$password' ";

   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){

      $error[] = 'user already exist!';


      }else{
         $insert = "INSERT INTO `user` (`firstname`,`lastname`,`username` , `password`) VALUES ('$firstname','$lastname','$username','$password')";
         mysqli_query($conn, $insert);

         
         
         
       
         header("Location:login.php");
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
   <title>Register Form</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="styles.css">
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

/* The message box is shown when the user clicks on the password field */
#message {
  display:none;
  background: white;
  color: #000;
  position: relative;
  padding: 20px;
  margin-top: 10px;
  border-radius: 12px;
  
}

#message p {
  padding: 10px 35px;
  font-size: 10px;
}

/* Add a green text color and a checkmark when the requirements are right */
.valid {
  color: green;
}

.valid:before {
  position: relative;
  left: -35px;
  content: "✔";
}

/* Add a red text color and an "x" when the requirements are wrong */
.invalid {
  color: red;
}

.invalid:before {
  position: relative;
  left: -35px;
  content: "✖";
}
</style>
</head>
<body>
   
<div class="wrapper">
    <form action="" method="post">
      <h1>Sign-Up</h1>
      <?php if (isset($_GET['error'])){ ?>
  <div class="alert alert-danger" role="alert">
            <?php echo $_GET['error']; ?>
  </div>
  <?php } ?>

  <?php if (isset($_GET['success'])){ ?>
  <div class="alert alert-danger" role="alert">
            <?php echo $_GET['success']; ?>
  </div>
  <?php } ?>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
      <div class="input-box">
        <input type="text" name="firstname" placeholder="First Name" required>
      <i class='bx bxs-user'></i>
      </div>
      <div class="input-box">                    
        <input type="text" name="lastname" placeholder="Last Name" required>
        <i class='bx bxs-user'></i>
      </div>
      <div class="input-box">
        <input type="text" placeholder="Username"id="usrname" name="username" required>
        <i class='bx bxs-user'></i>
      </div>
      <div class="input-box">
        <input type="password" placeholder="Password"id="psw" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
        <i class='bx bxs-lock-alt' ></i>
      </div>
      <button type="submit" class="btn" name="submit">Submit</button>
      <div class="register-link">
        <p>Have an account? <a href="login.php">Log-in instead? </a></p>
      </div>
    </form>
<div class="msgbox" id="message">
  <h3>Password must contain the following:</h3>
  <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
  <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
  <p id="number" class="invalid">A <b>number</b></p>
  <p id="length" class="invalid">Minimum <b>8 characters</b></p>
</div>	
<script>
var myInput = document.getElementById("psw");
var letter = document.getElementById("letter");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var length = document.getElementById("length");

// When the user clicks on the password field, show the message box
myInput.onfocus = function() {
  document.getElementById("message").style.display = "block";
}

// When the user clicks outside of the password field, hide the message box
myInput.onblur = function() {
  document.getElementById("message").style.display = "none";
}

// When the user starts to type something inside the password field
myInput.onkeyup = function() {
  // Validate lowercase letters
  var lowerCaseLetters = /[a-z]/g;
  if(myInput.value.match(lowerCaseLetters)) {  
    letter.classList.remove("invalid");
    letter.classList.add("valid");
  } else {
    letter.classList.remove("valid");
    letter.classList.add("invalid");
  }
  
  // Validate capital letters
  var upperCaseLetters = /[A-Z]/g;
  if(myInput.value.match(upperCaseLetters)) {  
    capital.classList.remove("invalid");
    capital.classList.add("valid");
  } else {
    capital.classList.remove("valid");
    capital.classList.add("invalid");
  }

  // Validate numbers
  var numbers = /[0-9]/g;
  if(myInput.value.match(numbers)) {  
    number.classList.remove("invalid");
    number.classList.add("valid");
  } else {
    number.classList.remove("valid");
    number.classList.add("invalid");
  }
  
  // Validate length
  if(myInput.value.length >= 8) {
    length.classList.remove("invalid");
    length.classList.add("valid");
  } else {
    length.classList.remove("valid");
    length.classList.add("invalid");
  }
}
</script>
  </div>       
</body>
</html>