<?php
require(__DIR__ . "/../util/init.php");

$url = $_SERVER['REQUEST_URI'];

if ($_SERVER["REQUEST_METHOD"] == "GET") {
  require(__DIR__ . "/../views/register.php");
}
else if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  // connect to database
  require(__DIR__ . "/../util/dbConnect.php");

  // get handle on parameters
  $email = $_POST['email'];
  $confirmEmail = $_POST['confirm-email'];
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirm-password'];
  // validate email
  // validate password
  // if validation passes, continue, else stay on register page with warnings

  // check to make sure email does not exist
  $emailQuery = $db->query("SELECT email FROM public.\"user\" WHERE (email = '{$email}');");
  $emailQuery->execute();
  $result = $emailQuery->fetch(PDO::FETCH_ASSOC);
  
  if ($result == true) {
    // if email is found, stay on register page with warnings
    $_SESSION['warning'] = "Email already associated with user.<br>";
    require(__DIR__ . "/../views/register.php");
  }
  else {
    // generate salt
    $salt = substr(bin2hex(random_bytes(8)), 0, 8);
    // generate hash
    $hashPass = hash('sha256', $salt . $password, false);
    
    // add email, salt, hash, to db
    $statement = $db->prepare(
      'INSERT INTO public."user"
      (email, salt, hashpass)
      VALUES
     (?, ?, ?)');
    $success = $statement->execute(array($email, $salt, $hashPass));

    if (!$success) {
      // if problems with insert, stay on register page with warnings
      $_SESSION['warning'] = "Trouble creating new user";
      require(__DIR__ . "/../views/register.php");
    }
    else {
      // if we have made it this far, we have been successful
      
      // TODO: set session cookie
      $_SESSION['userId'] = $db->lastInsertId('user_id_seq');

      // redirect to dashboard
      header("Location: dashboard.php");
      exit();
    }
  }
}