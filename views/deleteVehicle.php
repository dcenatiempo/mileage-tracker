<div hidden class="delete-vehicle pop-up">
  <header>
    <h2>Delete Vehicle</h2>
  </header>


<form id='delete-vehicle-form' method='post'>
 <input type="checkbox"name="delete-vehicle" checked hidden/>
<?php
  echo "<input type='text' name='id' value='{$_SESSION['current-vehicle']['vehicleid']}' hidden />";
  echo "<p>";
    echo "Are you sure you want to delete your {$_SESSION['current-vehicle']['year']} {$_SESSION['current-vehicle']['color']} {$_SESSION['current-vehicle']['make']} {$_SESSION['current-vehicle']['model']} and all of its mileage records?";
?>
  </p>
  <p>This cannot be undone!</p>
  <footer>
    <button class='btn cancel' type='button'>Cancel</button>
    <button class='btn'>Delete Vehicle</button>
  </footer>
  </form>
</div>