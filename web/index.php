<?php
require_once(__DIR__ . "/../util/init.php");

//////////////////////////
// LOGOUT HANDLER
//////////////////////////
if (isset($_GET['logout']) && $_GET['logout'] == 'true' ) {
  session_unset(); 
  session_destroy();
  header("Location: index.php");
  exit();
}

//////////////////////////
// NORMAL PAGE LOAD
//////////////////////////
if ($_SERVER["REQUEST_METHOD"] == "GET") {
  require_once(__DIR__ . "/../views/login.php");
}
//////////////////////////
// ATTEMPT LOGIN
//////////////////////////
else if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  // connect to database
  require_once(__DIR__ . "/../util/dbConnect.php");

  // get handle on parameters
  $email = $_POST['email'];
  $password = $_POST['password'];
  $salt;
  $id;
  // TODO: validate email
  // TODO: validate password
  // TODO: if validation passes, continue, else stay on register page with warnings

  // Check to see if user exist
  $userQuery = $db->prepare("SELECT hashpass, salt, id FROM public.\"user\" WHERE email = ?;");
  $userQuery->execute([$email]);
  $result = $userQuery->fetch(PDO::FETCH_ASSOC);
  
  if ($result == false) {
    // If no user found, stay on register page with warnings
    $_SESSION['warning'] = "User does not exist.<br>";
    require_once(__DIR__ . "/../views/login.php");
  }
  else {
    // If user found, check password
    $id = $result['id'];
    $salt = $result['salt'];

    // Generate hash
    $hashPass = hash('sha256', $salt . $password, false);

    if ($hashPass != $result['hashpass']) {
      // If hashes do not match print error
      $_SESSION['warning'] = "Wrong Password";
      require_once(__DIR__ . "/../views/login.php");
    }
    else {
      // If we have made it this far, we have been successful
      
      // TODO: set session cookie
      $_SESSION['userId'] = $id;

      // redirect to dashboard
      header("Location: dashboard.php");
      exit();
    }
  }
}