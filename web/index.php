<?php
require(__DIR__ . "/../util/init.php");

$url = $_SERVER['REQUEST_URI'];

if (isset($_GET['logout']) && $_GET['logout'] == 'true' ) {
  unset($_SESSION['userId']);
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
  require(__DIR__ . "/../views/login.php");
}
else if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  // connect to database
  require(__DIR__ . "/../util/dbConnect.php");

  // get handle on parameters
  $email = $_POST['email'];
  $password = $_POST['password'];
  $salt;
  $id;
  // validate email
  // validate password
  // if validation passes, continue, else stay on register page with warnings

  // check to see if user exist
  $userQuery = $db->query("SELECT hashpass, salt, id FROM public.\"user\" WHERE (email = '{$email}');");
  $userQuery->execute();
  $result = $userQuery->fetch(PDO::FETCH_ASSOC);
  
  if ($result == false) {
    // if no user found, stay on register page with warnings
    $_SESSION['warning'] = "User does not exist.<br>";
    require(__DIR__ . "/../views/login.php");
  }
  else {
    // if user found, check password
    $id = $result['id'];
    $salt = $result['salt'];

    // generate hash
    $hashPass = hash('sha256', $salt . $password, false);

    if ($hashPass != $result['hashpass']) {
      // if hashes do not match print error
      $_SESSION['warning'] = "Wrong Password";
      require(__DIR__ . "/../views/login.php");
    }
    else {
      // if we have made it this far, we have been successful
      
      // TODO: set session cookie
      $_SESSION['userId'] = $id;

      // redirect to dashboard
      header("Location: dashboard.php");
      exit();
    }
  }
}