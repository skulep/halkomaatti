import os
import time
import serial
import firebase_admin
import usb.core
import subprocess
from pyudev import Context, Monitor

context = Context()
monitor = Monitor.from_netlink(context)
monitor.filter_by(subsystem='usb')
# Check to see if any devices are removed
for device in iter(monitor.poll, None):
    if device.action == 'remove':
        print("USB device has been removed.")
        os.system('sudo reboot')
        subprocess.call('sudo reboot', shell=True)


# **** installation stuff below or above idk ¯\_(ツ)_/¯ ****
