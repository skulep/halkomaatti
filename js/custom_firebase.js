//Custom firestore/firebase functions

/*
async function getTestData(db) {
    const testDataCol = collection(db, 'test-data');
    const testDataSnapshot = await getDocs(testDataCol);
    const testList = testDataSnapshot.docs.map(doc => doc.data());
    print(testList);
    return testList;
}*/
/*

(function ($) {
    'use strict';
    $(document).ready(function () {
        const showFirestoreDatabase = () => {
            const db = firebase.firestore();
            const firestoreEl = jQuery('#custom-firebase');
        
            // You can get the collectionName and documentName from the shortcode attribute
            const collectionName = 'test-data';
            const documentName = 'users'
        
            if (collectionName && documentName) {
                const docRef = db.collection(collectionName).doc(documentName);
        
                docRef.get().then(snapshot => {
                    snapshot.forEach (doc => {
                        let userData = doc.data();
                        console.log(userData);
                    })
                    
                    if (doc.exists) {

                        //do code here
                        console.log('Document data2:', doc.data());


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

//Get Box info and create Box buttons

