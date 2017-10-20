from django.contrib import admin
from django.conf.urls import patterns, include, url

from django.conf.urls.static import static
from django.contrib.staticfiles.urls import staticfiles_urlpatterns

urlpatterns = patterns('',
   url(r'^admin/', include(admin.site.urls)),
   url(r'^routes/', 'Sh_Ver_App.views.routes', name = 'routes'),
   url(r'^GetInterfaceConfig/', 'Sh_Ver_App.views.GetInterfaceConfig', name = 'GetInterfaceConfig'),
   url(r'^sessions/', 'Sh_Ver_App.views.sessions', name = 'sessions'),
   url(r'^BGPpeerStatus/', 'Sh_Ver_App.views.BGPpeerStatusView', name = 'BGPpeerStatusView'),
   url(r'^GetInstanceInformation/', 'Sh_Ver_App.views.GetInstanceView', name = 'GetInstanceView'),
   url(r'^UniqueSession/', 'Sh_Ver_App.views.UniqueSession', name = 'UniqueSession'),
   url(r'^RoutingTableNextHopTesting/', 'Sh_Ver_App.views.RoutingTableNextHopTesting', name = 'RoutingTableNextHopTesting'),
   url(r'^PolicyTermNumber/', 'Sh_Ver_App.views.PolicyTermNumber', name = 'PolicyTermNumber'),
   url(r'^frontend/', 'Sh_Ver_App.views.frontend', name = 'frontend'),
   url(r'^NewPolicyTerm/', 'Sh_Ver_App.views.NewPolicyTerm', name='NewPolicyTerm'),
   url(r'^UpdatePolicy/', 'Sh_Ver_App.views.UpdatePolicy', name='UpdatePolicy'),
   url(r'^PolicyRules/', 'Sh_Ver_App.views.PolicyRules', name='PolicyRules'),
   url(r'^frontend', 'Sh_Ver_App.views.frontend', name = 'frontend'),
   url(r'^$', 'Sh_Ver_App.views.frontend', name = 'frontend'),
   url(r'^login/$', 'Sh_Ver_App.views.user_login', name='user_login'),
   url(r'^logout/$', 'Sh_Ver_App.views.user_logout', name='logout'),
   url(r'^configuration/$', 'Sh_Ver_App.views.Configuration', name='Configuration'),
   url(r'^interfaces/$', 'Sh_Ver_App.views.interfaces', name='interfaces'),
   url(r'^getconfig/$', 'Sh_Ver_App.views.getconfig', name='getconfig'),
   url(r'^intMaskVLAN/$', 'Sh_Ver_App.views.intMaskVLAN', name='intMaskVLAN'),
   url(r'^session_security/', include('session_security.urls')),
   url(r'^passwordreset/', 'passwordreset.views.index',name='index'),  
)





   
   
      

