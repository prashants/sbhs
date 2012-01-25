#!/usr/bin/python

################## SYSTEM SETTINGS ######################

base_url = 'http://vlabs.iitb.ac.in/sbhs/hardware/'
cur_log_file = ''
scilabreadfname = 'scilabread.sce'
scilabwritefname = 'scilabwrite.sce'

#########################################################
############ DO NOT EDIT AFTER THIS LINE ################
#########################################################

from sys import version_info, exit
# check python version before proceeding
python_ver = version_info
print('Your current python version is %d.%d' % (python_ver[0], python_ver[1]))
if python_ver[0] != 2:
    print('Python 3 is not currently supported. Please use Python version 2.6.x or 2.7.x')
    exit(1)
if python_ver[1] < 6:
    print('Please use Python version 2.6.x or 2.7.x')
    exit(1)

import urllib2, urllib, cookielib, socket
from time import time, sleep
from os import path
from json import loads
from getpass import getpass
from ConfigParser import ConfigParser

################### GLOBAL VARIABLES ####################

scilabreadf = ''
scilabwritef = ''
logf = ''
current_client_version = '1'
exp_end_time = 0
user_timeout = 10

########## CONNECTION INITIALIZATION CODE ###############

# Parse the user configuration file settings.ini
config_parser = ConfigParser()
if not config_parser.read('settings.txt'):
    print('Cannot locate the "settings.txt" file. Please download the SBHS client code again.')
    exit(1)
try:
    user_rollno = config_parser.get('sbhsclient', 'rollno').strip()
    user_password = config_parser.get('sbhsclient', 'password').strip()
    user_use_proxy = config_parser.get('sbhsclient', 'use_proxy').strip()
    if user_use_proxy.lower().strip() == 'yes':
        user_proxy_username = config_parser.get('sbhsclient', 'proxy_username').strip()
        user_proxy_password = config_parser.get('sbhsclient', 'proxy_password').strip()
        user_proxy_host = config_parser.get('sbhsclient', 'proxy_host').strip()
        user_proxy_port = config_parser.get('sbhsclient', 'proxy_port').strip()
    else:
        user_proxy_username = '' 
        user_proxy_password = '' 
        user_proxy_host = '' 
        user_proxy_port = ''
except:
    print('Invalid settings in the "setttings.txt" file. Read the reference settings given in the "settings.txt"')
    exit(1)

# Setup connection details including proxy and cookie support """
if user_use_proxy.lower() == 'yes':
    # build a new opener that uses a proxy requiring authorization
    if user_proxy_username:
        proxy_info = {
            'user' : user_proxy_username,   # proxy username
            'pass' : user_proxy_password,   # proxy password
            'host' : user_proxy_host,       # proxy server
            'port' : user_proxy_port        # proxy port address
        }
        proxy_support = urllib2.ProxyHandler({"http" : "http://%(user)s:%(pass)s@%(host)s:%(port)s" % proxy_info})
    else:
        proxy_info = {
            'host' : user_proxy_host,       # proxy server
            'port' : user_proxy_port        # proxy port address
        }
        proxy_support = urllib2.ProxyHandler({"http" : "http://%(host)s:%(port)s" % proxy_info})

# cookie handling
cookie_support = cookielib.CookieJar()

# enabling support for cookies and proxy    
if user_use_proxy.lower() == 'yes':
    opener = urllib2.build_opener(urllib2.HTTPCookieProcessor(cookie_support), urllib2.HTTPHandler, proxy_support)
else:
    opener = urllib2.build_opener(urllib2.HTTPCookieProcessor(cookie_support), urllib2.HTTPHandler)
urllib2.install_opener(opener)

# set connection timeout in seconds
socket.setdefaulttimeout(user_timeout)

##################### MAIN CODE #########################

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
            print('Connection successfull....')
            network_delay = end_time_ms - start_time_ms
            print('Connection time ' + str(network_delay) + ' milliseconds')
            return True
        else:
            print('Data corruption error in connection check!')
            return False
    except:
        print('Connection error ! Please check your internet connection and/or proxy settings.')
        return False

def clientversion():
    """ test the version of client to use """
    global base_url, current_client_version
    url_check = base_url + 'clientversion'
    try:
        req = urllib2.Request(url_check)
        res = urllib2.urlopen(req)
        content = res.read()
        if content == current_client_version: 
            print('SBHS client code latest...OK.')
            return True
        else:
            print('SBHS client code obsolete. Please download the latest code from our website.')
            return False
    except:
        print('Connection error ! Please check your internet connection.')
        return False

def authenticate():
    """ authenticate user and setup the experiment timeout """
    global cur_log_file, base_url, user_rollno, user_password, exp_end_time
    # get username if not set
    if not user_rollno:
        user_rollno = raw_input('Username/Roll Number:')
    # get password
    if not user_password:
        user_password = getpass()
    url_auth = base_url + 'startexp'
    try:
        postdata = urllib.urlencode({'rollno' : user_rollno, 'password' : user_password})
        req = urllib2.Request(url_auth)
        res = urllib2.urlopen(req, postdata)
        content = res.read()
    except:
        print('Connection error ! Please check your internet connection.')
        return False
 
    content = loads(content)
    if not content[0] == 'S':
        print('Data corruption error in authentication!')
        return False
    if content[1] == '0':
        print(content[2])
        return False
    else:
        print(content[2])
        cur_log_file = content[3]
        # calculate end timestamp, get the time remaining in minutes from the server and add to current time
        try:
            exp_end_time = int(time()) + (60 * int(content[4]))
        except:
            print('Error calculating experiment end time.')
            exp_end_time = int(time())

    return True

