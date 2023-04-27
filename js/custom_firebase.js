//Custom firestore/firebase functions

/*
async function getTestData(db) {
    const testDataCol = collection(db, 'test-data');
    const testDataSnapshot = await getDocs(testDataCol);
    const testList = testDataSnapshot.docs.map(doc => doc.data());
    print(testList);
    return testList;
}*/

//Function to fetch data and create 'location cards'
//admin homepage -- card view element
//admin homepage -- card view element

/*
(function ($) {
    'use strict';
    $(document).ready(function () {
        const showFirestoreDatabase = () => {
            const db = firebase.firestore();
            const firestoreEl = jQuery('#custom-firebase');
        
            // You can get the collectionName and documentName from the shortcode attribute
            const collectionName = 'Alternate_layout';
            const documentName = 'Halkomatics'
        
            if (collectionName && documentName) {
                const docRef = db.collection(collectionName).doc(documentName);
        
                docRef.get().then(doc => {  
                    if (doc.exists) {
                        //do code here
                        var cMatic = doc.data().Matic3;

                        var h2Element = $('<h2>', {
                            class: 'card-font ml-auto mr-4 mt-3 mb-0 card-font-l',
                            text: cMatic.location
                          });
                          
                          var pElement = $('<p>', {
                            class: 'card-font ml-auto mr-4 mb-0 card-font-m',
                            text: cMatic.boxfull + '/' + cMatic.boxtotal + ' boxes have items'
                          });
                          
                          var h1Element = $('<h1>', {
                            class: 'card-font ml-auto mr-4 card-font-m',
                            text: cMatic.batteryCharge + '% battery remaining'
                          });
                          
                          var pElement2 = $('<p>', {
                            class: 'card-font ml-4 mb-4 card-font-s',
                            text: 'Last filled on ' + cMatic.previouslyUsed
                          });
                          
                          // Append everything to card div
                          cardDiv.append(h2Element, pElement, h1Element, pElement2);
                          
                          // Append the card div to the row div
                          rowDiv.append(cardDiv);
                          
                          // Append the row div to element. Do this for each one user is "subscribed" to
                          $('.box-status-holder').append(rowDiv);


                          //Creating the admin main screen notifications
                          console.log(cMatic.notifications.size);

                          for (var k = 0; k < 2; k++) {
                            // Creating Notifications
                            //Notification types: primary, success, danger, warning

                            //Fix the loop: needs to use k value and use a total length instead of fixed values
                                var classToAdd = 'alert-' + cMatic.notifications.notif0.class;

                                var notifDiv = $('<div>', {
                                    class: 'alert row',
                                    role: 'alert'
                                });
                                $(notifDiv).addClass(classToAdd);

                                var notifLocationDiv = $('<div>', {
                                    class: 'col-md-2',
                                    text: cMatic.location
                                });
                                
                                var notifMessageDiv = $('<div>', {
                                    class: 'col-md-8',
                                    text: cMatic.notifications.notif0.message
                                });
                                
                                var notifTimesDiv = $('<div>', {
                                    class: 'col-md-2 align-right',
                                    text: cMatic.notifications.notif0.timestamp
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
    })
})(jQuery)

*/
//Get Box info and create Box buttons --- also on button click update all button data + create notification
//Only on the fillbox page

(function ($) {
    $( document ).ready(function(){
    'use strict';
        $("#confirm-fill").click(function () {
            const db = firebase.firestore();

            var timestamp = new Date($.now());
            
            db.collection("Alternate_layout")
                .doc("Halkomatics")
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

                console.log("finished");

        });
    });
})(jQuery)