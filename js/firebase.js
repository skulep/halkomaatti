//Integrates Firebase and carries the functions required

import { initializeApp } from 'https://www.gstatic.com/firebasejs/9.0.0/firebase-app.js';

// TODO: Replace the following with your app's Firebase project configuration



// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {

};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const analytics = getAnalytics(app);
const db = getFirestore(app);

async function getTestData(db) {
    const testDataCol = collection(db, 'test-data');
    const testDataSnapshot = await getDocs(testDataCol);
    const testList = testDataSnapshot.docs.map(doc => doc.data());
    print(testList);
    return testList;
}