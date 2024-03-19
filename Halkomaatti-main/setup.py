import tkinter as tk
import os
import firebase_admin
from firebase_admin import credentials, firestore
from datetime import datetime

# Getting the current date and time
dt = datetime.now()

# getting the timestamp
ts = datetime.timestamp(dt)


####
# firebase setup
creds = credentials.Certificate("ServiceAccountKey.json")
firebase_admin.initialize_app(creds)

db = firestore.client()
db_ref = db.collection('Halkomatics')

# create window
window = tk.Tk()

# create label for name field
name_lbl = tk.Label(window, text="Name:")
name_lbl.grid(row=0, column=0)

# create text field for name
name_text = tk.Entry(window)
name_text.grid(row=0, column=1)

# create label for coordinates field
coordinates_lbl = tk.Label(window, text="Coordinates:")
coordinates_lbl.grid(row=1, column=0)

# create text field for coordinates
coordinates_text = tk.Entry(window)
coordinates_text.grid(row=1, column=1)

# create label for organization's name
org_lbl = tk.Label(window, text="Organization:")
org_lbl.grid(row=2, column=0)

# create text field for organization's name
org_text = tk.Entry(window)
org_text.grid(row=2, column=1)

# create label for address
address_lbl = tk.Label(window, text="Address:")
address_lbl.grid(row=3, column=0)

# create text field for address
address_text = tk.Entry(window)
address_text.grid(row=3, column=1)

# create label for number of doors
doors_lbl = tk.Label(window, text="Number of doors:")
doors_lbl.grid(row=4, column=0)

# create text field for doors
doors_text = tk.Entry(window)
doors_text.grid(row=4, column=1)

# create label for number of doors
orgId_lbl = tk.Label(window, text="Org ID:")
orgId_lbl.grid(row=4, column=3)

# create text field for doors
orgId_text = tk.Entry(window)
orgId_text.grid(row=4, column=4)

# create a button to save the user inputed state
save_btn = tk.Button(window, text="Save", command=lambda:save_text())
save_btn.grid(row=5, column=1)

# function to save the user input to config.txt on desktop
def save_text():
    name = name_text.get()
    coordinates = coordinates_text.get()
    org = org_text.get()
    address = address_text.get()
    doors = doors_text.get()
    orgId = orgId_text.get()
    
    

    data = {
        "name": name,
        "org": org,
        "orgId" : orgId,
        "coordinates": coordinates,
        "address": address,
        "doors": doors,
        "battery": 0,
        "lastFilled": dt,
        "lastRPiPing": dt,        
        "lastUsed": dt,
        "boxes": {}
    }

    for x in range(1, int(doors) + 1):
        print(x)
        box_name = "box" + str(x)
        data["boxes"][box_name] = {
            "itemId": 1,
            "status": 0,
            "timestamp": 10
        }

    db_ref.document(name).set(data)


    #Additionally, create a field in "boxes" for each box.
    print('Data sent!')

    cwd = os.getcwd()
    filePath = os.path.join(cwd, "Desktop", "config.txt")
    f = open(filePath, 'w')
    f.write(f"{name}\n{coordinates}\n{org}\n{address}\n{doors}")
    print(f"{name}\n{coordinates}\n{org}\n{address}\n{doors}")
    f.close()

# run window
window.mainloop()
