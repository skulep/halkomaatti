import firebase_admin
import os
import json
from firebase_admin import credentials, firestore
from datetime import datetime
from firebase_init import Firebase, Document, Collection

db_instance = Firebase()
db = db_instance.db

document_instance = Document()
document_instance.init()
doc_name = document_instance.get()

doc_ref = db.collection('Error_logs').document(doc_name)

def save_error_locally(message):
	error_data = {
	'message' : f'{message}',
	'timestamp' : datetime.now().isoformat()
	}
	
	if not os.path.exists('error_logs.json'):
		with open('error_logs.json', 'w') as log_file:
			json.dump([error_data], log_file)
			print('created file and added new entry')
	else:
		with open('error_logs.json', 'r+') as log_file:
			logs = json.load(log_file)
			logs.append(error_data)
			log_file.seek(0)
			json.dump(logs, log_file)
			print('saved to file')
			
def send_error_to_firestore_from_file():
	if not os.path.exists('error_logs.json'):
		print('No errors to send')
		return
	with open('error_logs.json', 'r') as log_file:
		logs = json.load(log_file)
		try:
			print('sending data from file...');
			for log in logs:
				doc_ref.update({
				'logs': firestore.ArrayUnion([log])
				})
				print(f'log updated to firestore: {log}')
			os.remove('error_logs.json')
			print('Json file deleted')
		except Exception as e:
			print(f'Send error to firestore from file failed: {e}')

def ping_firestore():
	try:
		doc_ref.set({'lastSeen': datetime.now().astimezone()}, merge=True)
	except Exception as e:
		print(f'Error with pinging: {e}')

def send_error_to_firestore(message):
	try:
		error_data = {
		'message' : f'{message}',
		'timestamp' : datetime.now().astimezone()
		}
		
		doc_ref.set({
		'logs': firestore.ArrayUnion([error_data])
		}, merge=True)
	except Exception as e:
		print(f'Failed to send to Firestore: {e}. Saving to file')
		save_error_locally(message)
