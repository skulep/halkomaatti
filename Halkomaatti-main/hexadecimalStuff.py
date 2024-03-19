import struct

testi = input("testi")
htesti = hex(int(testi))[2:]
testi2 = input("testi")
htesti2 = hex(int(testi2))[2:]
hetesti = htesti + htesti2
hextesti = bytes.fromhex(hetesti.zfill(4))

for byte in hextesti:
    print(f"0x{byte:02X}", end=' ')

CUAddress = input("enter CUAddress: ")
LockNum = input("enter LockNum: ")
Command = input("enter Command: ")
byte1 = 2
hbyte1 = hex(byte1)[2:]
byte2 = int(CUAddress)
hbyte2 = hex(byte2)[2:]
byte3 = int(LockNum)
hbyte3 = hex(byte3)[2:]
byte4 = int(Command)
hbyte4 = hex(byte4)[2:]
byte5 = 3
hbyte5 = hex(byte5)[2:]
byteSum = (byte1 + byte2 + byte3 + byte4 + byte5)
byte6 = hex(byteSum)[2:]
print(hex(byte1) + " " + hex(byte2) + " " + hex(byte3) + " " + hex(byte4) + " " + hex(byte5) + " " + byte6)
combinedHex = hbyte1 + hbyte2 + hbyte3 + hbyte4 + hbyte5 + byte6
inputHex = bytes.fromhex(combinedHex.zfill(12))

for byte in inputHex:
    print(f"0x{byte:02X}", end=' ')
print(combinedHex)
