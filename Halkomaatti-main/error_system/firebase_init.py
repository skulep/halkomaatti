import os
import firebase_admin
from firebase_admin import credentials, firestore

class Firebase:
	_instance = None
	
	def __new__(cls):
		if cls._instance is None:
			cls._instance = super(Firebase, cls).__new__(cls)
		return cls._instance
		
	def __init__(self):
		if not hasattr(self, "initialized"):
			self.db = self.init()
			self.initialized = True
		
	def init(self):
		creds = credentials.Certificate("ServiceAccountKey.json")
		firebase_app = firebase_admin.initialize_app(creds)
		return firestore.client()
		
	def get(self):
		return self.db

class Document:
	def __init__(self):
		self.name = None
		
	def init(self):
		cwd = os.getcwd()
		filePath = os.path.join(cwd, "config.txt")
		with open(filePath, 'r') as f:
			lines = f.readlines()
			self.name = lines[1].strip()
			
	def get(self):
		return self.name
		
class Collection:
	def __init__(self):
		self.name = None
		
	def init(self):
		cwd = os.getcwd()
		filePath = os.path.join(cwd, "config.txt")
		with open(filePath, 'r') as f:
			lines = f.readlines()
			self.name = lines[0].strip()
			
	def get(self):
		return self.name
		