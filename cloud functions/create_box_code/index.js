// const {onRequest} = require("firebase-functions/v2/https");
const logger = require("firebase-functions/logger");

const {onDocumentCreated} = require("firebase-functions/v2/firestore");

// The Firebase Admin SDK to access Firestore.
const {initializeApp} = require("firebase-admin/app");
const {getFirestore} = require("firebase-admin/firestore");

initializeApp();
const db = getFirestore();

// Listens for new messages added to /messages/:documentId/original
// and saves an uppercased version of the message
// to /messages/:documentId/uppercase
exports.makeboxcode = onDocumentCreated("/orders/{orderId}", (event) => {
  // grabing the current value of what was written to Firestore.

  const eventData = event.data.data();
  const dataLength = eventData.orders.length;
  let updatedBoxes = [];
  let num0 = 0;

  for (let i = 0; i < dataLength; i++) {
    const organization = eventData.orders[i].categories[0];
    const boxname = eventData.orders[i].categories[1];
    const orderId = eventData.orders[i].id;

    const quantity = eventData.orders[i].quantity;
    // Place ^ somewhere useful

    const workingDb = db.collection(organization).doc(boxname);

    // Accessing the parameter `{documentId}` with `event.params`
    workingDb.get()
        .then(
            (doc) => {
              if (doc.exists) {
                const boxes = doc.data().box;
                if (num0 == 0) {
                  updatedBoxes = [...boxes];
                  num0 = 1;
                }
                logger.log(updatedBoxes);

                const orderUpdates = {};

                for (let j = 0; j < quantity; j++) {
                  const picked = updatedBoxes
                      .find((o) => o.id === orderId && o.state === 0);

                  if (picked) {
                    const index = updatedBoxes.indexOf(picked);
                    // Generate Box Code
                    // Note: byte1=2 and byte5=3 const
                    // Max boxes each CU=48.
                    // Boxnum will be value between 0-47, correct?
                    // This means it will generate those values each cu
                    const cuAdd = Math.floor(i/48);
                    const boxNum = index - (cuAdd * 48);
                    const command = 81;
                    const byteSum = (cuAdd + boxNum + command + 5);
                    const byteArr = [2, cuAdd, boxNum, command, 3, byteSum];
                    const genBoxCode = byteArr.join(" ");

                    // Editing this -- use old if its fucked up again
                    /*
                    orderUpdates[index] = genBoxCode;
                    picked.state = 1; // Change the state to 1
                    */
                    orderUpdates[`orders.${index}`] = genBoxCode;
                    updatedBoxes[index].state = 1;
                  }
                }
                workingDb.update({
                  box: updatedBoxes,
                  // orders: orderUpdates,
                  ...orderUpdates,
                });
              } else {
                logger.log("No such document");
              }
            },
        )
        .catch((error) => {
          logger.log("Error getting data: ", error);
          // response.send(error)
        });
  }

  // Add date to order once finished
  const timestamp = Number(new Date());
  const date = new Date(timestamp);
  return event.data.ref.set({date}, {merge: true});
});
