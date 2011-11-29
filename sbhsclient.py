import urllib2, urllib, cookielib
import time

# cookie handling
c = cookielib.CookieJar()
o = urllib2.build_opener(urllib2.HTTPCookieProcessor(c))
urllib2.install_opener(o)

url = "http://10.102.152.29/django/sbhs/startexp"
data = urllib.urlencode({'rollno' : '111', 'password' : '11111'})
req = urllib2.Request(url)
fd = urllib2.urlopen(req, data)
content = fd.read()
print content

iter = 1
for x in range(10):
    ts = int(time.time() * 1000)
    iter = iter + 1
    url = "http://10.102.152.29/django/sbhs/communicate"
    data = urllib.urlencode({
        'iteration' : iter,
        'timestamp' : ts,
        'heat' : '1',
        'fan' : '150',
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

