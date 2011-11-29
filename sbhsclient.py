import urllib2, urllib, cookielib
from time import time
import sys
import json
from getpass import getpass

################## USER PARAMETERS ######################

rollno = '111'
useProxy = False
proxyURL = ''
base_url = 'http://10.102.152.29/django/sbhs/'
cur_log_file = ''
scilabreadfname = "scilabread.sci"
scilabwritefname = "scilabwrite.sci"

# cookie handling
c = cookielib.CookieJar()
o = urllib2.build_opener(urllib2.HTTPCookieProcessor(c))
urllib2.install_opener(o)

def checkconnection():
    global base_url
    url_check = base_url + "checkconnection"
    try:
        start_time_ms = int(time() * 1000)
        req = urllib2.Request(url_check)
        res = urllib2.urlopen(req)
        content = res.read()
        end_time_ms = int(time() * 1000)
        if content == "TESTOK":
            print "Connection successfull...."
            network_delay = end_time_ms - start_time_ms
            print "Connection time taken is " + str(network_delay) + " milliseconds"
            return True
        else:
            print "Connection data error..."
            return False
    except:
        print "Connection error ! Please check your internet connection and proxy settings"
        return False

def authenticate():
    global cur_log_file, base_url
    password = getpass()
    url_auth = base_url + "startexp"
    postdata = urllib.urlencode({'rollno' : rollno, 'password' : password})
    req = urllib2.Request(url_auth)
    res = urllib2.urlopen(req, postdata)
    content = res.read()
    content = json.loads(content)
    if not content[0] == 'S':
        print "Invalid data received"
        return False
    if content[1] == '0':
        print content[2]
        return False
    else:
        print content[2]
        cur_log_file = content[3]
        return True

def startexperiment():
    global cur_log_file
    scilabreadf = file(scilabreadfname, "w")
    scilabwritef = file(scilabwritefname, "r")

    while True:
        # read data from file that scilab writes to
        scilabwritestr = scilabwritef.readline()
        if scilabwritestr:
            print "Read...", scilabwritestr
            scilabwritedata = scilabwritestr.split()
            cur_iter = int(scilabwritedata[0])
            cur_time = int(scilabwritedata[1])
            cur_heat = int(scilabwritedata[2])
            cur_fan = int(scilabwritedata[3])
        else:
            continue

        # read data from server
        srv_data = False
        while not srv_data:
            try:
                url_com = base_url + "communicate"
                postdata = urllib.urlencode({'iteration' : cur_iter, 'timestamp' : cur_time, 'heat' : cur_heat, 'fan' : cur_fan})
                req = urllib2.Request(url_com)
                res = urllib2.urlopen(req, postdata)
                content = res.read()
                srv_data = True
                print content
                # write data to file
                scilabreadf.write(content + '\n')
                scilabreadf.flush()
            except:
                #print "Failed to connect to server..."
                srv_data = False

######################## START EXPERIMENT ###########################
for c in range(3):
    if not checkconnection():
        sys.exit()

if not authenticate():
    sys.exit()
else:
    print "Backup log file name is", cur_log_file

startexperiment()

sys.exit()

