import urllib2, urllib

url = "http://10.102.152.29/sbhs/startexp"

data = urllib.urlencode({'rollno' : '11111', 'rno' : '11111'})
req = urllib2.Request(url)
try:
    fd = urllib2.urlopen(req, data)
    #fd = urllib2.urlopen(req)
    content = fd.read()
except urllib2.HTTPError, error:
    content = error.read()
print content

