# Create your views here.
from django.http import HttpResponse
import datetime
import sbhs
import hashlib
import json
import datetime

from sbhshw.models import SlotBooking, Account

from django.views.decorators.csrf import csrf_exempt                                          

# HTML RESPONSE FORMAT :
# 1: STATUS / DATA : S/D
# 2: SUCCESS / FAILED : 1/0
# 3: MESSAGE : MESSAGE STRING

@csrf_exempt
def startexp(request):
    """ start experiment for authenticated users """
    if request.method == "POST":
        cur_dt = datetime.datetime.now()

        rollno = request.POST.get('rollno', None)
        password = request.POST.get('password', None)
        # check if username and password is present
        if not rollno or not password:
            html = json.dumps(['S', '0', 'Please provide username and password'])
            return HttpResponse(html)

        # authenticate user
        password = hashlib.md5(password).hexdigest()
        user = Account.objects.filter(
            rollno = rollno,
            password = password,
        )
        if not user:
            html = json.dumps(['S', '0', 'Authentication failed'])
            return HttpResponse(html)
        else:
            user = user[0]

        # check the slot booking for user for current date and hour
        booking = SlotBooking.objects.filter(
            rollno = rollno,
            slot_date = cur_dt.strftime("%d/%m/%Y"),    # current date
            time = cur_dt.hour,                         # current hour
        )

        # if user and slot validated then set the session data
        if booking:
            booking = booking[0]
            request.session['logged_in'] = True
            request.session['slot_id'] = booking.slot_id
            request.session['rollno'] = booking.rollno
            request.session['slot_date'] = booking.slot_date
            request.session['start_time'] = booking.start_time
            request.session['end_time'] = booking.end_time
            request.session['mid'] = booking.mid
            html = json.dumps(['S', '1', 'Login Successfull and slot found'])
            return HttpResponse(html)
        else:
            clearsession(request)
            html = json.dumps(['S', '0', 'No valid slot found'])
            return HttpResponse(html)
    else:
        clearsession(request)
        return HttpResponse("Please use the SBHS Client")

def endexp(request):
    """ end experimentand reset board  """
    s = sbhs.Sbhs()
    if request.session.get('mid', None): 
        s.connect(request.session['mid'])
        s.reset_board()
        s.disconnect()

    # delete user session data
    clearsession(request)
    html = json.dumps(['S', '1', 'Experiment over. Thank you for using the SBHS Project'])
    return HttpResponse(html)

def readsbhs(request):
    """ read data from sbhs """
    s = sbhs.Sbhs()
    s.connect(request.session['mid'])
    temprature = s.getTemp()
    s.disconnect()

    server_time = datetime.datetime.now().strftime("%Y%m%d%H%M%S")
    client_time = datetime.datetime.now().strftime("%Y%m%d%H%M%S")
    # return data to user
    html = "%d %s %s %2.2f\n" % (1111, server_time, client_time, temprature)
    return HttpResponse(html)

def writesbhs(request):
	""" write data to sbhs """
	s = sbhs.Sbhs()
	s.connect(request.session['mid'])
	err = False

	if request.POST['heat']:
		heat = int(request.POST['heat'])
		if not s.setHeat(heat):
			err = True

	if request.POST['fan']:
		fan = int(request.POST['fan'])
		if not s.setFan(fan):
			err = True

	s.disconnect()
	if err:
		html = "ERROR"
	else:
		html = "OK"
	return HttpResponse(html)

def clearsession(request):
    if request.session.get('logged_in', None):
        del request.session['logged_in']
    if request.session.get('slot_id', None):
        del request.session['slot_id']
    if request.session.get('rollno', None):
        del request.session['rollno']
    if request.session.get('slot_date', None):
        del request.session['slot_date']
    if request.session.get('start_time', None):
        del request.session['start_time']
    if request.session.get('end_time', None):
        del request.session['end_time']
    if request.session.get('mid', None):
        del request.session['mid']
