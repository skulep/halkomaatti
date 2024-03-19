import firebase_admin
from firebase_admin import credentials, firestore
#from firebase_admin import firestore

creds = credentials.Certificate("ServiceAccountKey.json")
firebase_admin.initialize_app(creds)

db = firestore.client()
users_ref = db.collection('users')


#data = users_ref.get().to_dict()
#print(data)


u_choice_input = input("1. Add User Data: \n2. Get User Data: \n")
if (u_choice_input == "1"):
    name = input("Enter name: ")
    email = input("Enter email: ")
    orgId = input("Enter ID of organization: ")

    if not name or not email or not orgId:
        print("Please try again.")
    
    else:
        users_ref.document(name).set({
            "email": email,
            "org-id": orgId,
            "notifs": True
        })   
    print('Data sent!')

if (u_choice_input == "2"):
    user_email = input("Enter user email: ")
    query = users_ref.where("email", "==", user_email)
    results = query.get()

    for doc in results:
        data = doc.to_dict()
        print(data)

else:
    print("\nIncorrect input")




