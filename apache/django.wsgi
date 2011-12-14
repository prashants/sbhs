import os, sys

apache_configuration= os.path.dirname(__file__)
project = os.path.dirname(apache_configuration)
workspace = os.path.dirname(project)
sys.path.append(workspace)

sys.path.append('/home/cdeep/vlabs/vlabs_sbhs')
sys.path.append('/home/cdeep/vlabs/sbhshw')

os.environ['DJANGO_SETTINGS_MODULE'] = 'vlabs_sbhs.settings'

import django.core.handlers.wsgi

application = django.core.handlers.wsgi.WSGIHandler()

