import firebase_admin
from firebase_admin import credentials, firestore
import time
import math
import serial
import os
import time

creds = credentials.Certificate("ServiceAccountKey.json")
firebase_admin.initialize_app(creds)

## Get Firestore data using config.txt
cwd = os.getcwd()
try:
	filePath = os.path.join(cwd, "config.txt")
	with open(filePath, 'r') as f:
		lines = f.readlines()
		# Check if the file has at least two lines
		if len(lines) >= 2:
			orgName = lines[0].strip()
			deviceName = lines[1].strip()
		else:
			print("File does not have enough lines. Please make sure config.txt is unmodified.")
			f.close() #closing the file just in case. not sure if this matters at all.
			time.sleep(5)
			exit() #exiting application

	f.close()

except FileNotFoundError:
    print("There is no config file. Please create one using setup.py, or duplicate it from elsewhere.")
    time.sleep(5)
    exit()

db = firestore.client()
doc_ref = db.collection(orgName).document(deviceName)

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
	print('Listener open at ' + orgName +'/'+ deviceName + '. Waiting on changes')
	def on_snapshot(query_snapshot, changes, read_time):
		doc_ref.update({"orders": firestore.DELETE_FIELD})
		for doc_change in changes:
			if doc_change.type.name == 'MODIFIED':
				try:
					orders=doc_change.document.get('orders')
					for order_id, order_details in orders.items():
						print(f'{order_details}')
						open_doors(order_details)
						time.sleep(1)
				except:
					print('no orders')
						
	doc_watch = doc_ref.on_snapshot(on_snapshot)

listen_for_changes()

while True:
    time.sleep(5)
    print('waiting...')
