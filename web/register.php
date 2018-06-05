<?php
require_once(__DIR__ . "/../util/init.php");

//////////////////////////
// RE-DIRECT TO DASHBOARD IF LOGGED IN
//////////////////////////
if (isset($_SESSION['userId'])) {
  header("Location: dashboard.php");
  exit();
}

//////////////////////////
// NORMAL PAGE LOAD
//////////////////////////
if ($_SERVER["REQUEST_METHOD"] == "GET") {
  require_once(__DIR__ . "/../views/register.php");
}
//////////////////////////
// ATTEMPT REGISTER
//////////////////////////
else if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  // connect to database
  require_once(__DIR__ . "/../util/dbConnect.php");

  // get handle on parameters
  $email = $_POST['email'];
  $confirmEmail = $_POST['confirm-email'];
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirm-password'];
  // TODO: validate email
  // TODO: validate password
  // TODO: if validation passes, continue, else stay on register page with warnings

  // check to make sure email does not exist
  $emailQuery = $db->prepare("SELECT email FROM public.\"user\" WHERE email = ?;");
  $emailQuery->execute([$email]);
  $result = $emailQuery->fetch(PDO::FETCH_ASSOC);
  
  if ($result == true) {
    // if email is found, stay on register page with warnings
    $_SESSION['warning'] = "Email already associated with user.<br>";
    require_once(__DIR__ . "/../views/register.php");
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
    $success = $statement->execute([$email, $salt, $hashPass]);

    if (!$success) {
      // if problems with insert, stay on register page with warnings
      $_SESSION['warning'] = "Trouble creating new user";
      require_once(__DIR__ . "/../views/register.php");
    }
    else {
      // if we have made it this far, we have been successful
      
      // TODO: set session cookie
      $_SESSION['userId'] = intval($db->lastInsertId('user_id_seq'));

      // Create defaul categories
      $statement = $db->prepare(
        'INSERT INTO public.category
        ("name", userid)
        VALUES
       (\'Personal\', ?),(\'Business\', ?)');
      $success = $statement->execute([$_SESSION['userId'],$_SESSION['userId']]);
      // redirect to dashboard
      header("Location: dashboard.php");
      exit();
    }
  }
}