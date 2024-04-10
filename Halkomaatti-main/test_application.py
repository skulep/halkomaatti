import tkinter as tk
from tkinter import *
import struct
import serial
import tkinter.messagebox
import os
#import firebase_admin
#from firebase_admin import credentials, firestore
from datetime import datetime

# Getting the current date and time
dt = datetime.now()

# getting the timestamp
ts = datetime.timestamp(dt)


####
# firebase setup
#creds = credentials.Certificate("ServiceAccountKey.json")
#firebase_admin.initialize_app(creds)

#db = firestore.client()

# create window
window = tk.Tk()
window.title("Vedogvarer Config")


# create label for organization's name
num_lbl = tk.Label(window, text="lock num: ")
num_lbl.grid(row=0, column=0)

# create text field for organization's name
num_text = tk.Entry(window)
num_text.grid(row=0, column=1)

# create label for name field
cu_lbl = tk.Label(window, text="cu num:")
cu_lbl.grid(row=1, column=0)

# create text field for name
cu_text = tk.Entry(window)
cu_text.grid(row=1, column=1)
t_lbl = tk.Label(window, text="choose action:")

def selection():
   selected = "You selected the option " + str(var.get())
   label.config(text=selected)

var = IntVar()

rb1 = Radiobutton(window, text="Open box", variable=var, value=81, command=selection)
rb1.grid(row=2, column=0, sticky="W")
rb2 = Radiobutton(window, text="Read box", variable=var, value=80, command=selection)
rb2.grid(row=2, column=1, sticky="W")
# Loop is used to create multiple Radiobuttons
# rather than creating each button separately

# create a button to save the user inputed state
save_btn = tk.Button(window, text="Open Selected Box", command=lambda:save_text())
save_btn.grid(row=6, column=1)

upl_btn = tk.Button(window, text="Upload to Firebase", command=lambda:test_firebase())
upl_btn.grid(row=7, column=1)


# function to save the user input to config.txt on desktop
def save_text():
    CUAddress = cu_text.get()
    LockNum = num_text.get()

    Command = var.get()
    byte1 = 2
    byte2 = int(CUAddress)
    byte3 = int(LockNum)
    byte4 = int(Command)
    byte5 = 3
    byteSum = (byte1 + byte2 + byte3 + byte4 + byte5)
    sendit = bytes([byte1, byte2, byte3, byte4, byte5, byteSum])
    print(byte1, " ", byte2, " ", byte3, " ", byte4, " ", byte5, " ", byteSum)

    # Define the serial port parameters
    ser = serial.Serial(
        port='COM4',
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
    elif byte4==80:
        ser.write(sendit)
        response = ser.read(12)
        print(response)
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
    

label = Label(window)
label.grid()

# run window
window.mainloop()