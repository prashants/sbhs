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
acc_id = sys.argv[2]
u_name = sys.argv[3]


subj = "Your account is now Activated!"
date = datetime.datetime.now().strftime( "%d/%m/%Y %H:%M" )

message_text = "Hello User,\n\nYou can change the password of your account using the following link:\n http://vlabs.iitb.ac.in/sbhs/change_pass.php?id="+acc_id+"&code="+u_name+"\n\n"

msg = "From: %s\nTo: %s\nSubject: %s\nDate: %s\n\n%s" % ( from_addr, to_addr, subj, date, message_text )

smtp.sendmail(from_addr, to_addr, msg)
smtp.quit()

