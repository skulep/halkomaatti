import firebase_admin
from firebase_admin import credentials, firestore
#from firebase_admin import firestore
import time
import math
import serial

creds = credentials.Certificate("ServiceAccountKey.json")
firebase_admin.initialize_app(creds)

org = 'Beiarnkommune'
halkomatic = 'Tverrvik'

db = firestore.client()
doc_ref = db.collection(org).document(halkomatic)

#Searches for itemID in boxes
#Usage: itemID, Organization/Boxname(in this format)
def open_doors(order_details):	
	
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
	x=order_details.split()
	x2 = [eval(i) for i in x]
	print(x)
	print(x2)
	sendit = bytes([x2[0],x2[1],x2[2],x2[3],x2[4],x2[5]])
	print(sendit)
	ser.write(sendit)
		
	# Close the serial port when you're done
	ser.close()

def listen_for_changes():
	print("Listener open. Waiting on changes")
	def on_snapshot(query_snapshot, changes, read_time):
		for doc_change in changes:
			if doc_change.type.name == 'MODIFIED':
				try:
					print('Flag 1')
					orders=doc_change.document.get('orders')
					print('Flag 2')
					for order_details in orders.items():
						print(f'{order_details}')
						open_doors(order_details)
						time.sleep(1)
				except:
					print('no orders')
		doc_ref.update({"orders": firestore.DELETE_FIELD})				
	doc_watch = doc_ref.on_snapshot(on_snapshot)

listen_for_changes()

while True:
    time.sleep(5)
    print('waiting...')
