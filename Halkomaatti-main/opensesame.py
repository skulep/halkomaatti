import struct
import serial 

print("please give following info in integer format")

lock_num = int(input("enter lock number: "))
control_unit = lock_num // 48
lock = lock_num % 48
if lock == 0:
    control_unit -= 1
    lock = 47
else:
    lock -= 1

CUAddress = control_unit 
LockNum = lock

Command = input("enter Command: ")
byte1 = 2
byte2 = int(CUAddress)
byte3 = int(LockNum)
byte4 = int(Command)
byte5 = 3
byteSum = (byte1 + byte2 + byte3 + byte4 + byte5)
sendit = bytes([byte1, byte2, byte3, byte4, byte5, byteSum])
print(byte1, " ", byte2, " ", byte3, " ", byte4, " ", byte5, " ", byteSum)

# Define the serial port parameters
ser = serial.Serial(
    port='COM4',
    baudrate=19200,
    bytesize=serial.EIGHTBITS,
    parity=serial.PARITY_NONE,
    stopbits=serial.STOPBITS_ONE
)

# Open the serial port
ser.close()
ser.open()

if byte4==81:
      ser.write(sendit) 
elif byte4==80:
    ser.write(sendit)
    response = ser.read(12)
    print(response)
    hex_values = [f'\\x{byte:02x}' for byte in response]

    i = 1
    for value in hex_values:
     print(f"byte {i}: {value}")
     print(f"byte {i} as integer: {int(value[2:], 12)}")
    i = i + 1
else:
   print("Command byte is incorrect! It needs to be 0x50 to read state or 0x51 to open")

# Close the serial port when you're done
ser.close()
