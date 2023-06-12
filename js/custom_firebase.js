//Custom firestore/firebase functions

//Function to fetch data and create 'location cards'
//admin homepage -- card view element

const consumer_key = 'ck_c8ebd89159a0fa013e6aa1bc06d38e0071f64305';
const consumer_secret = 'cs_9d64b26fc675c139e93f038bcaca3727f7623e99';

var product_id = 123;
var api_url = 'https://localhost/wordpress/wp-json/wc/v3/products/'+ product_id + '?consumer_key='+ consumer_key +'&consumer_secret=' + consumer_secret;

var product_name = 'null';

//these 2 work in tandem
var itemIDs = [];
var itemCounts = [];

(function ($) {
    $.getJSON(api_url, function(data) {
        var product_name = data.name;
        var product_price = data.price;
        var product_description = data.description;
        
        // Log product data received using the api url
        console.log("Product Name: " + product_name);
        console.log("Price: " + product_price);
        console.log("Description: " + product_description);
      });
})(jQuery)

var itemsToUpdate = [
];

//Fetch all data from Firebase

const db = firebase.firestore();
async function getDocumentData(collectionName, documentName) {

    const collectionRef = db.collection(collectionName);
    const documentRef = collectionRef.doc(documentName);
    const doc = await documentRef.get();

  if (doc.exists) {
    //Create notifications
    const data = doc.data().matic1.notifications;


    //
    //
    //create the card view element here for now. dirty approach, fix later
    var h2Element = $('<h2>', {
        class: 'card-font ml-auto mr-4 mt-3 mb-0 card-font-l',
        text: doc.data().matic1.adress
    });
    
    var pElement = $('<p>', {
        class: 'card-font ml-auto mr-4 mb-0 card-font-m',
        text: doc.data().matic1.boxNum + '/' + doc.data().matic1.boxNum + ' boxes are functional'
    });
    
    var h1Element = $('<h1>', {
        class: 'card-font ml-auto mr-4 card-font-m',
        text: doc.data().matic1.battery + '% battery remaining'
    });
    
    var pElement2 = $('<p>', {
        class: 'card-font ml-4 mb-4 card-font-s',
        text: 'Last filled on ' + doc.data().matic1.lastUsed
    });
    
    // Append everything to card div
    cardDiv.append(h2Element, pElement, h1Element, pElement2);
    
    // Append the card div to the row div
    rowDiv.append(cardDiv);
    
    // Append the row div to element. Do this for each one user is "subscribed" to
    $('.box-status-holder').append(rowDiv);

    // Loop through each key in the data object and add it to the DOM. This one is used to create the notifications.
    for (const key in data) {
      if (data.hasOwnProperty(key)) {
        const value = data[key];

        var classToAdd = 'alert-' + data[key].class;
        var notifTime = data[key].timestamp.seconds * 1000;  //value is in seconds
        var notifDate = data[key].timestamp.nanoseconds;     //value is in nanoseconds

        var time = new Date(notifTime + notifDate);
        var notifTimestamp = time.toLocaleString('en-GB');
        
        var notifDiv = $('<div>', {
            class: 'alert row',
            role: 'alert'
        });
        $(notifDiv).addClass(classToAdd);

        var notifLocationDiv = $('<div>', {
            class: 'col-md-2',
            text: doc.data().matic1.adress
        });
        
        var notifMessageDiv = $('<div>', {
            class: 'col-md-8',
            text: data[key].message
        });
        
        var notifTimesDiv = $('<div>', {
            class: 'col-md-2 align-right',
            text: notifTimestamp
        });
        
        notifDiv.append(notifLocationDiv, notifMessageDiv, notifTimesDiv);
        
        $('.notif-holder').prepend(notifDiv);

      }
    }

    //
    //
    //
    //Create box buttons
    //Only visible on the fillbox site

    const data2 = doc.data().matic1.boxes;
    var buttonText = 1;
    var btnDiv = $('<div>', {
        class: 'row pt-5 pb-5'
      });

    // Loop through each key in the data object and add it to the DOM. This one is used to create the notifications.
    for (const key in data2) {
      if (data2.hasOwnProperty(key)) {
        
        var buttonStatusClass = 'empty';

        switch (data2[key].status) {
            case 0:
                buttonStatusClass = 'empty';
                break;
            case 1:
                buttonStatusClass = 'filled';
                break;
            case 2:
                buttonStatusClass = 'faulty';
                break;
        }

        var newButton = $('<button>', {
            class: 'btn fill-button btn-outline-grey-border btn-rounded-square',
            id: 'fill-button' + buttonText,
            text: buttonText
        });
        $(newButton).addClass(buttonStatusClass);
        $(newButton).on("click", function() {
        
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


        //Button's own class, appending both to btnDiv (which will then append to ttfield)
        var btnInnerDiv = $('<div>', {
            class: 'col d-flex justify-content-center'
        });

        //Because this seems necessary: the select to choose product and product id
        var selectElement = document.createElement("select");
        selectElement.className = "form-select";
        selectElement.id = "id-select-" + buttonText;
        selectElement.setAttribute("aria-label", "Default select example");
        
        // Create options
        //Get category item IDs and add each item as an option
        /*
        var optionsToAdd = [
            {value: 95, itemName: "Wood"},
            {value: 96, itemName: "Matches"},
            {value: 123, itemName: "Beanie"}
        ];

        for (let i = 0; i < optionsToAdd.length; i++) {
            eval ('var ' + 'option' + i + ' = ' + 'document.createElement("option");' );

            console.log(option0);

            console.log(eval ('var ' + 'option' + i + ' = ' + 'document.createElement("option");' ));

            //var option[i] = document.createElement("option");
            if (i == 0) {
                option[i].selected = true;       //The first element will require this.
            }
            option[i].value = optionsToAdd[i].value;
            option[i].itemName = optionsToAdd[i].itemName;

            selectElement.append(option[i]);
        }*/
        
        var option1 = document.createElement("option");
        option1.selected = true;
        option1.value = "95";
        option1.textContent = "95 - Firewood, S";
        
        var option2 = document.createElement("option");
        option2.value = "106";
        option2.textContent = "106 - Beanie";
        
        var option3 = document.createElement("option");
        option3.value = "107";
        option3.textContent = "107 - Belt";
        
        var option4 = document.createElement("option");
        option4.value = "96";
        option4.textContent = "96 - Matches";
        
        
        // Append options to select element
        selectElement.append(option1);
        selectElement.append(option2);
        selectElement.append(option3);
        selectElement.append(option4);

        
        
        btnInnerDiv.append(newButton);

        btnInnerDiv.append(selectElement);
        btnDiv.append(btnInnerDiv);
        $('.ttfield').append(btnDiv);

        buttonText++;


      }
    }


  } else {
    console.log("No such document!");
  }
}

getDocumentData('Alternate_layout', 'Halkomatics');

//Get Box info and create Box buttons --- also on button click update all button data + create notification
//Only on the fillbox page
(function ($) {
    $( document ).ready(function(){
    'use strict';
        $("#confirm-fill").click(function () {
            var timestamp = new Date($.now());

            var pushData = {
                class: $("#class-select").val(),
                message: $("#message-field").val(),
                timestamp: timestamp
            };
/*
            db.collection("Alternate_layout").doc("Halkomatics").set({
                matic1:{
                    notifications: firebase.firestore.FieldValue.arrayUnion(pushData)
                }
            }, {merge: true})

            .then(function() {
                console.log("Document successfully written!");
            })
            .catch(function(error) {
                console.error("Error writing document: ", error);
            });
*/

            //!!!!!!!!!!!!!!!!! make dynamic
            itemIDs.push($("#id-select-1").val(), $("#id-select-2").val(), $("#id-select-3").val());

            //console.log(itemIDs);


            //Adding items to array
            //updates all product data.
            console.log("classes:" + document.getElementById("fill-button1").classList);

            var buttonsLen = document.getElementsByClassName("fill-button").length;
            for (let i = 0; i < buttonsLen; i++) {
                var buttonNumber = i+1;
                var selectedId = $('#id-select-' + buttonNumber).val();
                console.log(selectedId);

                  if ($('#fill-button' + buttonNumber).hasClass("filled")) {
                    var newItem = {id: selectedId, newStock: 1};  //Only need to add 1 item at once.
                    var itemToUpdate = itemsToUpdate.find(item => item.id === newItem.id); //Check if new item already exists in the array. If not, it is created. If it does, the stock value will increment by one.
                    console.log(itemToUpdate);
                    if (itemsToUpdate.some(item => item.id === newItem.id)) {
                        console.log("ID already exists in the array. Stock value will be updated");
                        itemToUpdate.newStock += 1;
                    } else {
                        console.log("ID does not exist in the array. New entry added");
                        itemsToUpdate.push(newItem);
                    }
                  }
                  //!!!!!!!! can make this a lot shorter than currently. just for testing purposes :)
                  else {
                    console.log("I: not filled status")
                    var newItem = {id: selectedId, newStock: 0};  //Add 0 item so you can set stock status to 0.
                    var itemToUpdate = itemsToUpdate.find(item => item.id === newItem.id); //Check if new item already exists in the array. If not, it is created. If it does, the stock value will increment by one.
                    console.log(itemToUpdate);
                    if (itemsToUpdate.some(item => item.id === newItem.id)) {
                        console.log("ID already exists in the array.");
                    } else {
                        console.log("ID does not exist in the array. New entry added");
                        itemsToUpdate.push(newItem);
                    }
                  }
            }

            console.log(itemsToUpdate);
            //Updates product stock to Woocommerce
            for (let i = 0; i < itemsToUpdate.length; i++) {
                console.log(itemsToUpdate[i].id);
            
                let url = 'https://localhost/wordpress/wp-json/wc/v3/products/'+ itemsToUpdate[i].id + '?consumer_key='+ consumer_key +'&consumer_secret=' + consumer_secret;
            
                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        },
                    body: JSON.stringify({ stock_quantity: itemsToUpdate[i].newStock }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Product stock updated successfully:', data);
                    })
                    .catch(error => {
                        console.error('Error updating product stock:', error);
                    });
            }   //Works now!
        });


    });
})(jQuery)
