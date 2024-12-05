from dataclasses import dataclass

@dataclass
class BatteryData:
    voltage: float = 0.0
    amps: float = 0.0
    capacity: float = 0.0
    soc: float = 0.0
    temp_celsius: float = 0.0
    