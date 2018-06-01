<div hidden class="add-vehicle pop-up">
  <header>
    <h2>Add Vehicle</h2>
  </header>
  <form id='add-vehicle-form' method='post'>
    <input class="toggle" type="checkbox"name="add-vehicle" checked hidden/>
    <select name='make' id='make' form='add-vehicle-form'>
      <?php require('makes.php')?>
    </select>
    <select disabled name='model' id="model" form='add-vehicle-form'>
      <option>Select Model</option></select>
    <select disabled name='year' id="year" form='add-vehicle-form'>
      <option>Select Year</option></select>
    <select name='color' id="color" form='add-vehicle-form'>
      <option>Select Color</option>
      <option value="White">White</optionvalue>
      <option value="Silver">Silver</option>
      <option value="Black">Black</option>
      <option value="Grey">Grey</option>
      <option value="Gold">Gold</option>
      <option value="Blue">Blue</option>
      <option value="Red">Red</option>
      <option value="Brown">Brown</option>
      <option value="Green">Green</option>
      <option value="Yellow">Yellow</option>
      <option value="Purple">Purple</option>
      <option value="Orange">Orange</option>
    </select>
    <input id="vin" type="text" name="vin" placeholder="VIN"/>
    <span>
      <input type="checkbox" name="preferred" id="preferred"/>
      <label for="preferred">Primary Vehicle</label>
    </span>
    <footer>
      <button class="btn cancel" type='button'>Cancel</button>
      <button class="btn submit">Add Vehicle</button>
    </footer>
  </form>
</div>