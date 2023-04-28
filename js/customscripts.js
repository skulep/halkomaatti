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



/* Personal notes
fillbox -- on button click:

run a loop: first create a button for however many boxes there are. fetch data -- box status. 1 = empty, 2 = filled... add the required class/es

on button click: run another loop, this time replace data to firestore. if button has class filled, make status 2. (and so on)

also add a notification -- something like   "30 Boxes refilled. Box #3 and #9 marked as faulty.
                                            Filler's notice: yes the lock was broken, likely frozen"
*/

// FillBox
// Generating the buttons
//FIX - color does not change on click
//FIX - need to create a div every 3 buttons


$(document).ready(function() {
  
  //Button's Outer Div Class
  var btnDiv = $('<div>', {
    class: 'row pt-5 pb-5'
  });

  for (var i = 0; i < 2; i++) {
    console.log(i);
    var buttonText = i + 1;
    var newButton = $('<button>', {
      class: 'btn fill-button empty btn-outline-grey-border btn-rounded-square',
      id: 'fill-button' + i,
      text: buttonText
    });

    //Button's own class, appending both to btnDiv (which will then append to ttfield)
    var btnInnerDiv = $('<div>', {
      class: 'col d-flex justify-content-center'
    });
    
    btnInnerDiv.append(newButton);
    btnDiv.append(btnInnerDiv);

  }
  $('.ttfield').append(btnDiv);
});



$(document).ready(function() {
  $(".fill-button").on("click", function() {

    console.log("fill-button was clicked");
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
});

/*

//admin homepage -- card view element
var rowDiv = $('<div>', {
  class: 'row d-flex justify-content-center px-3'
});

var cardDiv = $('<div>', {
  class: 'card'
});

//Text elements. NEED TO BE IN A FOR/FOREACH LOOP, WHERE text WILL BE FROM FIREBASE. Same with notifications. Every bit is
var h2Element = $('<h2>', {
  class: 'card-font ml-auto mr-4 mt-3 mb-0 card-font-l',
  text: 'LocationName'
});

var pElement = $('<p>', {
  class: 'card-font ml-auto mr-4 mb-0 card-font-m',
  text: 'BoxStatus 25/60, 2 errors'
});

var h1Element = $('<h1>', {
  class: 'card-font ml-auto mr-4 card-font-m',
  text: 'Battery 4%'
});

var pElement2 = $('<p>', {
  class: 'card-font ml-4 mb-4 card-font-s',
  text: 'Previously filled: 11.3.2021'
});

// Append everything to card div
cardDiv.append(h2Element, pElement, h1Element, pElement2);

// Append the card div to the row div
rowDiv.append(cardDiv);

// Append the row div to element. Do this for each one user is "subscribed" to
$('.box-status-holder').append(rowDiv);

*/

//Card div for location and their data
var rowDiv = $('<div>', {
  class: 'row d-flex justify-content-center px-3'
});

var cardDiv = $('<div>', {
  class: 'card'
});

//


//Create others in a firebase function and append the notifications to notifholder class


