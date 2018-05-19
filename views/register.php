<?php require("../views/head.php"); ?>
  <div class="auth register">
    <h2>Create Account</h2>
    <form>
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
<?php require("../views/foot.php"); ?>