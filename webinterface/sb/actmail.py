#!/usr/bin/python

import sys
from smtplib import SMTP
import datetime

smtp = SMTP('smtp-auth.iitb.ac.in', 25)
smtp.ehlo()
smtp.starttls()
smtp.ehlo()
smtp.login('username', 'password')

#Use only iitb accounts to avoid phishing headers in user email.
from_addr = "user@example.com"
to_addr = sys.argv[1]
roll_no=sys.argv[2]

subj = "Activate your Account"
date = datetime.datetime.now().strftime( "%d/%m/%Y %H:%M" )

message_text = "Hello,\nYou need to Activate your account with the Link Below:\nhttp://vlabs.iitb.ac.in/sbhs/activate_account.php?rollno="+roll_no+"&emailid="+to_addr+"\n\nThanks for Registering!"

msg = "From: %s\nTo: %s\nSubject: %s\nDate: %s\n\n%s" % ( from_addr, to_addr, subj, date, message_text )

smtp.sendmail(from_addr, to_addr, msg)
smtp.quit()

