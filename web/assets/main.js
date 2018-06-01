console.log("Hello World");


////////////////////////////
// Change Vehicle Modal
///////////////////////////
document.addEventListener('DOMContentLoaded', ()=>{

  var changeVehicleModal = document.querySelector('div.change-vehicle');
  if (changeVehicleModal) {

    let saveBtn = changeVehicleModal.querySelector('button.cancel');
    saveBtn.addEventListener('click', saveChangeVehicleModal);

    let cancelBtn = changeVehicleModal.querySelector('button.cancel');
    cancelBtn.addEventListener('click', closeChangeVehicleModal);
  }

  var changeVehicleModalBtn = document.querySelector('button.change-vehicle');
  if (changeVehicleModalBtn) {
    changeVehicleModalBtn.addEventListener('click', openChangeVehicleModal);
  }

});

function openChangeVehicleModal(e) {
  var changeVehicleModal = document.querySelector('div.change-vehicle');
  changeVehicleModal.removeAttribute('hidden');
}

function saveChangeVehicleModal(e) {
  var changeVehicleModal = document.querySelector('div.change-vehicle');
  changeVehicleModal.removeAttribute('hidden');
}

function closeChangeVehicleModal (e) {
  var changeVehicleModal = document.querySelector('div.change-vehicle');
  changeVehicleModal.setAttribute('hidden', '');

}

////////////////////////////
// "Add Vehicle" Modal
///////////////////////////
document.addEventListener('DOMContentLoaded', ()=>{

  var addVehicleModal = document.querySelector('div.add-vehicle');
  if (addVehicleModal) {

    let make = addVehicleModal.querySelector('#make');
    make.addEventListener('change', fetchModel);

    let model = addVehicleModal.querySelector('#model');
    model.addEventListener('change', fetchYear);

    let cancelBtn = addVehicleModal.querySelector('button.cancel');
    cancelBtn.addEventListener('click', closeAddVehicleModal);
  }

  var addVehicleModalBtn = document.querySelector('button.add-vehicle');
  if (addVehicleModalBtn) {
    addVehicleModalBtn.addEventListener('click', openAddVehicleModal);
  }

});

function openAddVehicleModal(e) {
  var addVehicleModal = document.querySelector('div.add-vehicle');

  // Update to "Add Vehicle"
  let header = addVehicleModal.querySelector('header h2');
  let submit = addVehicleModal.querySelector('footer button.submit');
  let toggle = addVehicleModal.querySelector('input.toggle');
  header.innerText = "Add Vehicle";
  submit.innerText = "Add Vehicle";
  toggle.name = "add-vehicle";

  addVehicleModal.removeAttribute('hidden');
}

function closeAddVehicleModal (e) {
  var addVehicleModal = document.querySelector('div.add-vehicle');
  addVehicleModal.setAttribute('hidden', '');
  clearList("model");
  clearList("year");
  let make = addVehicleModal.querySelector('#make');
  make.value = '';
  let color = addVehicleModal.querySelector('#color');
  color.value = 'Select Color';
  let vin = addVehicleModal.querySelector('#vin');
  vin.value = '';
  let preferred = addVehicleModal.querySelector('#preferred');
  preferred.checked = false;
}

function fetchModel(e) {
  let make = e.target.value;
  clearList("model");
  clearList("year");

  fetch(`./api.php?make=${make}`)
  .then( resp => {
    return resp.json();
  }).then ( models => {
    listOptions(models, "model");
  });

}

function fetchYear(e) {
  let make = document.querySelector('#make').value;;
  let model = e.target.value;
  clearList("year");

  fetch(`./api.php?make=${make}&model=${model}`)
  .then( resp => {
    return resp.json();
  }).then ( years => {
    listOptions(years, "year");
  });
}

function listOptions(itemArray, itemName) {
  var selectTag = document.querySelector(`#${itemName}`);
  selectTag.removeAttribute('disabled');
  
  // List all selectItems for particular make
  itemArray.forEach(value => {
    var optionTag = document.createElement('option');
    var textNode = document.createTextNode(value);
    optionTag.setAttribute('value', value);
    optionTag.appendChild(textNode);
    selectTag.appendChild(optionTag)
  });
}

function clearList(item) {
  var list = document.querySelector(`#${item}`);
  list.innerHTML = "";
  list.setAttribute('disabled', true);

  var option = document.createElement('option');
  var text = document.createTextNode("Select "+ capitalizeFirstLetter(item));
  option.setAttribute('value', '');
  option.appendChild(text);
  list.appendChild(option);
}

