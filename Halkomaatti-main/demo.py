import firebase_admin
from firebase_admin import credentials, firestore
#from firebase_admin import firestore
import time
import math
import serial

    #   Code will:
    # 1. Listen in on recent_orders -- OK, change path to, for example, Ankkalinna only
    # 2. On new order, scans boxes for item ID -- kind of ok? need to replace old one
    # 3. On item found, lists all boxes with that number
    # 4. On success, change said box "filled" -status. (to 2(?) - empty)
    #  

    # Fix: Make sure ADDED DOCUMENTS are also functional. easier to test with edits
    # Delete order document when successful. Reduces firestore bloat
    # 

creds = credentials.Certificate("ServiceAccountKey.json")
firebase_admin.initialize_app(creds)

db = firestore.client()
collection_ref = db.collection('orders')
doc_ref = db.collection('Halkomatics').document('Ankkalinna')

#Searches for itemID in boxes
#Usage: itemID, Organization/Boxname(in this format) 
def find_field_value():
    print("please give following info in integer format")
    lock_num = 1   #int(input("enter lock number: "))
    control_unit = lock_num // 48
    lock = lock_num % 48
    if lock == 0:
        control_unit -= 1
        lock = 47
    else:
        lock -= 1

    CUAddress = control_unit 
    LockNum = lock
    Command = int("81") #input("enter Command: ")
    byte1 = 2
    byte2 = int(CUAddress)
    byte3 = LockNum
    byte4 = int(Command)
    byte5 = 3
    byteSum = (byte1 + byte2 + byte3 + byte4 + byte5)
    sendit = bytes([byte1, byte2, byte3, byte4, byte5, byteSum])
    print(byte1, " ", byte2, " ", byte3, " ", byte4, " ", byte5, " ", byteSum)
    print(sendit)

    # Define the serial port parameters
    ser = serial.Serial(
        port='COM4',
        baudrate=19200,
        bytesize=serial.EIGHTBITS,
        parity=serial.PARITY_NONE,
        stopbits=serial.STOPBITS_ONE
    )
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
    # Open the serial port
    ser.close()

def listen_for_doc_changes():
    print("Listen for doc changes")
    def on_snapshot(query_snapshot, changes, read_time):
        for doc_change in changes:
            if doc_change.type.name == 'MODIFIED':
                find_field_value()
    query_watch = doc_ref.on_snapshot(on_snapshot)
                

def listen_for_changes():
    print("Listener open. Waiting on changes")
    def on_snapshot(query_snapshot, changes, read_time):
        for doc_change in changes:
            if doc_change.type.name == 'ADDED':
                find_field_value()
                print(f'Added document: {doc_change.document.id}')

            elif doc_change.type.name == 'MODIFIED':
                doc_data = doc_change.document.to_dict()
                orders = doc_data.get('orders')

                for order in orders:
                    #print(order)
                    order_id = order['id']
                    order_quantity = order['quantity']
                    order_organization = order['categories'][0]
                    order_boxname = order['categories'][1]              
                    #Path will be org + boxname. IT SHOULD HAVE BOTH FIELDS. Some testmatics do not. should be ok for now, just spits out a shit ton of errors...
                    order_path = order_organization + '/' + order_boxname
                    print(f'Modified document: {doc_change.document.id}, Field value: {orders}, Length: {len(orders)}')
                    #find_field_value() this actually works...

                
            elif doc_change.type.name == 'REMOVED':
                print(f'Removed document: {doc_change.document.id}')
    collection_watch = collection_ref.on_snapshot(on_snapshot)

#listen_for_changes()

listen_for_doc_changes()


while True:
    time.sleep(5)
    print('waiting...')
