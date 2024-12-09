import time
import socket
from send_error_log import send_error_to_firestore, send_error_to_firestore_from_file, ping_firestore

last_connection_status = True

def is_connected(host, port, timeout):
	try:
		socket.setdefaulttimeout(timeout)
		socket.socket(socket.AF_INET, socket.SOCK_STREAM).connect((host, port))
		return True, None
	except socket.error as e:
		return False, e
	
def check_connection():
	global last_connection_status
	while True:
		connected, error = is_connected('8.8.8.8',53,10)
		
		if connected:
			print('Connection up')
			send_error_to_firestore_from_file()
			ping_firestore()
			last_connection_status = True
			
		else:
			error_log = f'Connection lost: {error}'
			print(error_log)
			if last_connection_status:
				send_error_to_firestore(error_log)
				last_connection_status = False
			
		time.sleep(20)

check_connection()