function capitalizeFirstLetter(string) {
  return string.charAt(0).toUpperCase() + string.slice(1);
}


////////////////////////////
// "Add Mileage" Button
///////////////////////////
document.addEventListener('DOMContentLoaded', ()=>{

  var addMileageBtn = document.querySelector('button.add-mileage');
  if (addMileageBtn) {

    let mileageTable = document.querySelector('table.mileage');
    let date = mileageTable.querySelector('input[date]');
    let start = mileageTable.querySelector('input[start]');
    let end = mileageTable.querySelector('input[end]');
    let total = mileageTable.querySelector('span[total]');
    let category = mileageTable.querySelector('select[category]');

    addMileageBtn.addEventListener('click', e => {
      window.location = `dashboard.php?add-mileage=1&date=${date.value}&start=${start.value}&end=${end.value}&category=${category.value}`;
    });
    date.addEventListener('change', validateAddMileage);
    start.addEventListener('change', handleMileageChange);
    end.addEventListener('change', handleMileageChange);
    category.addEventListener('change', validateAddMileage);

    function handleMileageChange () {
      var sum = end.value - start.value;
      sum = sum >=0 ? sum : 0;
      console.log(sum);
      total.innerText = sum;
      validateAddMileage();
    }

    function validateAddMileage () {
      if (date.value && total.innerHTML > 0 && category.value) {
        addMileageBtn.removeAttribute('disabled');
      }
      else {
        addMileageBtn.setAttribute('disabled','');
      }
    }

  }

  var addVehicleModalBtn = document.querySelector('button.add-vehicle');
  if (addVehicleModalBtn) {
    addVehicleModalBtn.addEventListener('click', openAddVehicleModal);
  }

});


////////////////////////////
// "Edit Vehicle" Button
///////////////////////////
document.addEventListener('DOMContentLoaded', () => {
  var editVehicleButton = document.querySelector('button.edit-vehicle');

  if (editVehicleButton) {
    editVehicleButton.addEventListener('click', openEditVehicleModal);
  }
});

function openEditVehicleModal () {
  var editVehicleModal = document.querySelector('div.add-vehicle');

  let make = editVehicleModal.querySelector('#make');
  let model = editVehicleModal.querySelector('#model');
  let year = editVehicleModal.querySelector('#year');
  let color = editVehicleModal.querySelector('#color');
  let vin = editVehicleModal.querySelector('#vin');
  let preferred = editVehicleModal.querySelector('#preferred');

  let header = editVehicleModal.querySelector('header h2');
  let submit = editVehicleModal.querySelector('footer button.submit');
  let toggle = editVehicleModal.querySelector('input.toggle');

  // Update to "Edit Vehicle"
  header.innerText = "Edit Vehicle";
  submit.innerText = "Edit Vehicle";
  toggle.name = "edit-vehicle";
  
  // fetch & set data
  var vehicle = document.querySelector('div[vehicle]')
                        .getAttribute('vehicle');
  vehicle = JSON.parse(vehicle);

  fetch(`./api.php?make=${vehicle.make}`)
  .then( resp => {
    return resp.json();
  }).then ( models => {
    listOptions(models, "model");
    model.value = vehicle.model;
  });

  fetch(`./api.php?make=${vehicle.make}&model=${vehicle.model}`)
  .then( resp => {
    return resp.json();
  }).then ( years => {
    listOptions(years, "year");
    year.value = vehicle.year;
  });

  make.value = vehicle.make;
  vin.value = vehicle.vin;
  color.value = vehicle.color;
  preferred.checked = vehicle.preferred;

  // show modal
  editVehicleModal.removeAttribute('hidden');
}

////////////////////////////
// "Delete Vehicle" Modal
///////////////////////////
document.addEventListener('DOMContentLoaded', () => {
  var deleteVehicleButton = document.querySelector('button.delete-vehicle');
  var cancelDeleteVehicleButton = document.querySelector('div.delete-vehicle button.cancel');

  if (deleteVehicleButton) {
    deleteVehicleButton.addEventListener('click', openDeleteVehicleModal);
  }
  if (cancelDeleteVehicleButton) {
    cancelDeleteVehicleButton.addEventListener('click', closeDeleteVehicleModal);
  }
});

function openDeleteVehicleModal () {
  var deleteVehicleModal = document.querySelector('div.delete-vehicle');
  // show modal
  deleteVehicleModal.removeAttribute('hidden');
}

function closeDeleteVehicleModal () {
  var deleteVehicleModal = document.querySelector('div.delete-vehicle');
  // show modal
  deleteVehicleModal.setAttribute('hidden', '');
}