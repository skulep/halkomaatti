import tkinter as tk
import json
import tkinter.messagebox
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
#db_ref = db.collection('Halkomatics')

# create window
window = tk.Tk()
window.title("Vedogvarer Config")


# create label for organization's name
org_lbl = tk.Label(window, text="Organization:")
org_lbl.grid(row=0, column=0)

# create text field for organization's name
org_text = tk.Entry(window)
org_text.grid(row=0, column=1)

# create label for name field
name_lbl = tk.Label(window, text="Name:")
name_lbl.grid(row=1, column=0)

# create text field for name
name_text = tk.Entry(window)
name_text.grid(row=1, column=1)

# create label for coordinates field
coordinates_lbl = tk.Label(window, text="Coordinates:")
coordinates_lbl.grid(row=2, column=0)

# create text field for coordinates
coordinates_text = tk.Entry(window)
coordinates_text.grid(row=2, column=1)

# create label for address
address_lbl = tk.Label(window, text="Address:")
address_lbl.grid(row=3, column=0)

# create text field for address
address_text = tk.Entry(window)
address_text.grid(row=3, column=1)

# create label for number of doors
doors_lbl = tk.Label(window, text="Number of boxes:")
doors_lbl.grid(row=4, column=0)

# create text field for doors
doors_text = tk.Entry(window)
doors_text.grid(row=4, column=1)

# create a button to save the user inputed state
save_btn = tk.Button(window, text="Create Config File", command=lambda:save_text())
save_btn.grid(row=5, column=1)

upl_btn = tk.Button(window, text="Upload to Firebase", command=lambda:upload_to_firebase())
upl_btn.grid(row=6, column=1)


# function to save the user input to config.txt on desktop
def save_text():
    name = name_text.get().capitalize()
    coordinates = coordinates_text.get()
    org = org_text.get().capitalize()
    address = address_text.get()
    doors = doors_text.get()
    
    data = {
        "name": name,
        "org": org,
        "coordinates": coordinates,
        "address": address,
        "doors": doors,
        "battery": 0,
        #"lastFilled": dt,
        #"lastRPiPing": dt,        
        #"lastUsed": dt,
        "box": []
    }

    for x in range(1, int(doors) + 1):
        data["box"].append({
            "itemId": 1,
            "state": 1  # empty by default
        })

    jsonData = json.dumps(data)

    cwd = os.getcwd()
    filePath = os.path.join(cwd, "config.txt")
    f = open(filePath, 'w')
    f.write(f"{org}\n{name}\n{jsonData}")
    #print(f"{name}\n{coordinates}\n{org}\n{address}\n{doors}")
    f.close()

    tk.messagebox.showinfo(title="Config File Created!", message="A file called 'config.txt' was created in the current directory. Please move it to the same directory as firebaselistener.py, if it is not yet.")

def upload_to_firebase():
    cwd = os.getcwd()
    try:
        filePath = os.path.join(cwd, "config.txt")
        with open(filePath, 'r') as f:
            lines = f.readlines()
            # Check if the file has at least three lines
            if len(lines) >= 3:
                org = lines[0].strip()
                name = lines[1].strip()
                try:
                    data = json.loads(lines[2])
                except json.JSONDecodeError as e:
                    print("Error decoding JSON:", e)
                    return
            else:
                print("File does not have enough lines.")
        f.close()

        try:
            db.collection(org).document(name).set(data)
            tk.messagebox.showinfo(title="Success", message="Uploaded data to Firestore. You should see it there shortly")
        except Exception as e:
            print("Error uploading data to Firestore:", e)

    except:
        tk.messagebox.showerror(title="File not present", message="There is no config file. Please create one.")  




# run window
window.mainloop()
