#!/usr/bin/python

import urllib2, urllib, cookielib
from time import time
import sys
import json
from getpass import getpass
import os

################## USER PARAMETERS ######################

rollno = '111'

useProxy = 0
proxy_info = {
    'user' : 'prashantsh',
    'pass' : 'asdf1234$',
    'host' : 'netmon.iitb.ac.in',
    'port' : 80 # or 8080 or whatever
}

################## SYSTEM SETTINGS ######################

base_url = 'http://10.102.152.29/sbhs/'
cur_log_file = ''
scilabreadfname = 'scilabread.sce'
scilabwritefname = 'scilabwrite.sce'
exp_time = ''
max_retry = 20

################## GLOBAL VARIABLES ####################
scilabreadf = ''
scilabwritef = ''
logf = ''

################### MAIN CODE ############################

# proxy handling
if useProxy:
    # build a new opener that uses a proxy requiring authorization
    proxy_support = urllib2.ProxyHandler({"http" : "http://%(user)s:%(pass)s@%(host)s:%(port)d" % proxy_info})
    opener = urllib2.build_opener(proxy_support, urllib2.HTTPHandler)
    # install it
    urllib2.install_opener(opener)

# cookie handling
cookie_support = cookielib.CookieJar()
opener = urllib2.build_opener(urllib2.HTTPCookieProcessor(cookie_support))
urllib2.install_opener(opener)

def checkconnection():
    """ test connection to server """
    global base_url
    url_check = base_url + 'checkconnection'
    try:
        start_time_ms = int(time() * 1000)
        req = urllib2.Request(url_check)
        res = urllib2.urlopen(req)
        content = res.read()
        end_time_ms = int(time() * 1000)
        if content == 'TESTOK':
            print 'Connection successfull....'
            network_delay = end_time_ms - start_time_ms
            print 'Connection time taken is ' + str(network_delay) + ' milliseconds'
            return True
        else:
            print 'Connection data error...'
            return False
    except:
        print 'Connection error ! Please check your internet connection and proxy settings'
        return False

def authenticate():
    """ authenticate user and setup the experiment timeout """
    global cur_log_file, base_url, exp_time
    password = getpass()
    url_auth = base_url + 'startexp'
    postdata = urllib.urlencode({'rollno' : rollno, 'password' : password})
    req = urllib2.Request(url_auth)
    res = urllib2.urlopen(req, postdata)
    content = res.read()
    content = json.loads(content)
    if not content[0] == 'S':
        print 'Invalid data received'
        return False
    if content[1] == '0':
        print content[2]
        return False
    else:
        print content[2]
        cur_log_file = content[3]

    return True

def initlogfiles():
    """ clear all previous log files and create new ones """
    global cur_log_file
    try:
        file(scilabreadfname, 'w').close()
    except:
        print 'Failed to create Scilab input file:', scilabreadfname
        return False
    try:
        file(scilabwritefname, 'w').close()
    except:
        print 'Failed to create Scilab output file:', scilabwritefname
        return False
    if os.path.isfile(cur_log_file):
        print 'Log file', cur_log_file, ' already exists'
        return False
    try:
       file(cur_log_file, 'w').close()
    except:
        print 'Failed to create Log file:', cur_log_file
        return False
    return True

def startexperiment():
    """ start the experiment """
    global cur_log_file, exp_time, max_retry
    global scilabreadf, scilabwritef, logf

    # open the log files
    try:
        scilabreadf = file(scilabreadfname, 'w')
        scilabwritef = file(scilabwritefname, 'r')
        logf = file(cur_log_file, 'w')
    except:
        print 'Failed to access files needed for experiment'
        return False

    print 'Experiment has started. Please start your Scilab client'

    # catch if Ctrl+C key is pressed by user and terminate the experiment
    try:
        while True:
            # read data from file that scilab writes to
            scilabwritestr = scilabwritef.readline()
            if scilabwritestr:
                print '\nRead...', scilabwritestr
                scilabwritestr = scilabwritestr.strip()
                try:
                    scilabwritedata = scilabwritestr.split(' ', 3)
                    cur_iter = int(float(scilabwritedata[0]))
                    cur_heat = int(float(scilabwritedata[1]))
                    cur_fan = int(float(scilabwritedata[2]))
                    cur_variables = ''.join(scilabwritedata[3:]) # converting variable arguments list to string
                    cur_time = int(time() * 1000)
                    print "data sent => iteration = %d : heat = %d : fan = %d : timestamp = %d : variables = %s" % (cur_iter, cur_heat, cur_fan, cur_time, cur_variables)
                except:
                    print 'Invalid data format in scilab write file. Continuing to next data.'
                    continue
            else:
                continue

            # read data from server
            srv_data = False
            retry_counter = 0
            while not srv_data:
                # check for maximum server connection retry attempts
                if retry_counter > max_retry:
                    print 'Maximum connection retry reached'
                    return False
                try:
                    url_com = base_url + 'communicate'
                    postdata = urllib.urlencode({'iteration' : cur_iter, 'heat' : cur_heat, 'fan' : cur_fan, 'variables' : cur_variables, 'timestamp' : cur_time})
                    req = urllib2.Request(url_com)
                    res = urllib2.urlopen(req, postdata)
                    content = res.read()
                    srv_data = True
                    content = json.loads(content)
                    # check if content is received properly
                    if content[0] == 'D':
                        if content[1] == '1':
                            data_str = content[2]
                            data_str += ' %d' % int(time() * 1000) # add client received time stamp
                            # if variable arguments present in server response append it
                            if content[3]:
                                data_str += ' ' + content[3]
                            print "data received <=", data_str
                            # write data to file
                            scilabreadf.write(data_str + '\n')
                            scilabreadf.flush()
                            # write data to log
                            logf.write(data_str + '\n')
                            logf.flush()
                        else:
                            print 'Error fetching data from server:', content[2]
                    else:
                        if content[1] == '1':
                            # check if end of experiment reached
                            if content[2] == 'END':
                                print 'Experiement timeout reached. Experiment over'
                                return True
                            print 'Received status message from server:', content[2]
                        else:
                            print 'Error fetching response from server:', content[2]
                except:
                    print 'Failed to connect to server...retrying'
                    retry_counter = retry_counter + 1
                    srv_data = False
    except KeyboardInterrupt:
        print '\nExperiment terminated...'
        return False

######################## START EXPERIMENT ###########################

# check connection
for c in range(3):
    if not checkconnection():
        sys.exit()

# authenticate user
if not authenticate():
    sys.exit()
else:
    print 'Backup log file name for this experiment is', cur_log_file

# setup log files on client machine
if not initlogfiles():
    sys.exit()

# start the experiment
if not startexperiment():
    scilabwritef.close()
    scilabreadf.flush()
    scilabreadf.close()
    logf.flush()
    logf.close()
else:
    scilabwritef.close()
    scilabreadf.flush()
    scilabreadf.close()
    logf.flush()
    logf.close()

print 'Thank you for using the SBHS Virtual Labs project'
sys.exit()
