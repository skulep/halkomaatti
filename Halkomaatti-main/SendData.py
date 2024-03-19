import firebase_admin
from firebase_admin import credentials
from firebase_admin import firestore
import datetime

#päivämäärä päivityksiä varten
date = datetime.datetime.now()

#firebaseAddr = firebase.FirebaseApplication('https://console.firebase.google.com/project/halkomaatti/database/halkomaatti-default-rtdb/data/~2F', None)

creds = credentials.Certificate("ServiceAccountKey.json")
firebase_admin.initialize_app(creds)

db = firestore.client()
#dbRef = db.collection('Organizations').document('m3TYOAxlveJJqvH6qZ4X').collection('Halkomatics').document('2FAQdEgvCMerkGnTJBoTnf').name
dbRef = db.collection('test-data').document('users')

name = input("Enter name: ")
email = input("Enter email: ")
orgId = input("Enter ID of organization: ")

if not name or not email or not orgId:
    print(type(email))
    print("Please try again.")
  
else:
    dbRef.update({

        name:{
            "email": email,
            "org-id": orgId,
            "notifs": True

        }

    })   
print('Data sent!')
print(date)





'''
Lukee datan ja printtaa sen formatoituna
matics = db.collection('test-data').where('location', '==', 'Oslo').stream()



for matic in matics:
    print('{} => {}'.format(matic.id,matic.to_dict()))
'''

