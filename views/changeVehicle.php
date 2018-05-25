<div hidden class="change-vehicle pop-up">
  <header>
    <h2>Change Vehicle</h2>
  </header>
  <form id='change-vehicle-form' method='post'>
    <input type="checkbox"name="change-vehicle" checked hidden/>
    <?php include_once('changeVehicleList.php'); ?>
    <footer>
      <button class="btn cancel" type='button'>Cancel</button>
      <button class="btn save">Save</button>
    </footer>
  </form>
</div>