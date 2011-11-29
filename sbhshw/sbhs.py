import serial
import os

INCOMING_HEAT = 254
INCOMING_FAN  = 253
OUTGOING_TEMP = 255

MAX_HEAT = 50
MAX_FAN = 200

class Sbhs:
	""" This is the Single Board Heater System class """

	def __init__(self):
		# status of the board
		# 0 = not connected
		# 1 = connected
		self.status = 0

	def connect(self, boardnum):
		""" Open a serial connection via USB to the SBHS """
		try:
			self.boardnum = int(boardnum)
		except:
			print 'Invalid board number'
			return False
		# check if SBHS device is connected
		boardfile = '/dev/ttyUSB' + str(self.boardnum)
		if not os.path.exists(boardfile):
			print 'SBHS device file ' + boardfile + ' does not exists'
			return False
		try:
			self.boardcon = serial.Serial(port=boardfile, baudrate=9600, bytesize=8, parity='N', stopbits=1, timeout=2)
			self.status = 1
			return True
		except:
			print "Error: cannot connect to board %d" % boardnum
			self.boardnum = 0
			self.boardcon = False
			self.status = 0
		return False

	def setHeat(self, val):
		""" Set the heat """
		if val > MAX_HEAT:
			print "Error: heat value cannot be more than %d" % MAX_HEAT
			return False

		try:
			self._write(chr(INCOMING_HEAT))
			self._write(chr(val))
			return True
		except:
			return "Error: cannot set heat for board %d" % self.boardnum
			return False

	def setFan(self, val):
		""" Set the fan """
		if val > MAX_FAN:
			print "Error: fan value cannot be more than %d" % MAX_FAN
			return False
		try:
			self._write(chr(INCOMING_FAN))
			self._write(chr(val))
			return True
		except:
			return "Error: cannot set fan for board %d" % self.boardnum
			return False

	def getTemp(self):
		""" Get the temperature """
		try:
			self.boardcon.flushInput()
			self._write(chr(OUTGOING_TEMP))
			temp = ord(self._read(1)) + (0.1 * ord(self._read(1)))
			return temp
		except:
			print "Error: cannot read temprature from board %d" % self.boardnum
		return	0.0

	def disconnect(self):
		""" Reset the board fan and heat values and close the USB connection """
		try:
			self.boardcon.close()
			self.boardcon = False
			self.status = 0
			return True
		except:
			print "Error: cannot close the connection to the board"
			return False

	def reset_board(self):
		self.setFan(100)
		self.setHeat(0)

	def _read(self, size):
		try:
			data = self.boardcon.read(size)
			return data
		except:
			print "Error: cannot read from board %d" % self.boardnum
			raise Exception

	def _write(self, data):
		try:
			self.boardcon.write(data)
			return True
		except:
			print "Error: cannot write to board %d" % self.boardnum
			raise Exception


