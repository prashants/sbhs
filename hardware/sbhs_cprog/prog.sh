#!/bin/bash
sudo avrdude -c usbasp -p m16 -U flash:w:C_code.hex
