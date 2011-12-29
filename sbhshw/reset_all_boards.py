#!/usb/bin/python
import sbhs
import os
import sys

# open the map_machine_ids file for reading
try:
    map_machine_file = file('map_machine_ids.txt', 'r')
except:
    print 'Failed to open machine map file file'
    sys.exit(1)

for mapping_str in map_machine_file.readlines():
    mapping = mapping_str.split('=')
    usb_device_file = mapping[1].strip()    # get the device file name
    dev_id = ''.join(usb_device_file[11:])  # slice the device id
    try:
        dev_id = int(dev_id)
    except:
        print 'Invalid device name %s' % usb_device_file
        continue
    # connect to device
    s = sbhs.Sbhs()
    res = s.connect_device(dev_id)
    if not res:
        print 'Cannot connect to /dev/ttyUSB%s' % dev_id
        s.disconnect()
        continue
    print 'Resetting board %s' % usb_device_file
    s.reset_board()
    s.disconnect()

# close the map_machine_ids file when finished
map_machine_file.close()
print 'Done. Exiting...'

