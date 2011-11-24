import os, sys
sys.path.append('/home/cdeep/vlabs')
sys.path.append('/home/cdeep/vlabs/vlabs_sbhs')

os.environ['DJANGO_SETTINGS_MODULE'] = 'vlabs_sbhs.settings'

import django.core.handlers.wsgi

application = django.core.handlers.wsgi.WSGIHandler()

