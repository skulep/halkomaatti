import asyncio
import struct
import os
from models import BatteryData
from bleak import BleakClient, BleakScanner, BleakError

# MAKE SURE TO HAVE BATTERY_LIST.TXT FILE THAT CONTAINS YOUR BATTERIES MAC ADDRESSES !!!! 

# Constants
NOTIFY_UUID = '0000ff01-0000-1000-8000-00805f9b34fb'
WRITE_UUID = '0000ff02-0000-1000-8000-00805f9b34fb'
QUERY_BATTERY_INFO = b'\xdd\xa5\x03\x00\xff\xfd\x77'

# Globals
notifications = []

def notification_handler(sender, data):
    print(f"Notification from {sender}: {data.hex()}")
    notifications.append(data)

# Battery sends data in 3 different notifications. We only need to use first 2. 
def unpack_noti1(rawdata: bytes, battery: BatteryData) -> None:
    print("Processing battery info 1...")
    volts, amps, soc, capacity, cycles, mdate, balance1, balance2 = struct.unpack_from('>HhHHHHHH', rawdata, 4)
    battery.voltage = volts / 100
    battery.amps = amps / 100
    battery.capacity = capacity / 100
    battery.soc = soc / 100

def unpack_noti2(rawdata: bytes, battery: BatteryData) -> None:
    print("Processing battery info 2...")
    protect, vers, percent, fet, cells, sensors, temp_celsius, temp2, b77 = struct.unpack_from('>HBBBBBHHB', rawdata, 0)
    battery.temp_celsius = (temp_celsius - 2731) / 10

def parse_notifications(notifications: list[bytes], battery: BatteryData) -> None:
    if len(notifications) < 2:
        raise ValueError("Not enough notifications received to parse battery data.")
    unpack_noti1(notifications[0], battery)
    unpack_noti2(notifications[1], battery)

def read_mac_addresses(file_path):
    with open(file_path, 'r') as file:
        mac_addresses = [line.strip() for line in file.readlines()]
    return mac_addresses

async def scan_devices(mac_addresses):
    devices = await BleakScanner.discover()
    for device in devices:
        if device.address in mac_addresses:
            print(device.address)
            return device.address


async def read_battery_info():
    battery = BatteryData()
    script_path = os.path.abspath(__file__)
    script_dir = os.path.dirname(script_path)
    battery_list_path = os.path.join(script_dir, "battery_list.txt")

    mac_address = read_mac_addresses(battery_list_path)
    
    device_address = await scan_devices(mac_address)

    try:
        if device_address:
            async with BleakClient(device_address) as client:
                print("Connected to device.")
                await client.start_notify(NOTIFY_UUID, notification_handler)
                print("Subscribed to notifications.")
                await client.write_gatt_char(WRITE_UUID, QUERY_BATTERY_INFO)

                # Wait until notifications are received or timeout
                timeout = 30  # seconds
                start_time = asyncio.get_event_loop().time()
                while len(notifications) < 2 and (asyncio.get_event_loop().time() - start_time) < timeout:
                    await asyncio.sleep(0.1)

                await client.stop_notify(NOTIFY_UUID)
                print("Stopped notifications.")

            try:
                parse_notifications(notifications, battery)
                print(battery)
                return battery
            except Exception as e:
                print(f"Error parsing notifications: {e}")
        else:
            raise Exception("Device not found or is already in use")

    except BleakError as e:
        print(f"Failed to connect to device: {e}")
        exit()
    except Exception as e:
        print(f"An unexpected error occurred: {e}")
        exit()


