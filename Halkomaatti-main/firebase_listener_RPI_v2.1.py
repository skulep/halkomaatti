import firebase_admin
from firebase_admin import credentials, firestore
#from firebase_admin import firestore
import time
import math
import serial

#Tested on Win10
#Python 3.9.7

creds = credentials.Certificate("ServiceAccountKey.json")
firebase_admin.initialize_app(creds)

org = 'Beiarnkommune'
halkomatic = 'Tverrvik'

db = firestore.client()
doc_ref = db.collection(org).document(halkomatic)

#Searches for itemID in boxes
#Usage: itemID, Organization/Boxname(in this format)
def open_doors(order_details):
	#Result seems to be in tuple
	#Seperating them first
	command, data = order_details

	x = data.split()
	x2 = [int(i) for i in x]
	#print("x value: ", x) #Debugging purposes
	#print("x2 value: ", x2)
	sendit = bytes([x2[0],x2[1],x2[2],x2[3],x2[4],x2[5]])
	print("sendit: ", sendit)

	# Define the serial port parameters
	ser = serial.Serial(
		port='/dev/ttyUSB0',
		baudrate=19200,
		bytesize=serial.EIGHTBITS,
		parity=serial.PARITY_NONE,
		stopbits=serial.STOPBITS_ONE
	)

	# Open the serial port
	ser.close()
	ser.open()

	ser.write(sendit)
		
	# Close the serial port when you're done
	ser.close()

def listen_for_changes():
	print("Listener open. Waiting on changes")
	def on_snapshot(query_snapshot, changes, read_time):
		for doc_change in changes:
			if doc_change.type.name == 'MODIFIED':
				try:
					orders=doc_change.document.get('orders')
					if orders:
						for order_details in orders.items():
							print(f'{order_details}')
							print("Opening door...")
							open_doors(order_details)
							time.sleep(5) # Try different values here - number is in seconds
					#Clear all orders after processing them and opening the locks		
					doc_ref.update({"orders": firestore.DELETE_FIELD})			
				except Exception as e:
					print(f'Error processing orders: {e}')
	doc_watch = doc_ref.on_snapshot(on_snapshot)

listen_for_changes()

while True:
    time.sleep(5)
    print('waiting...')
