import os, sys

apache_configuration= os.path.dirname(__file__)
project = os.path.dirname(apache_configuration)
workspace = os.path.dirname(project)
sys.path.append(workspace)

sys.path.append('/home/cdeep/sbhspyserver')
sys.path.append('/home/cdeep/sbhspyserver/sbhshw')

os.environ['DJANGO_SETTINGS_MODULE'] = 'sbhspyserver.settings'

import django.core.handlers.wsgi

application = django.core.handlers.wsgi.WSGIHandler()

