import firebase_admin
from firebase_admin import credentials
from firebase_admin import firestore
import datetime

#päivämäärä päivityksiä varten
date = datetime.datetime.now()
 
#kredut ja firebasen määritykset
creds = credentials.Certificate("ServiceAccountKey.json")
firebase_admin.initialize_app(creds)
db= firestore.client()
dbRef = db.collection('test-data').document('users')

data = dbRef.get().to_dict()

#wantedKey = str(input("Give desired organization: "))


doc_ref = db.collection('test-data').document('users')


#
#for key, value in data.items():

#    print("key  "+ key)
#
#    if(value["org-id"] == wantedKey):
#        print(key, "=", value)
#