from django.conf.urls.defaults import *

# Uncomment the next two lines to enable the admin:
# from django.contrib import admin
# admin.autodiscover()

urlpatterns = patterns('',
    # Example:
    # (r'^vlabs_sbhs/', include('vlabs_sbhs.foo.urls')),

    # Uncomment the admin/doc line below and add 'django.contrib.admindocs' 
    # to INSTALLED_APPS to enable admin documentation:
    # (r'^admin/doc/', include('django.contrib.admindocs.urls')),

    # Uncomment the next line to enable the admin:
    # (r'^admin/', include(admin.site.urls)),

    # SBHS HARDWARE
    (r'^sbhs/checkconnection', 'sbhshw.views.checkconnection'),
    (r'^sbhs/startexp', 'sbhshw.views.startexp'),
    (r'^sbhs/communicate', 'sbhshw.views.communicate'),
    (r'^sbhs/endexp', 'sbhshw.views.endexp'),
)
