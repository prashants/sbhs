#!/usr/bin/python

import sys
from smtplib import SMTP
import datetime

smtp = SMTP('mail.example.com', 25)
smtp.ehlo()
smtp.starttls()
smtp.ehlo()
smtp.login('username', 'password')

#Use only iitb accounts to avoid phishing headers in user email.
from_addr = "test@example.com"
to_addr = sys.argv[1]


subj = "Your account is now Activated!"
date = datetime.datetime.now().strftime( "%d/%m/%Y %H:%M" )

message_text = "Hello User,\n\nWe have now activated your Account. You can use the username and password to login into VLabs provided at the time of registration.\n You can now access the SBHS Forum on Moodle (http://fossee.in/moodle) with the following one-time enrollment Key : test-board"

msg = "From: %s\nTo: %s\nSubject: %s\nDate: %s\n\n%s" % ( from_addr, to_addr, subj, date, message_text )

smtp.sendmail(from_addr, to_addr, msg)
smtp.quit()

