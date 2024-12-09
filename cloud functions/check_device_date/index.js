/**
 * Import function triggers from their respective submodules:
 *
 * const {onCall} = require("firebase-functions/v2/https");
 * const {onDocumentWritten} = require("firebase-functions/v2/firestore");
 *
 * See a full list of supported triggers at https://firebase.google.com/docs/functions
 */

const {onRequest} = require("firebase-functions/v2/https");
const logger = require("firebase-functions/logger");
// The Firebase Admin SDK to access Firestore.
const {initializeApp} = require("firebase-admin/app");
const {getFirestore} = require("firebase-admin/firestore");
const { onSchedule } = require("firebase-functions/v2/scheduler");
const sendEmail = require('./sendEmail');


initializeApp();
const db = getFirestore();

// Create and deploy your first functions
// https://firebase.google.com/docs/functions/get-started

//for testing delete when deployed.
exports.manualTrigger = onRequest(async (req, res) => {
   await exports.checkDeviceDate.run();  // Manually trigger the onSchedule function
    
    console.log("Manually call onSchedule");
    res.send("called on schedule");
});

exports.checkDeviceDate = onSchedule("*/20 * * * *", async (event) => {
    const devicesRef = db.collection("Error_logs");
    const now = new Date();

    const snapshot = await devicesRef.get();
    if(snapshot.empty){
        return;
    }
    for (const doc of snapshot.docs) {
        const data = doc.data();
        const deviceName = doc.id;
        const lastSeen = data.lastSeen.toDate();
        const diffInMinutes = (now - lastSeen) / (1000 * 60);
        //change this to match raspberry's ping time. Now one minute for testing.
        if(diffInMinutes < 1) {
            logger.log(`device with name: ${deviceName} online. Last seen at: ${lastSeen}`);
            return;
        }
        try {
            const response = await sendEmail('Device offline', `Device: ${deviceName} offline. Last seen at: ${lastSeen}`);
            console.log(response);
        } catch (error){
            logger.log("Failed to send email:", error.message);
        }
        
    }
});