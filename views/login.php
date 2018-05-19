<?php require("../views/head.php"); ?>
  <div class="auth login">
    <h2>Sign In</h2>
    <form>
      <label for="email">Email</label>
      <input type="email" name="email" placeholder="enter email address"/>
      <label for="password">password</label>
      <input type="password" name="password"/>
      <input type="submit" value="login">
    </form>
    <a href="./register.php">New User Registration</a>
  </div>
<?php require("../views/foot.php"); ?>