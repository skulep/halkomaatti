// Firebase Functions.
// Functions to add elements to sites, grab data from Firebase and other.

const consumer_key = 'ck_864038e09ac6e7dd685f453c0de8724ae8b02966';
const consumer_secret = 'cs_2ace62c4d0953923dedc7c9555095ec39440e23a';


var itemsToUpdate = [
];

//Fetch all data from Firebase. Check line 280-320(ish) for function call

const db = firebase.firestore();
async function getDocumentData(collectionName, documentName) {

    const collectionRef = db.collection(collectionName);
    const documentRef = collectionRef.doc(documentName);
    const doc = await documentRef.get();

  if (doc.exists) {
    if(window.location.href.includes("/admin-fill-box"))
    {
        //Create box buttons
        //Only visible on the fillbox site

        const data2 = doc.data().box;    //!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        var buttonText = 1;
        var btnDiv = $('<div>', {
            class: 'row pt-5 pb-5'
        });

        // Loop through each key in the data object and add it to the DOM. This one is used to create the notifications.
        data2.forEach(boxData => {
            var buttonStatusClass = 'empty';
        
            switch (boxData.state) {
                case 0:
                    buttonStatusClass = 'filled';
                    break;
                case 1:
                    buttonStatusClass = 'empty';
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
            
            //If dbID == option value, set a value as selected
            var dbID = boxData.id;

            var options = [];
            const productData = new Map;

            getProductsInCategory(documentName)  //reminder documentName == location/device name so this should work.
                .then(products => {
                    if (products) {
                        const filteredProducts = filterProductsByCategory(products, documentName);
                        // Process the products as needed, e.g., extract names
                        filteredProducts.forEach(product => {
                            productData.set(product.id, product.name); // Set product name and id in a map
                        });

                        //xdd
                        for (let [productId, productName] of productData.entries()) {
                            var optionName = "option" + (options.length + 1);
                            optionName = document.createElement("option");
                            //if (options.length === 0) {
                            //    optionName.selected = true;
                            //}
                        
                            optionName.value = productId;
                            optionName.textContent = productName;
                            selectElement.append(optionName);
                            options.push(optionName);
                        }

                        //Try to find the CURRENT id, and use it as 'default'. Makes it easier to fill the boxes ig.

                        if (dbID) {
                            for (let i = 0; i < options.length; i++) {

                                var optionVal = options[i].value;

                                if (dbID == optionVal) {
                                    options[i].selected = true;
                                }
                            }
                        }
                        else {
                            console.log("dbid was null");
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            
            //append buttons + select boxes and name them
            btnInnerDiv.append(newButton);
            btnInnerDiv.append(selectElement);
            btnDiv.append(btnInnerDiv);
            $('.ttfield').append(btnDiv);
            buttonText++;
            });
        }
    }
    else {
        console.log("No such document!");
    }
}


async function getDeviceData() {
    if(window.location.href == "https://firewood2go.eu/index.php/admin-box-info/") {
        const collectionRef = db.collection("listOfOrganization");
        const documentRef = collectionRef.doc("listOfDevices");
        const doc = await documentRef.get();
        if (doc.exists) {
            const listOfDevices = doc.data().list;  //Grabs the list of devices. array with map objects inside, that have the required info for this.
            console.log(listOfDevices);
            listOfDevices.forEach(devData => {
                console.log("device data found: " + devData.deviceName, devData.organizationName, devData.location);

                 //create button(s)
                var button = document.createElement("button");
                button.innerHTML = devData.deviceName;
                button.onclick = function() {
                    window.location.href = "https://firewood2go.eu/index.php/admin-fill-box-" + devData.organizationName + "-" + devData.deviceName + "/";
                };


                var container = document.getElementById("container");
                //new shits xdd
                var row = document.createElement("div");
                row.className = "row";
  
                container.appendChild(row);

                // Create iframe element
                var iframe = document.createElement("iframe");
                iframe.src = "https://maps.google.com/maps?q=" + devData.location.latitude + "," + devData.location.longitude + "&hl=en;z=14&amp;output=embed";
                iframe.className = "w-100";
                iframe.height = "500";
                iframe.allowFullscreen = true;
                iframe.loading = "lazy";

                // Create div container for device list
                var deviceListContainer = document.createElement("div");
                deviceListContainer.className = "col-lg-8";

                // Add iframe to device list container
                deviceListContainer.appendChild(iframe);

                // Append device list container to row
                row.appendChild(deviceListContainer);

                // Create box status elements
                var boxStatusElements = document.createElement("div");
                boxStatusElements.className = "col-lg-2 my-4 d-flex align-items-center d-none d-lg-block";
                var headings = ["Box Status", "Device name: " + devData.deviceName, "Organization: " + devData.organizationName , "Street: " + devData.street, "Lat: " + devData.location.latitude + "  Long: " + devData.location.longitude];

                headings.forEach(function(headingText, index) {
                    var element = document.createElement(index === 0 ? "h2" : "h6");
                    element.textContent = headingText;
                    boxStatusElements.appendChild(element);
                });

                var button = document.createElement("button");
                button.innerHTML = "Proceed to Fill";
                button.onclick = function() {
                    window.location.href = "https://firewood2go.eu/index.php/admin-fill-box-" + devData.organizationName + "-" + devData.deviceName + "/";
                };
                button.className = "btn btn-primary"
                button.setAttribute("role", "button");
                boxStatusElements.appendChild(button);

                // Append box status elements to row
                row.appendChild(boxStatusElements);
            });
            
           
        }
    }
}


async function getHomepageData() {
    const collectionRef = db.collection('listOfOrganization');
    const documentRef = collectionRef.doc('listOfDevices');
    const doc = await documentRef.get();

    var dropdown = document.getElementById("locationDropdown");

    if (doc.exists) {
        const listOfDevices = doc.data().list;  //Grabs the list of devices. array with map objects inside, that have the required info for this.
        listOfDevices.forEach(devData => {

            var option = document.createElement("option");
            option.value = devData.organizationName + "/" + devData.deviceName;
            option.text = devData.street;
            dropdown.appendChild(option);
        });
                    
    }
    else {
        console.log("does not exist");
    }
}
//Get Document Info using CURRENT PAGE URL --> PARSE. currently working OK!!!

//For fillpage Only
var currentUrl = window.location.href;
if(currentUrl.includes("/admin-fill-box")) {
    var urlSplit = currentUrl.split("/");
    var firestorePath = urlSplit[4].split("-");
    
    var orgpath = firestorePath[3].charAt(0).toUpperCase() + firestorePath[3].slice(1);
    var maticpath = firestorePath[4].charAt(0).toUpperCase() + firestorePath[4].slice(1);
    
    getDocumentData(orgpath, maticpath);
}

//admin box info ==== dispensers-tab
if(window.location.href == "https://firewood2go.eu/index.php/admin-box-info/") {
    getDeviceData();
}

//admin-main, its supposed to have a dropdown menu thing that you can choose a location from.
if(window.location.href == "https://firewood2go.eu/index.php/admin-main/") {
    getHomepageData();
}

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

            //Individual box data to Firebase
            var boxes = [];
            var buttonsLen = document.getElementsByClassName("fill-button").length;
            
            for (let x = 1; x <= buttonsLen; x++) {
                //let box_name = "box" + x;
                let boxClass = 0;

                if ($('#fill-button' + x).hasClass("filled")) {
                    boxClass = 0;
                }
                else if ($('#fill-button' + x).hasClass("empty")) {
                    boxClass = 1;
                }
                else if ($('#fill-button' + x).hasClass("faulty")) {
                    boxClass = 2;
                }


                var boxData = {
                    id: parseInt($('#id-select-' + x).val()),
                    state: boxClass
                };

                boxes.push(boxData);
            }

            console.log(boxes);


            db.collection(orgpath).doc(maticpath).set({
                notifications: firebase.firestore.FieldValue.arrayUnion(pushData),
                box: boxes
            }, {merge: true})

            .then(function() {
                console.log("Document successfully written!");
            })
            .catch(function(error) {
                console.error("Error writing document: ", error);
            });

            console.log(boxes);

            //Adding items to array
            //updates all product data.

            //var buttonsLen = document.getElementsByClassName("fill-button").length;
            for (let i = 0; i < buttonsLen; i++) {
                var buttonNumber = i+1;
                var selectedId = $('#id-select-' + buttonNumber).val();

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
                    var newItem = {id: selectedId, newStock: 0};  //Add 0 item so you can set stock status to 0.
                    var itemToUpdate = itemsToUpdate.find(item => item.id === newItem.id); //Check if new item already exists in the array. If not, it is created. If it does, the stock value will increment by one.
                    console.log(itemToUpdate);
                    if (itemsToUpdate.some(item => item.id === newItem.id)) {
                        console.log("ID already exists in the array.");
                    } else {
                        console.log("ID does not exist in the array. New entry added at value 0.");
                        itemsToUpdate.push(newItem);
                    }
                  }
            }

            //Updates product stock to Woocommerce
            for (let i = 0; i < itemsToUpdate.length; i++) {
            
                let url = 'https://firewood2go.eu/index.php/wp-json/wc/v3/products/'+ itemsToUpdate[i].id + '?consumer_key='+ consumer_key +'&consumer_secret=' + consumer_secret;
            
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

// Grabs items in category using the category slug.
async function getProductsInCategory(categorySlug) {
    const lowerCaseSlug = categorySlug.toLowerCase();
    const url = 'https://firewood2go.eu/index.php/wp-json/wc/v3/products?category/'+ lowerCaseSlug + '&consumer_key='+ consumer_key +'&consumer_secret=' + consumer_secret;
    try {
        const response = await fetch(url);
        if (!response.ok) {
            throw new Error('Failed to fetch products');
        }
        const products = await response.json();
        return products;
    } catch (error) {
        console.error('Error fetching products:', error);
        return null;
    }
}

//category filter, since apparently finding them via slug does not work
function filterProductsByCategory(products, categorySlug) {
    const lowerCaseSlug = categorySlug.toLowerCase();
    return products.filter(product => product.categories.some(category => category.slug === lowerCaseSlug));
}


//variable for the function below. removes data if true
var wasClicked = false;
async function readUsingOption() {
    var dropdown = document.getElementById('locationDropdown');
    var dropdownValue = dropdown.value;

    var splitDropdown = dropdownValue.split("/");


    const collectionRef = db.collection(splitDropdown[0]);
    const documentRef = collectionRef.doc(splitDropdown[1]);
    const doc = await documentRef.get();

        if (doc.exists)
        {
            if (wasClicked) {
                //button was clicked earlier
                //remove data from notifs and row
                $('.notif-holder').empty();
                $(".box-status-holder").empty();
            }

            //Create notifications
            const data = doc.data().notifications;

            console.log(doc.data().address);

            //create the card view element here for now. dirty approach, fix later
            var h2Element = $('<h2>', {
                class: 'card-font ml-auto mr-4 mt-3 mb-0 card-font-l',
                text: doc.data().address
            });

            var pElement = $('<p>', {
                class: 'card-font ml-auto mr-4 mb-0 card-font-m',
                text: doc.data().doors + ' boxes are functional'
            });

            var h1Element = $('<h1>', {
                class: 'card-font ml-auto mr-4 card-font-m',
                text: doc.data().battery + '% battery remaining'
            });
            /*
            var pElement2 = $('<p>', {
                class: 'card-font ml-4 mb-4 card-font-s',
                text: 'Last filled on '
            });
            */
            // Append everything to card div
            cardDiv.append(h2Element, pElement, h1Element); //, pElement2

            // Append the card div to the row div
            rowDiv.append(cardDiv);

            // Append the row div to element. Do this for each one user is "subscribed" to
            $('.box-status-holder').prepend(rowDiv);

            // Loop through each key in the data object and add it to the DOM. This one is used to create the notifications.
            for (const key in data) {
            if (data.hasOwnProperty(key)) {
                const value = data[key];

                var classToAdd = 'alert-' + data[key].class;
                var notifDate = data[key].timestamp.toDate().toDateString();     //value is in nanoseconds
                var notifTime = data[key].timestamp.toDate().toLocaleTimeString('en-US');

                var notifTimestamp = notifTime + ', ' + notifDate;
                
                var notifDiv = $('<div>', {
                    class: 'alert row',
                    role: 'alert'
                });
                $(notifDiv).addClass(classToAdd);

                var notifLocationDiv = $('<div>', {
                    class: 'col-md-2',
                    text: doc.data().address
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
            wasClicked = true;
            }
        }
}