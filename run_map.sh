#!/bin/bash

# Run the ./sbhshw/python scan_machine.py script and print the
# final ./sbhshw/map_machine_ids.txt file generated

cd sbhshw
python scan_machines.py
echo ""
echo "*****************************************************************"
echo "************************ MAP FILE *******************************"
echo "*****************************************************************"
cat map_machine_ids.txt
cd ..

