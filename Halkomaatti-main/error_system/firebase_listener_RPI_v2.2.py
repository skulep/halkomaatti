import firebase_admin
from firebase_admin import credentials, firestore
#from firebase_admin import firestore
import time
import math
import serial
from send_error_log import send_error_to_firestore
from firebase_init import Firebase, Document, Collection
#Tested on Win10
#Python 3.9.7

db_instance = Firebase()
db = db_instance.db

document_instance = Document()
document_instance.init()
doc_name = document_instance.get()

collection_instance = Collection()
collection_instance.init()
col_name = collection_instance.get()

doc_ref = db.collection(col_name).document(doc_name)

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
	#print("sendit: ", sendit)
	print("Opening door with code: {}, bytestring {}".format(data, sendit))

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
	# Checks for orders that are already present. If found, will send requests to open these locks.
	# For this reason, it can cause issues but in most cases this will be useful.
	try:
		doc_snapshot = doc_ref.get()
		if doc_snapshot.exists:
			try:
				orders = doc_snapshot.get('orders')
				if orders:
					for order_details in orders.items():
						print(f'Existing order: {order_details}')
						
						open_doors(order_details)
						time.sleep(2)
					doc_ref.update({"orders": firestore.DELETE_FIELD})
					print('deleted orders')
			#don't send error if there is no errors on startup
			except Exception as e:
				print(f'Order missing: {e}')
	except Exception as e:
		print(f'Error fetching initial orders: {e}')
		send_error_to_firestore(e)
			
	def on_snapshot(query_snapshot, changes, read_time):
		for doc_change in changes:
			if doc_change.type.name == 'MODIFIED':
				print('doc changed going agane')
				try:
					orders=doc_change.document.get('orders')
					if orders:
						for order_details in orders.items():
							print(f'orders on change: {order_details}')
							
							open_doors(order_details)
							time.sleep(2) # Try different values here - number is in seconds
						#Clear all orders after processing them and opening the locks		
						doc_ref.update({"orders": firestore.DELETE_FIELD})			
				except Exception as e:
					print(f'Error processing orders: {e}')
					send_error_to_firestore(e)
	doc_watch = doc_ref.on_snapshot(on_snapshot)



# Begin the listener
listen_for_changes()

while True:
    time.sleep(5)
    print('waiting...')
