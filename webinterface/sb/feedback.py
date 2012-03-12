#!/usr/bin/python

import sys
from smtplib import SMTP
import datetime

smtp = SMTP('smtp-auth.iitb.ac.in', 25)
smtp.ehlo()
smtp.starttls()
smtp.ehlo()
smtp.login('rupakrokade', '*cdeep*')

to_addr = "rupakrokade@iitb.ac.in"
from_addr ="rupakrokade@iitb.ac.in" 
email=sys.argv[1]

subj = "SHBS - VLABS - User Feedback"
date = datetime.datetime.now().strftime( "%d/%m/%Y %H:%M" )

message_text = "A user with email: "+email+" has given his feedback please check your Admin page.";

msg = "From: %s\nTo: %s\nSubject: %s\nDate: %s\n\n%s" % ( from_addr, to_addr, subj, date, message_text )

smtp.sendmail(from_addr, to_addr, msg)
smtp.quit()

