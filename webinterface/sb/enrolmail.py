#!/usr/bin/python

import sys
from smtplib import SMTP
import datetime

smtp = SMTP('smtp-auth.iitb.ac.in', 25)
smtp.ehlo()
smtp.starttls()
smtp.ehlo()
smtp.login('rupakrokade', '*cdeep*')

#Use only iitb accounts to avoid phishing headers in user email.
from_addr = "rupakrokade@iitb.ac.in"
to_addr = sys.argv[1]


subj = "Your account is now Activated!"
date = datetime.datetime.now().strftime( "%d/%m/%Y %H:%M" )

message_text = "Hello User,\n\nWe have now activated your Account. You can use the username and password to login into VLabs provided at the time of registration.\n You can now access the SBHS Forum on Moodle (http://fossee.in/moodle) with the following one-time enrollment Key : single-board"

msg = "From: %s\nTo: %s\nSubject: %s\nDate: %s\n\n%s" % ( from_addr, to_addr, subj, date, message_text )

smtp.sendmail(from_addr, to_addr, msg)
smtp.quit()