def initlogfiles():
    """ clear all previous log files and create new ones """
    global cur_log_file
    try:
        file(scilabreadfname, 'w').close()
    except:
        print('Failed to create file: ' + scilabreadfname)
        return False
    try:
        file(scilabwritefname, 'w').close()
    except:
        print('Failed to create file: ' + scilabwritefname)
        return False
    if path.isfile(cur_log_file):
        print('Log file ' + cur_log_file + ' already exists.')
        return False
    try:
       file(cur_log_file, 'w').close()
    except:
        print('Failed to create Log file: ' + cur_log_file)
        return False
    return True

def startexperiment():
    """ start the experiment """
    global cur_log_file, exp_end_time
    global scilabreadf, scilabwritef, logf

    # open the log files
    try:
        scilabreadf = file(scilabreadfname, 'w')
        scilabwritef = file(scilabwritefname, 'r')
        logf = file(cur_log_file, 'w')
    except:
        print('Failed to access files needed for experiment')
        return False

    print('Successfully connected to the server. You can now run your Scilab code...')

    # catch if Ctrl+C key is pressed by user and terminate the experiment
    try:
        while True:
            # read data from file that scilab writes to
            retry_read = True
            while retry_read:
                cur_scilabwrite_pos = scilabwritef.tell()
                scilabwritestr = scilabwritef.readline()
                if not scilabwritestr.endswith('\n'):
                    scilabwritef.seek(cur_scilabwrite_pos)
                    retry_read = True
                else:
                    retry_read = False

            if scilabwritestr:
                #print('\nRead...' + scilabwritestr)
                scilabwritestr = scilabwritestr.strip()
                try:
                    scilabwritedata = scilabwritestr.split(' ', 3)
                    cur_iter = int(float(scilabwritedata[0]))
                    cur_heat = int(float(scilabwritedata[1]))
                    cur_fan = int(float(scilabwritedata[2]))
                    cur_variables = ''.join(scilabwritedata[3:]) # converting variable arguments list to string
                    cur_time = int(time() * 1000)
                    print('Data Sent => iteration = %d : heat = %d : fan = %d : timestamp = %d : variables = %s' % (cur_iter, cur_heat, cur_fan, cur_time, cur_variables))
                except:
                    print('Invalid data format in ' + scilabwritefname + '. Exiting.')
                    return False
            else:
                continue

            # read data from server
            srv_data = False
            retry_counter = 0
            while not srv_data:
                try:
                    url_com = base_url + 'communicate'
                    postdata = urllib.urlencode({'iteration' : cur_iter, 'heat' : cur_heat, 'fan' : cur_fan, 'variables' : cur_variables, 'timestamp' : cur_time})
                    req = urllib2.Request(url_com)
                    res = urllib2.urlopen(req, postdata)
                    content = res.read()
                    srv_data = True
                    content = loads(content)
                    # check if content is received properly
                    if content[0] == 'D':
                        if content[1] == '1':
                            data_str = content[2]
                            data_str += ' %d' % int(time() * 1000) # add client received time stamp
                            # if variable arguments present in server response append it
                            if content[3]:
                                data_str += ' ' + content[3]
                            print('Data Received <= ' + data_str)
                            # calculating and printing time remaining in minutes
                            try:
                                time_remaining = int((exp_end_time - time()) / 60)
                                if time_remaining < 0:
                                    time_remaining = 0
                            except:
                                time_remaining = 0
                            print('Time left : ' + str(time_remaining) + ' minutes')
                            print('')
                            # write data to file
                            scilabreadf.write(data_str + '\n')
                            scilabreadf.flush()
                            # write data to log
                            logf.write(data_str + '\n')
                            logf.flush()
                        else:
                            print('Error fetching data from server: ' + content[2])
                    else:
                        if content[1] == '1':
                            # check if end of experiment reached
                            if content[2] == 'END':
                                print('Experiement slot is over. Exiting.')
                                return True
                            print('Received status message from server: ' + content[2])
                        else:
                            print('Received error message from server: ' + content[2])
                except:
                    print('Failed connecting to server...retry ' + str(retry_counter))
                    retry_counter = retry_counter + 1
                    sleep(0.1)
                    srv_data = False
    except KeyboardInterrupt:
        print('\nYou have terminated the experiment. Exiting.')
        return False

def endexperiment():
    global base_url
    url_check = base_url + 'endexp'
    try:
        req = urllib2.Request(url_check)
        res = urllib2.urlopen(req)
        content = res.read()
        return True
    except:
        print('Connection error ! Please check your internet connection.')
        return False

################### START EXPERIMENT #####################

# check connection
for c in range(3):
    if not checkconnection():
        exit(1)

# check client version required
if not clientversion():
        exit(1)

# authenticate user
if not authenticate():
    endexperiment()
    exit(1)
else:
    print('Backup log file name for this experiment is ' + cur_log_file)

# setup log files on client machine
if not initlogfiles():
    endexperiment()
    exit(1)

# start the experiment
if not startexperiment():
    scilabwritef.flush()
    scilabwritef.close()
    scilabreadf.flush()
    scilabreadf.close()
    logf.flush()
    logf.close()
else:
    scilabwritef.flush()
    scilabwritef.close()
    scilabreadf.flush()
    scilabreadf.close()
    logf.flush()
    logf.close()

endexperiment()
print('Thank you for using the Single Board Heater System Virtual Labs.')
exit(0)

