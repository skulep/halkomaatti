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


//FillBox page -- change box color to red or green

$(".fill-button").on("click", function() {
  // Toggle the color of the clicked button

  if ($(this).hasClass("empty")) {
    $(this).removeClass("empty");
    $(this).addClass("filled");
  }

  else if ($(this).hasClass("filled")) {
    $(this).removeClass("filled");
    $(this).addClass("faulty");
  }

  else if ($(this).hasClass("faulty")) {
    $(this).removeClass("faulty");
    $(this).addClass("empty");
  }
});



//admin homepage

var rowDiv = $('<div>', {
  class: 'row d-flex justify-content-center px-3'
});

// Create the inner div with class "card"
var cardDiv = $('<div>', {
  class: 'card'
});

// Create the h2 element with text and classes "card-font", "ml-auto", "mr-4", "mt-3", "mb-0", and "card-font-l"
var h2Element = $('<h2>', {
  class: 'card-font ml-auto mr-4 mt-3 mb-0 card-font-l',
  text: 'LocationName'
});

// Create the p element with text and classes "card-font", "ml-auto", "mr-4", "mb-0", and "card-font-m"
var pElement = $('<p>', {
  class: 'card-font ml-auto mr-4 mb-0 card-font-m',
  text: 'BoxStatus 25/60'
});



// Append the h2 and p elements to the card div
cardDiv.append(h2Element, pElement);

// Append the card div to the row div
rowDiv.append(cardDiv);

// Append the row div to element. Do this for each one user is "subscribed" to
$('.box-status-holder').append(rowDiv);