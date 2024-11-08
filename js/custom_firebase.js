import { secrets } from './secret.js';

// Firebase Functions.
// Functions to add elements to sites, grab data from Firebase and other.

const consumer_key = secrets.consumer_key;
const consumer_secret = secrets.consumer_secret;
const maps_api = secrets.maps_api;

var itemsToUpdate = [
];
const productData = new Map;

//From functions.php. Only works on this site unless I'm mistaken
const siteUrl = siteData.homeUrl;

//Fetch all data from Firebase. Check line 280-320(ish) for function call

const db = firebase.firestore();
async function getDocumentData(collectionName, documentName) {

    const collectionRef = db.collection(collectionName);
    const documentRef = collectionRef.doc(documentName);
    const doc = await documentRef.get();

  if (doc.exists) {
    if(window.location.href.includes("/admin-fill-box"))
    {
        //Only visible/ran on the fillbox site
        //Fetch data
        var locationElement = document.getElementById("rowLocation");
        if (locationElement) {
            locationElement.textContent = doc.data().name + ", " + doc.data().org;
        }

        var locationCountry = document.getElementById("rowCountry");
        if (locationCountry) {
            locationCountry.textContent = doc.data().address;
        }

        var locationCoords = document.getElementById("rowCoords");
        if (locationCoords) {
            locationCoords.textContent = doc.data().coordinates.latitude + ", " + doc.data().coordinates.longitude;
        }
        //Create box buttons
        
        const data2 = doc.data().box;    //!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        var buttonText = 1;
        var btnDiv = $('<div>', {
            class: 'row pt-5 pb-5'
        });

        //var options = [];
        

        // Do getProducts outside the loop. This will be shared for each product so it's not necessary.  
        //productData can then be used to populate the 'option'
        try {
        const products = await getProductsInCategory(documentName);  //reminder documentName == location/device name so this should work, unless something got messed up during setup.

            //console.log("Product was found, processing");
            if (products) {
                const filteredProducts = filterProductsByCategory(products, documentName);
                // Processing the found products 
                filteredProducts.forEach(product => {
                    productData.set(product.id, product.name); // Set product name and id in a map
                });
            }
        } catch (error) {
            console.error('Error:', error);
        }


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
                class: 'btn fill-button btn-outline-grey-border custom-btn',
                id: 'fill-button' + buttonText,
                text: buttonText
            });
            $(newButton).addClass(buttonStatusClass);
            $(newButton).on("click", function() {
                if ($(this).hasClass("filled")) {
                $(this).removeClass("filled");
                $(this).addClass("faulty");
                }
                else if ($(this).hasClass("empty")) {
                $(this).removeClass("empty");
                $(this).addClass("filled");
                }
                else if ($(this).hasClass("faulty")) {
                $(this).removeClass("faulty");
                $(this).addClass("empty");
                }
            });


            //Button's own class, appending both to btnDiv (which will then append to ttfield)
            var btnInnerDiv = $('<div>', {
                class: 'col mt-2 mb-2'  //old: class: 'col d-flex justify-content-center'
            });

            //Because this seems necessary: the select to choose product and product id
            var selectElement = document.createElement("select");
            selectElement.className = "custom-select mt-2"; //had form-select b4
            selectElement.id = "id-select-" + buttonText;
            selectElement.setAttribute("aria-label", "Default select example");
            
            //If dbID == option value, set a value as selected
            var dbID = boxData.id;

            var options = [];
            //const productData = new Map;


            // Do getProducts outside the loop. This will be shared for each product so it's not necessary.  
            //productData can then be used to populate the 'option'
            //console.log("pData", productData);        
            //Filling option(s) using product data
            for (let [productId, productName] of productData.entries()) {
                //console.log("Creating options");
                var optionName = "option" + (options.length + 1);
                optionName = document.createElement("option");
            
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
    if(window.location.href == siteUrl + "/admin-box-info/") {
        const collectionRef = db.collection("listOfOrganization");
        const documentRef = collectionRef.doc("listOfDevices");
        const doc = await documentRef.get();
        if (doc.exists) {
            const listOfDevices = doc.data().list;  //Grabs the list of devices. array with map objects inside that have the required info for this.
            //console.log(listOfDevices);
            listOfDevices.forEach(devData => {
                //console.log("device data found: " + devData.deviceName, devData.organizationName, devData.location);
                const container = document.getElementById("container"); //Get 'container'
                appendBoxes(container, devData);
            });
        }
    }
}


async function getHomepageData() {
    const collectionRef = db.collection('listOfOrganization');
    const documentRef = collectionRef.doc('listOfDevices');
    const doc = await documentRef.get();

    var dropdownContent = document.getElementById("myDropdown");

    if (doc.exists) {
        const listOfDevices = doc.data().list;  // Grabs the list of devices. array with map objects inside, that have the required info for this.
        listOfDevices.forEach(devData => {
            var link = document.createElement("a");
            //link.href = "#";
            link.textContent = devData.street;
            link.onclick = function() {
                changeText(devData.deviceName,devData.organizationName,devData.street); //BatteryLevel still hardcoded
            };
            dropdownContent.appendChild(link);

            //console.log("ELEMENT ADDED to myDropdown:" + devData.deviceName);
        });
    } else {
        console.log("Document does not exist");
    }
}
//Get Document Info using CURRENT PAGE URL --> PARSE. currently working OK!!!

//For fillpage Only
var currentUrl = window.location.href;
if(currentUrl.includes("/admin-fill-box")) {
    var urlSplit = currentUrl.split("/");
    var firestorePath = urlSplit[3].split("-");
    
    var orgpath = firestorePath[3].charAt(0).toUpperCase() + firestorePath[3].slice(1);
    var maticpath = firestorePath[4].charAt(0).toUpperCase() + firestorePath[4].slice(1);
    
    getDocumentData(orgpath, maticpath);
}

//admin box info ==== dispensers-tab
if(window.location.href == siteUrl + "/admin-box-info/") {
    getDeviceData();
}

//admin-main, its supposed to have a dropdown menu thing that you can choose a location from.
if(window.location.href == siteUrl + "/admin-main/") {
    getHomepageData();
}

//needs to be global, used to create the notification
var dbUpdateStatus = false;

//Function will additionally take "boxes" from previous/older version of the function
async function addToFirestore(boxes, docRef) {
    var timestamp = new Date($.now());

    var pushData = {
        class: $("#class-select").val(),
        message: $("#message-field").val(),
        timestamp: timestamp
    };

    try {
        // Fetch the current notifications
        var doc = await docRef.get();
        var notifications = []; //New array, used to store the 5 newest notifications. Utilizes timestamp

        if (doc.exists) {
            notifications = doc.data().notifications || [];
        }

        // Add the new notification to the array
        notifications.push(pushData);

        //Check if there are over 5 notifications - if yes, delete the oldest one
        if (notifications.length > 5) {
            notifications.sort((a, b) => a.timestamp - b.timestamp); // Sort notifications by timestamp
            notifications.shift(); // Remove using shift()
        }

        // Update the Firestore document with the new notifications and boxes arrays
        await docRef.set({
            notifications: notifications,
            box: boxes
        }, { merge: true });

        //console.log("Firestore updated successfully!");
        dbUpdateStatus = true;

    } catch (error) {
            console.error("Error updating Firestore: ", error);
            dbUpdateStatus = false;
        }
}



//Get Box info and create Box buttons --- also on button click update all button data + create notification
//Only on the fillbox page
//(function ($) {
    $(document).ready(function() {
        'use strict';
        var buttonClicked = false;
    
        $("#confirm-fill").click(function () {
            if (buttonClicked) {
                //console.log("Button already clicked, returning");
                return;
            }
            buttonClicked = true;

            $(this).prop('disabled', true); // Disabling the button ...
            $(this).text("Please wait, currently working..."); // and changing the text on click
            $(this).removeClass("btn-primary"); //Also removing/adding a class to change the color
            $(this).addClass("btn-grey-border");

            /*
            var timestamp = new Date($.now());

            var pushData = {
                class: $("#class-select").val(),
                message: $("#message-field").val(),
                timestamp: timestamp
            };*/

            //Individual box data to Firebase
            var boxes = []; //Use in function addSortedNotification
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

            
            //Get docRef and pass it to addToFirestore
            var docRef = db.collection(orgpath).doc(maticpath);
            addToFirestore(boxes, docRef);

            //Adding items to array
            //updates all product data. This now also includes products in category without any item in it

            //var buttonsLen = document.getElementsByClassName("fill-button").length;

            //placing all products we have into itemsToUpdate first. this way, even if something goes wrong or if product is removed it should not be available for purchase
            //using productData for this, since it'll have all of our products
            for (let [productId, productName] of productData.entries()) {
                var newItem = {id: productId, newStock: 0};  //Add 0 item so you can set stock status to 0.
                console.log(newItem);
                console.log("Initial entry added: ", productName);
                itemsToUpdate.push(newItem);
            }

            //Populating stock...
            for (let i = 0; i < buttonsLen; i++) {
                var buttonNumber = i+1;
                var selectedId = $('#id-select-' + buttonNumber).val();
                  if ($('#fill-button' + buttonNumber).hasClass("filled")) {
                    selectedId = parseInt(selectedId, 10);
                    var itemToUpdate = itemsToUpdate.find(item => item.id === selectedId); //Check if new item already exists in the array. If not, it is created. If it does, the stock value will increment by one.

                    if (itemToUpdate) {
                        itemToUpdate.newStock += 1;
                        console.log(itemToUpdate);
                    } else {
                        console.log("ID does not exist in the array. why? this should not happen...");
                    }
                  }
            }

            //Updates product stock to Woocommerce
            for (let i = 0; i < itemsToUpdate.length; i++) {
            
                let url = siteUrl + '/wp-json/wc/v3/products/'+ itemsToUpdate[i].id + '?consumer_key='+ consumer_key +'&consumer_secret=' + consumer_secret;
            
                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        },
                    body: JSON.stringify({ stock_quantity: itemsToUpdate[i].newStock }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        //console.log('Product stock updated successfully:', data);
                        if (dbUpdateStatus) {
                            alert("Successfully updated Firestore state and WooCommerce stock. Redirecting to the main page.");
                            window.location.href = siteUrl + "/admin-main/";
                        }
                        
                    })
                    .catch(error => {
                        console.error('Error updating product stock:', error);
                        alert("Error: Stock could not be updated successfully. Reload the page and retry.");
                    });
            }   //Works now!
        });


    });


