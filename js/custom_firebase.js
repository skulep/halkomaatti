// Firebase Functions.
// Functions to add elements to sites, grab data from Firebase and other.

const { secrets } = require('./secret.js');

const consumer_key = secrets.consumer_key;
const consumer_secret = secrets.consumer_secret;
const maps_api = secrets.maps_api;

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
                $(this).addClass("empty");
                }
                else if ($(this).hasClass("empty")) {
                $(this).removeClass("empty");
                $(this).addClass("faulty");
                }
                else if ($(this).hasClass("faulty")) {
                $(this).removeClass("faulty");
                $(this).addClass("filled");
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
            const productData = new Map;

            getProductsInCategory(documentName)  //reminder documentName == location/device name so this should work.
                .then(products => {
                    if (products) {
                        const filteredProducts = filterProductsByCategory(products, documentName);
                        // Processing the found products 
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
            const listOfDevices = doc.data().list;  //Grabs the list of devices. array with map objects inside that have the required info for this.
            console.log(listOfDevices);
            listOfDevices.forEach(devData => {
                console.log("device data found: " + devData.deviceName, devData.organizationName, devData.location);
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

            console.log("ELEMENT ADDED to myDropdown:" + devData.deviceName);
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

            var dbUpdateStatus = false;

            db.collection(orgpath).doc(maticpath).set({
                notifications: firebase.firestore.FieldValue.arrayUnion(pushData),
                box: boxes
            }, {merge: true})

            .then(function() {
                console.log("Document successfully written!");
                dbUpdateStatus = true;
            })
            .catch(function(error) {
                console.error("Error writing document: ", error);
                dbUpdateStatus = false;
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

                        if (dbUpdateStatus) {
                            alert("Successfully updated Firestore state and WooCommerce stock. You can now close/exit this site.");
                        }
                        
                    })
                    .catch(error => {
                        console.error('Error updating product stock:', error);
                        alert("Error: Stock could not be updated successfully. Reload the page and retry.");
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


//Newer cleaner version of this. simple as.
function toggleDropdown() {
    console.log("yep");
    var dropdown = document.getElementById("myDropdown");
    if (dropdown.style.display === "none") {
        dropdown.style.display = "block";
    } else {
        dropdown.style.display = "none";
    }
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
            console.log("Attempting to change the BG image");
            var imageLink = doc.data().imageLink;
            // Attempting to change the background image URL
            topElement.style.backgroundImage = `url(${imageLink})`;
        }
        else {
            console.log("No custom image link provided, using default");
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

//// BOX thing generator. These are visible on the device list!
function createBox(data) {
    // Create elements
    const row = document.createElement("div");
    row.classList.add("row");
  
    const col8 = document.createElement("div");
    col8.classList.add("col-lg-8");
  
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
        window.location.href = "https://firewood2go.eu/index.php/admin-fill-box-" + data.organizationName + "-" + data.deviceName + "/";
    };
  
    innerCol.appendChild(button);
    innerRow.appendChild(innerCol);
    col4.appendChild(innerRow);
  
    row.appendChild(col8);
    row.appendChild(col4);
  
    return row;
  }

  //function to append boxes to a container
  function appendBoxes(container, boxData) {
      const box = createBox(boxData);
      container.appendChild(box);
      const hr = document.createElement("hr");
      container.appendChild(hr);
  }