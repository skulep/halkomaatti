import os
import time
import firebase_admin
from firebase_admin import credentials
from firebase_admin import db
import serial

# set a variable to the path of the USB drive
# may have to be changed later to specific usb-drive name
usb_path = "/media/usbdrive"

# Initialize Firebase
cred = credentials.Certificate('path/to/serviceAccountKey.json')
firebase_admin.initialize_app(cred, {
    'databaseURL': 'https://your-database.firebaseio.com/'
})

# Initialize RS485 serial connection
ser = serial.Serial('/dev/ttyUSB0', baudrate=19200, bytesize=serial.EIGHTBITS, stopbits=serial.STOPBITS_ONE)

# Define the function to open the electronic lock
def open_lock():
    packet = bytearray(32)  # Create a 32-byte packet
    # TODO: Set the necessary bytes in the packet to open the lock
    
    # Write the packet to the RS485 bus
    ser.write(packet)

# Listen for updates on the Firebase database
ref = db.reference('path/to/variable')

def handle_event(event):
    if event.data == 1:
        open_lock()

# Register the event listener
event_stream = ref.listen(handle_event)

# loop forever
while True:
    # check if the usb path exists
    if os.path.isdir(usb_path):
        # if the usb path exists, run the installer.py program
        os.system("python installer.py")
    # wait 5 seconds
    time.sleep(20)

# Keep the program running
while True:
    pass