//})(jQuery)

// Grabs items in category using the category slug.
async function getProductsInCategory(categorySlug) {
    const lowerCaseSlug = categorySlug.toLowerCase();
    const url = siteUrl + '/wp-json/wc/v3/products?category/'+ lowerCaseSlug + '&consumer_key='+ consumer_key +'&consumer_secret=' + consumer_secret;
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

async function changeText(deviceName, organizationName, streetName) {
    document.getElementById("deviceName").innerText = deviceName;
    document.getElementById("organizationName").innerText = organizationName;
    document.getElementById("streetName").innerText = streetName;

    const collectionRef = db.collection(organizationName);
    const documentRef = collectionRef.doc(deviceName);
    const doc = await documentRef.get();

    if (doc.exists)
    {
        //we can now grab the battery level, since it's stored in this location :).
        document.getElementById("batteryValue").innerText = doc.data().battery + "%";

        //CSS BG image element
        var topElement = document.querySelector('.weather-card .top');

        //Fetching a custom background image if one has been entered
        if (doc.data().imageLink !== null && doc.data().imageLink !== undefined && doc.data().imageLink !== '') {
            var imageLink = doc.data().imageLink;
            // Attempting to change the background image URL
            topElement.style.backgroundImage = `url(${imageLink})`;
        }
        else {
            topElement.style.backgroundImage = 'url("https://s-media-cache-ak0.pinimg.com/564x/cf/1e/c4/cf1ec4b0c96e59657a46867a91bb0d1e.jpg")'
        }

        //Grabbing total boxes number and the number of boxes with items in them
        const boxes = doc.data().box;
        var activeBoxes = 0;
        const boxesLength = boxes.length;

        boxes.forEach((box) => {
            // Filtering boxes where state is 0, then adding +1 to activeBoxes
            if (box.state === 0) {
            activeBoxes++;
            }
        });
        document.getElementById("boxesState").innerText = "Active Boxes: " + activeBoxes + " / " + boxesLength;

        //Removing content from notif-holder. It should be empty by default anyways, unless we use placeholder data
        $('.notif-holder').empty();

        //Create notifications
        const data = doc.data().notifications;

        if (data.length === 0) {
            // If data array is empty, add an h3 element to notif-holder
            $('.notif-holder').prepend($('<h3>', { text: 'No notifications available!', class: 'empty-notif' }));
        } 
        else {
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
            }
        }
    }
}

