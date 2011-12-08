#!/usr/bin/python

import urllib2, urllib, cookielib
from time import time
import sys
import json
from getpass import getpass
import os

################## USER PARAMETERS ######################

rollno = '111'
useProxy = False
proxyURL = ''
base_url = 'http://10.102.152.29/django/sbhs/'
cur_log_file = ''
scilabreadfname = 'scilabread.sce'
scilabwritefname = 'scilabwrite.sce'
exp_time = ''
max_retry = 20

# cookie handling
c = cookielib.CookieJar()
o = urllib2.build_opener(urllib2.HTTPCookieProcessor(c))
urllib2.install_opener(o)

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

    # get the experiment timeout in minutes from user
    exp_time = raw_input('How many minutes do you want to run the experiment (eg: enter 60 for 60 minutes)? ')
    try:
        exp_time = int(exp_time)
    except:
        print 'Please enter a valid time in minutes'
        return False
    if exp_time < 0 or exp_time > 60:
        print 'Experiment time cannot be less than 0 or more than 60 minutes'
        return False
    exp_time = exp_time * 60 # converting experiment time into seconds
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
    # setup the experiment timer
    exp_start = int(time())
    # open the log files
    try:
        scilabreadf = file(scilabreadfname, 'w')
        scilabwritef = file(scilabwritefname, 'r')
        logf = file(cur_log_file, 'w')
    except:
        print 'Failed to access files needed for experiment'
        return False

    print 'Experiment has started. Please start your Scilab client'

    while True:
        # check for experiment timeout
        exp_time_diff = int(time()) - exp_start 
        if exp_time_diff > exp_time:
            print 'Experiment completed. Experiment timeout reached'
            return True

        # read data from file that scilab writes to
        scilabwritestr = scilabwritef.readline()
        if scilabwritestr:
            print 'Read...', scilabwritestr
            scilabwritedata = scilabwritestr.split()
            cur_iter = int(scilabwritedata[0])
            cur_time = int(scilabwritedata[1])
            cur_heat = int(scilabwritedata[2])
            cur_fan = int(scilabwritedata[3])
        else:
            continue

        # read data from server
        srv_data = False
        retry_counter = 0
        while not srv_data:
            # check for experiment timeout
            exp_time_diff = int(time()) - exp_start 
            if exp_time_diff > exp_time:
                print 'Experiment completed. Experiment timeout reached'
                return True
            # check for maximum server connection retry attempts
            if retry_counter > max_retry:
                print 'Maximum connection retry reached'
                return False
            try:
                url_com = base_url + 'communicate'
                postdata = urllib.urlencode({'iteration' : cur_iter, 'timestamp' : cur_time, 'heat' : cur_heat, 'fan' : cur_fan})
                req = urllib2.Request(url_com)
                res = urllib2.urlopen(req, postdata)
                content = res.read()
                srv_data = True
                print content
                # write data to file
                scilabreadf.write(content + '\n')
                scilabreadf.flush()
                # write data to log
                logf.write(content + '\n')
                logf.flush()
            except:
                print 'Failed to connect to server...retrying'
                retry_counter = retry_counter + 1
                srv_data = False

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
startexperiment()

sys.exit()

