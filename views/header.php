<header>
  <h1>Mileage Tracker</h1>
  <?php
    if (isset($_SESSION['userId']))
    {
      echo "<a href='index.php?logout=true'>logout</a>";
    }
  ?>
</header>