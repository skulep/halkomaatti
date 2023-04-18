//Custom jQuery or Javascript functions

//Modal -- edit visible text
/*
var exampleModal1 = document.getElementById('exampleModal1')
exampleModal1.addEventListener('show.bs.modal', function (event) {
  // Button that triggered the modal
  var button = event.relatedTarget
  // Extract info from data-bs-* attributes
  var recipient = button.getAttribute('data-bs-whatever')
  // If necessary, you could initiate an AJAX request here
  // and then do the updating in a callback.
  //
  // Update the modal's content.
  var modalTitle = exampleModal1.querySelector('.modal-title')
  var modalBodyInput = exampleModal1.querySelector('.modal-body input')

  modalTitle.textContent = 'Currently editing Tuira box no. ' + recipient
  modalBodyInput.value = recipient
})
*/


//FillBox -- change box color to red or green
const btnfill = document.getElementById('btn-fill');
const colors = ['green', 'red', 'white'];
let index = 0;

btnfill.addEventListener('click', function onClick() {
  btnfill.style.backgroundColor = colors[index];

  index = index >= colors.length - 1 ? 0 : index + 1;
});