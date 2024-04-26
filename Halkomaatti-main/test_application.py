import tkinter as tk
from tkinter import *
import struct
import serial
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

# create window
window = tk.Tk()
window.title("KerongLockTester")


#lock number text field + label
num_lbl = tk.Label(window, text="Lock num: ")
num_lbl.grid(row=0, column=0)
num_text = tk.Entry(window)
num_text.grid(row=0, column=1)

#cu text field + label
cu_lbl = tk.Label(window, text="Control Unit num:")
cu_lbl.grid(row=1, column=0)
cu_text = tk.Entry(window)
cu_text.grid(row=1, column=1)

t_lbl = tk.Label(window, text="Choose action:")

def selection():
   selected = "Current option: " + str(var.get())
   label.config(text=selected)

var = IntVar()

rb1 = Radiobutton(window, text="Open lock", variable=var, value=81)
rb1.grid(row=2, column=0, sticky="W")
rb2 = Radiobutton(window, text="Read lock", variable=var, value=80)
rb2.grid(row=2, column=1, sticky="W")

#com text field + label. + default text.
com_lbl = tk.Label(window, text="COM port (commonly 4 or 3):")
com_lbl.grid(row=3, column=0)
com_text_def = tk.StringVar()
com_text_def.set("4")
com_text = tk.Entry(window, textvariable=com_text_def)
com_text.grid(row=3, column=1)

# create a button to save the user inputed state
save_btn = tk.Button(window, text="Open Selected Box", command=lambda:test_lock())
save_btn.grid(row=7, column=0)

upl_btn = tk.Button(window, text="Test Firebase", command=lambda:test_firebase())
upl_btn.grid(row=7, column=1)

upl_btn = tk.Button(window, text="Help", command=lambda:help())
upl_btn.grid(row=7, column=2)

def help():
    tk.messagebox.showinfo(title="Help", message='Fill in the text fields. \nLock number will start count from 0, so typing in 0 will open lock number 1. \nOpening lock num 48 will open all locks connected to the selected control unit.\nThe "Test Firebase"-button will only fetch one result to see if everything is functional. \nThe COM port is often 3 or 4, but you may need to find out which one you are using.')



# function to save the user input to config.txt on desktop
def test_lock():
    CUAddress = cu_text.get()
    LockNum = num_text.get()
    comPort = com_text.get()
    Command = var.get()

    if not all([CUAddress, LockNum, comPort, Command]):
        tk.messagebox.showerror(title="Error", message='One of the required values is null')
        return

    byte1 = 2
    byte2 = int(CUAddress)
    byte3 = int(LockNum)
    byte4 = int(Command)
    byte5 = 3
    byteSum = (byte1 + byte2 + byte3 + byte4 + byte5)
    sendit = bytes([byte1, byte2, byte3, byte4, byte5, byteSum])
    print(byte1, " ", byte2, " ", byte3, " ", byte4, " ", byte5, " ", byteSum)

    serPort = 'COM' + str(comPort)
    print(serPort)

    # Define the serial port parameters
    ser = serial.Serial(
        port = serPort,
        baudrate=19200,
        bytesize=serial.EIGHTBITS,
        parity=serial.PARITY_NONE,
        stopbits=serial.STOPBITS_ONE
    )

    # Open the serial port
    ser.close()
    ser.open()

    if byte4==81:
        ser.write(sendit)
        tk.messagebox.showinfo(title="Success", message='Successfully sent hexcode ' + sendit) 
    elif byte4==80:
        ser.write(sendit)
        response = ser.read(12)
        tk.messagebox.showinfo(title="Success, received response", message=response)
        hex_values = [f'\\x{byte:02x}' for byte in response]

        i = 1
        for value in hex_values:
            print(f"byte {i}: {value}")
            print(f"byte {i} as integer: {int(value[2:], 12)}")
            i = i + 1
    else:
        print("Command byte is incorrect! It needs to be 0x50 to read state or 0x51 to open")

    # Close the serial port when you're done
    ser.close()

def test_firebase():
    print("testing firebase connection")
    doc_ref = db.collection('listOfOrganization').document('listOfDevices')

    doc_snapshot = doc_ref.get()

    # Check if the document exists
    if doc_snapshot.exists:
        # Get the 'list' field from the document
        list_data = doc_snapshot.to_dict().get('list', [])
        
        print(list_data)
        tk.messagebox.showinfo(title="Success, listing first result", message=list_data[0])

    else:
        print('Document does not exist')


    

label = Label(window)
label.grid()

# run window
window.mainloop()