//for createBox
//makes it look a bit nicer IMO.
var isFlipped = false;


//// BOX thing generator. These are visible on the device list!
function createBox(data) {

    // Create elements
    const row = document.createElement("div");
    row.classList.add("row");
  
    const col8 = document.createElement("div");
    col8.classList.add("col");
  
    const iframe = document.createElement("iframe");
    iframe.src = `https://www.google.com/maps/embed/v1/view?key=${maps_api}&center=${data.location.latitude},${data.location.longitude}&zoom=13`;
    iframe.classList.add("h-100", "w-100");
    iframe.style.border = "0";
    iframe.setAttribute("allowfullscreen", "");
    iframe.setAttribute("loading", "lazy");
  
    col8.appendChild(iframe);
  
    const col4 = document.createElement("div");
    col4.classList.add("col");
  
    const innerRow = document.createElement("div");
    innerRow.classList.add("row");
  
    const innerCol = document.createElement("div");
    innerCol.classList.add("col");
  
    // Create form outlines
    const formOutlines = ["Device name: " + data.deviceName, "Organization: " + data.organizationName , "Street: " + data.street, "Lat: " + data.location.latitude + "  Long: " + data.location.longitude];
    formOutlines.forEach((labelText) => {
      const formOutline = document.createElement("div");
      formOutline.classList.add("form-outline", "mb-4");
  
      const label = document.createElement("label");
      label.classList.add("form-label");
      label.textContent = labelText;
  
      formOutline.appendChild(label);
      innerCol.appendChild(formOutline);
    });
  
    // Create button
    const button = document.createElement("button");
    button.type = "submit";
    button.classList.add("btn", "btn-primary", "mb-5", "mb-md-0");
    button.setAttribute("data-mdb-button-init", "");
    button.setAttribute("data-mdb-ripple-init", "");
    button.textContent = "Fill This Box";
    button.onclick = function() {
        window.location.href = siteUrl + "/admin-fill-box-" + data.organizationName + "-" + data.deviceName + "/";
    };
  
    innerCol.appendChild(button);
    innerRow.appendChild(innerCol);
    col4.appendChild(innerRow);

    if (isFlipped) {
        row.appendChild(col4);
        row.appendChild(col8);
        isFlipped = false;
    }
    else {
        row.appendChild(col8);
        row.appendChild(col4);
        isFlipped = true;
    }
    return row;
  }

  //function to append boxes to a container
  function appendBoxes(container, boxData) {
      const box = createBox(boxData);
      container.appendChild(box);
      const hr = document.createElement("hr");
      container.appendChild(hr);
  }

  //function to create and upload a "open box"-code
  //first connecting an eventListener to it
  document.addEventListener('DOMContentLoaded', (event) => {
    // Get a reference to the button element
    const openBoxesButton = document.getElementById('openBoxesButton');

    // Attach an event listener to the button
    openBoxesButton.addEventListener('click', () => {
        openAllBoxes().catch(error => {
            console.error('Error running openAllBoxes:', error);
        });
    });
});


  async function openAllBoxes() {
    //Get collection/document using site URL
    if(currentUrl.includes("/admin-fill-box")) {
        var urlSplit = currentUrl.split("/");
        var firestorePath = urlSplit[3].split("-");
        
        var orgpath = firestorePath[3].charAt(0).toUpperCase() + firestorePath[3].slice(1);
        var maticpath = firestorePath[4].charAt(0).toUpperCase() + firestorePath[4].slice(1);
        
        const collectionRef = db.collection(orgpath);
        const documentRef = collectionRef.doc(maticpath);
        const doc = await documentRef.get();

        //IF doc exists, get the number of boxes, divide by 48 (max count) and floor the value.
        if (doc.exists) {
            const boxes = doc.data().box;
            const boxesLength = boxes.length;
            console.log(boxesLength);

            let cuCount = Math.floor(boxes.length / 48);

            const newOrderMap = {};
    
            //Create a "open all" code for each control unit
            for (let a = 0; cuCount >= a; a++) {
                const lastByte = (134 + a);
                let newOrderCode = "2 " + a + " 48 81 03 " + lastByte;
                console.log(newOrderCode);
                newOrderMap[a] = newOrderCode;
            }
            
              // Add the entries to the "orders" map field. Doesn't allow duplicates
              documentRef.update({
                orders: newOrderMap
            }).then(() => {
                console.log('Order entries added successfully!');
            }).catch((error) => {
                console.error('Error adding order entries: ', error);
            });
              
             // Add the entries to the "orders" map field. Allows duplicates to be added
             /*
              documentRef.get().then((doc) => {
                if (doc.exists) {
                  const orders = doc.data().orders || [];
                  orders.push(newOrderMap); // Append the new entry, allowing duplicates
                  documentRef.update({
                    'orders': orders
                  }).then(() => {
                    console.log('Order entry added successfully!');
                  }).catch((error) => {
                    console.error('Error adding order entry: ', error);
                  });
                } else {
                  console.error('No such document!');
                }
              }).catch((error) => {
                console.error('Error getting document:', error);
              });
              */
        }
    }
  }