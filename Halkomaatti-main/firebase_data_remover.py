import tkinter as tk
from tkinter import *
import struct
import serial
import tkinter.messagebox
import os
import firebase_admin
from firebase_admin import credentials, firestore
from datetime import datetime, timezone, timedelta

# Getting the current date and time
dt = datetime.now()

# getting the timestamp
ts = datetime.timestamp(dt)


####
# firebase setup
creds = credentials.Certificate("ServiceAccountKey.json")
firebase_admin.initialize_app(creds)

db = firestore.client()

# create window
window = tk.Tk()
window.title("FirebaseDataRemover")


#lock number text field + label
collection_lbl = tk.Label(window, text="Collection Name: ")
collection_lbl.grid(row=0, column=0)
collection_text = tk.Entry(window)
collection_text.grid(row=0, column=1)

#cu text field + label
document_lbl = tk.Label(window, text="Document Name:")
document_lbl.grid(row=1, column=0)
document_text = tk.Entry(window)
document_text.grid(row=1, column=1)


# create a button to save the user inputed state
save_btn = tk.Button(window, text="Clear ALL Orders", command=lambda:clear_orders())
save_btn.grid(row=7, column=0)

upl_btn = tk.Button(window, text="Clear Notifications", command=lambda:clear_selected_notifications())
upl_btn.grid(row=7, column=1)

upl_btn = tk.Button(window, text="Help", command=lambda:help())
upl_btn.grid(row=7, column=2)

def help():
    tk.messagebox.showinfo(title="Help", message='Clear Orders - clears the whole "orders"-collection. \n\nClear Notifications - Enter the collection and Document names. It will clear all notifications older than 1 week.\n\nThis may take a while! There will be a notification once successfully deleted.')



# function to save the user input to config.txt on desktop
def clear_orders():
    doc_ref = db.collection('orders')
    docs = doc_ref.stream()

    for doc in docs:
        doc.reference.delete()

    tk.messagebox.showinfo(title="Success", message='Cleared orders')


def clear_selected_notifications():
    

    collectionStr = collection_text.get()
    documentStr = document_text.get()
    doc_ref = db.collection(collectionStr).document(documentStr)


    if not all([documentStr, collectionStr]):
        tk.messagebox.showerror(title="Error", message='One of the required values is null')
        return
    
    doc = doc_ref.get()
    if doc.exists:
        data = doc.to_dict()
        notifications = data.get('notifications', [])
        cutoff_timestamp = datetime.now(timezone.utc) - timedelta(days=7)  # Y/D/M format. Current date - a week
        filtered_notifications = [notification for notification in notifications if notification.get("timestamp") >= cutoff_timestamp]

        print(filtered_notifications)
        doc_ref.update({"notifications": filtered_notifications})

        tk.messagebox.showinfo(title="Success", message='Removed data from' + collectionStr + '/' + documentStr)





label = Label(window)
label.grid()

# run window
window.mainloop()