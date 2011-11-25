import urllib2, urllib, cookielib

# cookie handling
c = cookielib.CookieJar()
o = urllib2.build_opener(urllib2.HTTPCookieProcessor(c))
urllib2.install_opener(o)

url = "http://10.102.152.29/sbhs/startexp"
data = urllib.urlencode({'rollno' : '111', 'password' : '11111'})
req = urllib2.Request(url)
fd = urllib2.urlopen(req, data)
content = fd.read()
print content

url = "http://10.102.152.29/sbhs/communicate"
data = urllib.urlencode({
    'iteration' : '1',
    'timestamp' : '0001',
    'heat' : '35',
    'fan' : '90',
})
#try:
req = urllib2.Request(url)
fd = urllib2.urlopen(req, data)
content = fd.read()
print content

#except:
#print "cannot communicate with device"

#url = "http://10.102.152.29/sbhs/endexp"
#req = urllib2.Request(url)
#fd = urllib2.urlopen(req)
#content = fd.read()
#print content

