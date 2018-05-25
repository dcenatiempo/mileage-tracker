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
// Add Vehicle Modal
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
  addVehicleModal.removeAttribute('hidden');
}

function closeAddVehicleModal (e) {
  var addVehicleModal = document.querySelector('div.add-vehicle');
  addVehicleModal.setAttribute('hidden', '');
  clearList("model");
  clearList("year");
  // reset make
  // reset color
  // reset vin
  // reset primary
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