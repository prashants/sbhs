import urllib2, urllib

url = "http://10.102.152.29/sbhs/startexp"

data = urllib.urlencode({'rollno' : '111', 'password' : '11111'})
req = urllib2.Request(url)
fd = urllib2.urlopen(req, data)
content = fd.read()
print content

url = "http://10.102.152.29/sbhs/endexp"
req = urllib2.Request(url)
fd = urllib2.urlopen(req)
content = fd.read()
print content

