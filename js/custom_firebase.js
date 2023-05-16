//Custom firestore/firebase functions

//Function to fetch data and create 'location cards'
//admin homepage -- card view element

const consumer_key = 'ck_8654598a0ec8c770a1ff5206be1623298d485ab5';
const consumer_secret = 'cs_acad1d360ff6caf78484c8bc8bb8d86493acb359';

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
        var option1 = document.createElement("option");
        option1.selected = true;
        option1.value = "110";
        option1.textContent = "110 - Placeholder";
        
        var option2 = document.createElement("option");
        option2.value = "111";
        option2.textContent = "111 - Firewood, S";
        
        var option3 = document.createElement("option");
        option3.value = "112";
        option3.textContent = "112 - Firewood, L";
        
        var option4 = document.createElement("option");
        option4.value = "123";
        option4.textContent = "123 - Beanie";
        
        var option5 = document.createElement("option");
        option5.value = "99";
        option5.textContent = "99 - Unknown";
        
        // Append options to select element
        selectElement.append(option1);
        selectElement.append(option2);
        selectElement.append(option3);
        selectElement.append(option4);
        selectElement.append(option5);

        
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
            });*/

            itemIDs.push($("#id-select-1").val(), $("#id-select-2").val(), $("#id-select-3").val());

            console.log(itemIDs);
        });




    });
})(jQuery)






/*
(function ($) {
    $( document ).ready(function(){
    'use strict';
        $("#confirm-fill").click(function () {
            var timestamp = new Date($.now());

            db.collection('test-data')
                .doc('wp-notifs')
                .set({
                //pull the data from the form using jquery and update the database
                matic1: {
                    notifications: {
                        notif0: {
                            class: $("#class-select").val(),
                            message: $("#message-field").val(),
                            timestamp: timestamp
                        }
                    }
                }
                }, {merge: true})

                .then(function() {
                    console.log("Document successfully written!");
                })
                .catch(function(error) {
                    console.error("Error writing document: ", error);
                });
        });
    });
})(jQuery)







(function ($) {

    const db = firebase.firestore();
    const firestoreEl = jQuery('#custom-firebase');

    // You can get the collectionName and documentName from the shortcode attribute
    const collectionName = 'Alternate_layout';
    const documentName = 'Halkomatics'

    'use strict';
    $(document).ready(function () {
        const showFirestoreDatabase = () => {

        
            if (collectionName && documentName) {
                const docRef = db.collection(collectionName).doc(documentName);
        
                
                docRef.get().then(doc => {  
                    if (doc.exists) {
                        //do code here

                        var cMatic = doc.data().matic1;

                        var h2Element = $('<h2>', {
                            class: 'card-font ml-auto mr-4 mt-3 mb-0 card-font-l',
                            text: cMatic.adress
                          });
                          
                          var pElement = $('<p>', {
                            class: 'card-font ml-auto mr-4 mb-0 card-font-m',
                            text: cMatic.boxNum + '/' + cMatic.boxNum + ' boxes are functional'
                          });
                          
                          var h1Element = $('<h1>', {
                            class: 'card-font ml-auto mr-4 card-font-m',
                            text: cMatic.battery + '% battery remaining'
                          });
                          
                          var pElement2 = $('<p>', {
                            class: 'card-font ml-4 mb-4 card-font-s',
                            text: 'Last filled on ' + cMatic.lastUsed
                          });
                          
                          // Append everything to card div
                          cardDiv.append(h2Element, pElement, h1Element, pElement2);
                          
                          // Append the card div to the row div
                          rowDiv.append(cardDiv);
                          
                          // Append the row div to element. Do this for each one user is "subscribed" to
                          $('.box-status-holder').append(rowDiv);


                          //Creating the admin main screen notifications
                          let notifLen = Object.keys(cMatic.notifications).length;
                          console.log("length: "+ notifLen);

                          for (var k = 0; k < notifLen; k++) {
                            // Creating Notifications
                            //Notification types: primary, success, danger, warning

                            //Fix the loop: needs to use k value and use a total length instead of fixed values
                                let matics = [cMatic.notifications.notif0,cMatic.notifications.notif1,cMatic.notifications.notif2];
                            

                                var classToAdd = 'alert-' + matics[k].class;

                                var notifDiv = $('<div>', {
                                    class: 'alert row',
                                    role: 'alert'
                                });
                                $(notifDiv).addClass(classToAdd);

                                var notifLocationDiv = $('<div>', {
                                    class: 'col-md-2',
                                    text: cMatic.adress
                                });
                                
                                var notifMessageDiv = $('<div>', {
                                    class: 'col-md-8',
                                    text: matics[k].message
                                });
                                
                                var notifTimesDiv = $('<div>', {
                                    class: 'col-md-2 align-right',
                                    text: matics[k].timestamp
                                });
                                
                                notifDiv.append(notifLocationDiv, notifMessageDiv, notifTimesDiv);
                                
                                $('.notif-holder').prepend(notifDiv);
                          }
                          


                    } else {
                        // doc.data() will be undefined in this case
                        console.error('E1: Document does not exist');
                    }
                }).catch(error => {
                    console.error('E2:', error);
                });
            } else {
                console.warn('E3: Please check your collection and document name in the [firestore] shortcode!');
            }
        }
        
        showFirestoreDatabase()
    })/*/