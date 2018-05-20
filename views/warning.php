<?php
echo "<div class='warning'>";
  echo $_SESSION['warning'];
  unset($_SESSION['warning']);
echo "</div>";