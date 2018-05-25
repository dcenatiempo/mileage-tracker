<?php require_once("../views/head.php"); ?>
  <div class="auth register">
    <h2>Create Account</h2>
      <?php 
        if (isset($_SESSION['warning'])) {
          require("../views/warning.php");
          unset($_SESSION['warning']);
        }
      ?>
    <form method="post">
      <label for="email">Email</label>
      <input type="email" name="email" placeholder="enter email address"/>
      <label for="confirm-email">Confirm Email</label>
      <input type="email" name="confirm-email" placeholder="re-enter email address"/>
      <label for="password">Password</label>
      <input type="password" name="password"/>
      <label for="confirm-password">Confirm Password</label>
      <input type="password" name="confirm-password"/>
      <input type="submit" value="Register">
    </form>
  </div>
<?php require_once("../views/foot.php"); ?>