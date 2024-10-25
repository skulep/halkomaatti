// Deletes all older (48 hrs) orders
// scheduled to auto-run every 2 days at 3am Norwegian time


// const functions = require("firebase-functions/v2");
const admin = require("firebase-admin");
const {onSchedule} = require("firebase-functions/v2/scheduler");


admin.initializeApp();

const db = admin.firestore();

exports.deleteOldOrders = onSchedule("0 3 * * *", async (event) => {
  const now = new Date();
  // current time -48 hrs d/h/m/s/ms
  const twoDaysAgo = new Date(now.getTime() - 2 * 24 * 60 * 60 * 1000);


  const ordersRef = db.collection("orders");
  // fetch all orders and compare date
  const snapshot = await ordersRef.where("date", "<", twoDaysAgo).get();

  const batch = db.batch();
  snapshot.forEach((doc) => {
    batch.delete(doc.ref);
  });

  await batch.commit();
});

