<?php require_once("../views/head.php"); ?>
  <div class="auth login">
    <h2>Sign In</h2>
    <?php 
      if (isset($_SESSION['warning'])) {
        require("../views/warning.php");
        unset($_SESSION['warning']);
      }
    ?>
    <form method="post">
      <label for="email">Email</label>
      <input type="email" name="email" placeholder="enter email address" required/>
      <label for="password">password</label>
      <input type="password" name="password" required/>
      <input type="submit" value="login">
    </form>
    <a href="./register.php">New User Registration</a>
  </div>
<?php require_once("../views/foot.php"); ?>