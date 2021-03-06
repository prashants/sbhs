from django.conf.urls.defaults import *

# Uncomment the next two lines to enable the admin:
# from django.contrib import admin
# admin.autodiscover()

urlpatterns = patterns('',
    # Example:
    # (r'^sbhspyserver/', include('sbhspyserver.foo.urls')),

    # Uncomment the admin/doc line below and add 'django.contrib.admindocs' 
    # to INSTALLED_APPS to enable admin documentation:
    # (r'^admin/doc/', include('django.contrib.admindocs.urls')),

    # Uncomment the next line to enable the admin:
    # (r'^admin/', include(admin.site.urls)),

    # SBHS HARDWARE
    (r'^checkconnection', 'sbhshw.views.checkconnection'),
    (r'^clientversion', 'sbhshw.views.clientversion'),
    (r'^startexp', 'sbhshw.views.startexp'),
    (r'^communicate', 'sbhshw.views.communicate'),
    (r'^endexp', 'sbhshw.views.endexp'),
)
