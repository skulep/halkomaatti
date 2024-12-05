import firebase_admin
import os
import time
import asyncio
import datetime
from firebase_admin import credentials, firestore
from battery import read_battery_info

# Gets organization's and device's name from config so they can be used to update right document in firestore
try:
    script_path = os.path.abspath(__file__)
    script_dir = os.path.dirname(script_path)
    main_dir = os.path.abspath(os.path.join(script_dir, ".."))

    config_file_path = os.path.join(main_dir, "config.txt")
    with open(config_file_path, "r") as f:
        lines = f.readlines()
        if len(lines) >= 2:
            org_name = lines[0].strip()
            device_name = lines[1].strip()
        else:
            print("File does not have enough lines. Please make sure config.txt is unmodified.")
            f.close()  # closing the file just in case. not sure if this matters at all.
            time.sleep(5)
            exit()  # exiting application
except FileNotFoundError:
    print("There is no config file. Please create one using setup.py, or duplicate it from elsewhere.")
    time.sleep(5)
    exit()

# Initialize Firebase Admin SDK
def initialize_firestore():
    cred = credentials.Certificate(os.path.join(main_dir, "ServiceAccountKey.json"))
    firebase_admin.initialize_app(cred)
    return firestore.client()

def generate_timestamp():
    timestamp = '{:%Y-%b-%d %H:%M:%S}'.format(datetime.datetime.now())
    return timestamp

# Update Firestore values
async def  update_firestore_values():
    db = initialize_firestore()
    doc_ref = db.collection(org_name).document(device_name)
    
    try:
        battery_info = await read_battery_info()
    except Exception as e:
        print(f"Error while fetching battery data: {e}")
    try:
        data_to_update = {
        "battery": battery_info.soc,
        "battery_timestamp": generate_timestamp()
        }
        doc_ref.update(data_to_update)
        print("Firestore document updated successfully!")
    except Exception as e:
        print(f"Error updating Firestore: {e}")
        exit()

if __name__ == "__main__":
    asyncio.run(update_firestore_values())
