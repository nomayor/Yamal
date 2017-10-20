from django.shortcuts import render
from django.shortcuts import render_to_response
from django.template import Context, Template
from django.template import RequestContext, loader
from django.http import HttpResponse
from django.http import HttpResponseRedirect


from django.conf.urls.static import static
from django.contrib.staticfiles.views import serve


from netaddr import IPNetwork, IPAddress


from .forms import LoginForm
from .models import firstLogin, LoggedUser
from django.forms.models import model_to_dict


from json import dumps, loads, JSONEncoder, JSONDecoder
import pickle
from jinja2 import Template
from django.core import serializers


from django.contrib import auth
from django.contrib.auth import login
from django.contrib.auth import logout
from django.contrib.auth import authenticate
from django.contrib.auth.decorators import login_required
from django.contrib.auth.tokens import default_token_generator


from django.contrib.sites.shortcuts import get_current_site
from django.core.urlresolvers import reverse
from django.http import HttpResponseRedirect, QueryDict
from django.shortcuts import resolve_url
from django.template.response import TemplateResponse
from django.utils.deprecation import RemovedInDjango110Warning
from django.utils.encoding import force_text
from django.utils.http import is_safe_url, urlsafe_base64_decode
from django.utils.six.moves.urllib.parse import urlparse, urlunparse
from django.utils.translation import ugettext as _
from django.views.decorators.cache import never_cache
from django.views.decorators.csrf import csrf_protect
from django.views.decorators.debug import sensitive_post_parameters
from django.contrib.auth.models import User
from django.contrib.sessions.models import Session


import re
import os
import sys
import json
import argparse
import requests
import paramiko,socket
import getpass
from lxml import etree


from multiprocessing import cpu_count
from multiprocessing.dummy import Pool as ThreadPool


import yaml
from jnpr.junos import Device
from jnpr.junos.exception import *
from jnpr.junos.exception import RpcError
from jnpr.junos.utils.config import Config
from jnpr.junos.factory.factory_loader import FactoryLoader

from jnpr.junos.op.routes import RouteTable
from jnpr.junos.op.routes import *
from jnpr.junos.op.ethport import *
from jnpr.junos.op.getvrfconfig import *
from jnpr.junos.op.SecurityFlow import *
from jnpr.junos.op.vSRXInterfaces import *
from jnpr.junos.op.ShowInterfaces import *
from jnpr.junos.op.PolicyRuleTable import *
from jnpr.junos.op.vSRXRoutingTable import *
from jnpr.junos.op.InterfaceMaskVLAN import *
from jnpr.junos.op.GetInterfaceConfig import *
from jnpr.junos.op.RoutingTableNextHop import *
from jnpr.junos.op.getsecuritypolicies import *
from jnpr.junos.op.SecurityFlowPOLICY import *
from jnpr.junos.op.SecurityFlowTRAFFIC import *
from jnpr.junos.op.SecurityFlowALL import *
from jnpr.junos.op.BGPpeerStatus import *
from jnpr.junos.op.BGPpeerStatusPolicy import *
from jnpr.junos.op.GetInstanceInformation import *

username = "ICCSelfCareFullRights"
password = "rnryzySW9je-B9ipzZrtrDePNCb3AlpI"



def user_login(request):

    # If the request is a HTTP POST, try to pull out the relevant information.
    if request.method == 'POST':
        # Gather the username and password provided by the user.
        # This information is obtained from the login form.
                # We use request.POST.get('<variable>') as opposed to request.POST['<variable>'],
                # because the request.POST.get('<variable>') returns None, if the value does not exist,
                # while the request.POST['<variable>'] will raise key error exception
        username = request.POST.get('username')
        password = request.POST.get('password')

        # Use Django's machinery to attempt to see if the username/password
        # combination is valid - a User object is returned if it is.
        user = authenticate(username=username, password=password)
	
        # If we have a User object, the details are correct.
        # If None (Python's way of representing the absence of a value), no user
        # with matching credentials was found.
        if user:
            # Is the account active? It could have been disabled.
            if user.is_active:

                logged_users = LoggedUser.objects.all().order_by('username')
                for i in logged_users:
                  if str(i) == str(request.POST.get('username')):
			ses = Session.objects.all()
			for i in Session.objects.all():
				uid = i.get_decoded().get('_auth_user_id')
				try:
					user2 = User.objects.get(pk=uid)
				except:
					user2 = ""
				if (str(user2) == str(i)):
					print "Deleted User Session %s %s" % i, user2
					i.delete()
			print "Remaining Sessions %s" % Session.objects.all()
			print "Sessions %s" % ses				
			print "Logger Users %s" % logged_users
			print "HELLO"
			#return HttpResponse("User is already loggend in.")
			#user_sessions = UserSession.objects.filter(user = i)
			#user_session.session.delete()
			#login(request,user)
                  else:
			login(request,user)
			print "USER AUTHENTICATED"
                #    return HttpResponse("User is already logged in.")

                # If the account is valid and active, we can log the user in.
                # We'll send the user back to the homepage.
                login(request, user)
                if firstLogin.objects.filter(name="%s_first_login" %(request.user.username)).exists():
                  first_login_details = firstLogin.objects.get(name="%s_first_login" %(request.user.username))
                  print first_login_details
                  if getattr(first_login_details,'firstlogin') is False:
                    return HttpResponseRedirect('/passwordreset/')

               # login(request, user)  
               # if user = current_user:
               #    return HttpResponse("This user is already logged in.")   

                return HttpResponseRedirect('/frontend/')
            else:
                # An inactive account was used - no logging in!
                return HttpResponse("Your Rango account is disabled.")
        else:
            # Bad login details were provided. So we can't log the user in.
            print "Invalid login details: {0}, {1}".format(username, password)
            return HttpResponse("Invalid login details supplied.")

    # The request is not a HTTP POST, so display the login form.
    # This scenario would most likely be a HTTP GET.
    else:
        # No context variables to pass to the template system, hence the
        # blank dictionary object...
        return render(request, 'login.html',{})






@login_required
def user_logout(request):
    logout(request)

    return HttpResponseRedirect('/frontend/')


@login_required
def frontend(request):

  #if request.user.username == "viewstest":
  #if request.user.username == "icc-fw":
  if request.user.username == "fusion":
      return render(request, 'MainPageLogging.html')
  else:
      return render(request, 'MainPageLogging.html')




@login_required
def routes(request):

  with open('/var/www/html/Show_Version/FW_To_Configure.txt', 'r') as f:
   ip = f.readline()
   f.close()

  try:
   vSRX = Device(host=ip,user=username,password=password)
   vSRX.open(gather_facts=False)
   vSRX.timeout = 1000
   result = RoutingTableNextHop(vSRX).get(table="Service_VRF_1").items()
   vSRX.close()
 
  except paramiko.AuthenticationException:
      result = "Authentication problem"
  except socket.error, e:
      result = "Comunication problem "
      vSRX.close()
  
  try:
  	f = open('/var/www/html/Show_Version/InterfacesOutputFromvSRX.txt','w')
        f.write(str(result))
   	f.close()
  	print "FILE OPENED"
        result = "RoutesCollected"
    
  except Exception as inst:
  	print "Error %s" % inst
  
  return HttpResponse(result)



@login_required
def sessions(request):

  with open('/var/www/html/Show_Version/FW_To_Configure.txt', 'r') as f:
   ip = f.readline()
   f.close()

  try:
   vSRX = Device(host=ip,user=username,password=password)
   vSRX.open(gather_facts=False)
   fw_sessions = SecurityFlow(vSRX).get().items()
   vSRX.close()  
   result = fw_sessions   
  # return HttpResponse(fw_sessions)

  except paramiko.AuthenticationException:
      result = "Authentication problem"
  except socket.error, e:
      result = "Comunication problem"
      vSRX.close()

  try:
    f = open('/var/www/html/Show_Version/FireWSessionsFromvSRX.txt','w')
    f.write(str(fw_sessions))
    f.close()
    print "FILE OPENED"
    result = "SessionsCollected"
    
  except Exception as inst:
    print "Error %s" % inst
    result = "ErrorExperienced"

  return HttpResponse(result)


@login_required
def Configuration(request):
 

  with open('/var/www/html/Show_Version/FW_To_Configure.txt', 'r') as f:
   ip = f.readline()
   f.close()

  vSRX = Device(host=ip,user=username,password=password) 

  conf_file = '/var/www/html/Show_Version/FW_Config.set'

  try:
    vSRX.open(gather_facts=False)
    vSRX.timeout = 300
    print "Connected to device:"

  except Exception as err:
    print "Cannot connect to device:", err
    result = "Cannot connect to device:"
    return HttpResponse(result)


  vSRX.bind( cu=Config )

  
# Lock the configuration, load configuration changes, and commit
 
  print "Locking the configuration"
  try:
    vSRX.cu.lock()
  except LockError:
    print "Error: Unable to lock configuration"
    result = "Error: Unable to lock configuration"
    vSRX.close()
    return HttpResponse(result)




  print "Loading configuration changes"
  try:
    #vSRX.cu.load(path=conf_file, merge=True, action="set", format="text")
    vSRX.cu.load(path=conf_file, merge=True) 
  except ValueError as err:
    vSRX.cu.rollback(rb_id=0)
    print err.message
 


  except Exception as err:
    if err.rsp.find('.//ok') is None:
      rpc_msg = err.rsp.findtext('.//error-message')
      print "Unable to load configuration changes: ", rpc_msg

    print "Unlocking the configuration"
    try:
        vSRX.cu.unlock()
    except UnlockError:
      print "Error: Unable to unlock configuration"
    vSRX.close()
    result = "Error:in unlocking config." 
    return HttpResponse(result)


  print "Committing the configuration"
  try:
    vSRX.cu.commit() 
  except CommitError:
    print "Error: Unable to commit configuration"
    print "Unlocking the configuration"
    try:
      vSRX.cu.unlock()
    except UnlockError:
     print "Error: Unable to unlock configuration"
    vSRX.close()
    result = "Error: Unable to unlock configuration"      
    return HttpResponse(result)



  print "Unlocking the configuration"
  try:
      vSRX.cu.unlock()
  except UnlockError:
    print "Error: Unable to unlock configuration"

 # End the NETCONF session and close the connection
  vSRX.close()
  print "Connection to ICC_FW Closed"
  result = "Configuration Applied"


  WhichUser = request.user.username
  try:
    f = open('/var/www/html/LOGGING/WhichUser.txt','w')
    f.write(str(WhichUser))
    f.close()
    
  except Exception as inst:
    print "Error %s" % inst


  return HttpResponse(result)







@login_required
def interfaces(request):
  
  with open('/var/www/html/Show_Version/FW_To_Configure.txt', 'r') as f:
   ip = f.readline()
   f.close()
    
  try:
   vSRX = Device(host=ip,user=username,password=password)
   vSRX.open(gather_facts=False)
   result = vSRXInterfaces(vSRX).get().items()

  # print (result)  
   vSRX.close()

  except paramiko.AuthenticationException:
      result = "Authentication problem"
  except socket.error, e:
      result = "Comunication problem "
      vSRX.close()

  return HttpResponse(result)


@login_required
def intMaskVLAN(request):
  
  with open('/var/www/html/Show_Version/FW_To_Configure.txt', 'r') as f:
   ip = f.readline()
   f.close()
    
  try:
   vSRX = Device(host=ip,user=username,password=password)
   vSRX.open()
   result = InterfaceMaskVLAN(vSRX).get().items()

   vSRX.close()

  except paramiko.AuthenticationException:
      result = "Authentication problem"
  except socket.error, e:
      result = "Comunication problem "
      vSRX.close()

  return HttpResponse(result)


@login_required
def getconfig(request):
  
  with open('/var/www/html/Show_Version/FW_To_Configure.txt', 'r') as f:
   ip = f.readline()
   f.close()


  list = []

  try:
   vSRX = Device(host=ip,user=username,password=password)
   vSRX.open(gather_facts=False)

   result = getvrfconfig(vSRX).get(values=True)

   for item in result: 
    list.append(item.instance_name)
    list.append(", ")
    list.append(item.network)
    list.append(", ")
    list.append(item.interface)
    list.append(", ")
    

   vSRX.close()

  except paramiko.AuthenticationException:
      result = "Authentication problem"
  except socket.error, e:
      result = "Comunication problem "
      vSRX.close()
      
  return HttpResponse(list)



@login_required 
def PolicyRules(request):
  
  with open('/var/www/html/Show_Version/SourceZone.txt', 'r') as f:
   SourceZone = f.readline()
   f.close()

  with open('/var/www/html/Show_Version/DestinationZone.txt', 'r') as f:
   DestinationZone = f.readline()
   f.close()
 
  with open('/var/www/html/Show_Version/FW_To_Configure.txt', 'r') as f:
   ip = f.readline()
   f.close()

  try:
   vSRX = Device(host=ip,user=username,password=password)
   vSRX.open(gather_facts=False)
   result = PolicyRuleTable(vSRX).get(policy=(SourceZone,DestinationZone))
   vSRX.close()

   list = []

   for item in result:

    list.append(item.name)
    list.append(",")
    list.append(item.matchsrc)
    list.append(",")
    list.append(item.matchdst)
    list.append(",")
    list.append(item.matchapp)
    list.append(",")
    list.append(item.action)
    list.append("....")

  except paramiko.AuthenticationException:
      result = "Authentication problem"
  except socket.error, e:
      result = "Comunication problem"
      vSRX.close()

  return HttpResponse(list)



def UpdatePolicy(request):
  
  with open('/var/www/html/Show_Version/FW_To_Configure.txt', 'r') as f:
   ip = f.readline()
   f.close()
 

  conf_file = '/var/www/html/Show_Version/UpdatePolicy.set'

  try:
    vSRX = Device(host=ip,user=username,password=password)
    vSRX.open(gather_facts=False)
    print "Connected to device:"

  except Exception as err:
    print "Cannot connect to device:", err
    result = "Cannot connect to device:"
    return HttpResponse(result)
    return


  vSRX.bind( cu=Config )

  
# Lock the configuration, load configuration changes, and commit
 
  print "Locking the configuration"
  try:
    vSRX.cu.lock()
  except LockError:
    print "Error: Unable to lock configuration"
    result = "Error: Unable to lock configuration"
    vSRX.close()
    return HttpResponse(result)
    return
 


  print "Loading configuration changes"
  try:
    vSRX.cu.load(path=conf_file, merge=True)
  except ValueError as err:
    print err.message
 


  except Exception as err:
    if err.rsp.find('.//ok') is None:
      rpc_msg = err.rsp.findtext('.//error-message')
      result = "Unable to load configuration changes"
    print "Unable to load configuration changes: ", rpc_msg
    vSRX.close()
    return HttpResponse(result)
    return

    print "Unlocking the configuration"
    try:
      vSRX.cu.unlock()
    except UnlockError:
      result = "Error: Unable to unlock configuration"
      print "Error: Unable to unlock configuration"
      vSRX.close() 
      return HttpResponse(result)
      return


  print "Committing the configuration"
  try:
    vSRX.cu.commit() 
  except CommitError:
    result = "Error: Unable to commit configuration"
    print "Error: Unable to commit configuration"
    result = "Error: Unable to commit configuration"
    vSRX.close()
    return HttpResponse(result)
    return


    print "Unlocking the configuration"
    try:
      vSRX.cu.unlock()
    except UnlockError:
     result = "Error: Unable to unlock configuration"
     print "Error: Unable to unlock configuration"
     vSRX.close()
      
     return HttpResponse(result)
     return

  print "Unlocking the configuration"
  try:
      vSRX.cu.unlock()
  except UnlockError:
    result = "Error: Unable to unlock configuration"
    print "Error: Unable to unlock configuration"
    vSRX.close()
    return HttpResponse(result)
    return


 # End the NETCONF session and close the connection
  vSRX.close()
  print "Connection to ICC_FW Closed"
  result = "Configuration Applied"
  return HttpResponse(result)



@login_required
def NewPolicyTerm(request):
 
  with open('/var/www/html/Show_Version/FW_To_Configure.txt', 'r') as f:
   ip = f.readline()
   f.close()
 

  conf_file = '/var/www/html/Show_Version/FW_Config.set'

  try:
    vSRX = Device(host=ip,user=username,password=password)
    vSRX.open(gather_facts=False)
    print "Connected to device:"

  except Exception as err:
    print "Cannot connect to device:", err
    result = "Cannot connect to device:"
    return HttpResponse(result)
    return


  vSRX.bind( cu=Config )

  
  # Lock the configuration, load configuration changes, and commit
   
  print "Locking the configuration"
  try:
    vSRX.cu.lock()
  except LockError:
    print "Error: Unable to lock configuration"
    result = "Error: Unable to lock configuration"
    vSRX.close()
    return HttpResponse(result)
    return



  print "Loading configuration changes"
  try:
    vSRX.cu.load(path=conf_file, merge=True)
  except ValueError as err:
    vSRX.cu.rollback(rb_id=0)    
    print err.message
 


  except Exception as err:
    if err.rsp.find('.//ok') is None:
      rpc_msg = err.rsp.findtext('.//error-message')
      result = "Unable to load configuration changes"
    print "Unable to load configuration changes: ", rpc_msg
    vSRX.close()
    return HttpResponse(result)
    return

    print "Unlocking the configuration"
    try:
      vSRX.cu.unlock()
    except UnlockError:
      result = "Error: Unable to unlock configuration"
      print "Error: Unable to unlock configuration"
      vSRX.close() 
      return HttpResponse(result)
      return


  print "Committing the configuration"
  try:
    vSRX.cu.commit() 
  except CommitError:
    result = "Error: Unable to commit configuration"
    print "Error: Unable to commit configuration"
    result = "Error: Unable to commit configuration"
    vSRX.close()
    return HttpResponse(result)
    return


    print "Unlocking the configuration"
    try:
      vSRX.cu.unlock()
    except UnlockError:
     result = "Error: Unable to unlock configuration"
     print "Error: Unable to unlock configuration"
     vSRX.close()
      
     return HttpResponse(result)
     return



  print "Unlocking the configuration"
  try:
      vSRX.cu.unlock()
  except UnlockError:
    result = "Error: Unable to unlock configuration"
    print "Error: Unable to unlock configuration"
    vSRX.close()
    return HttpResponse(result)
    return


 # End the NETCONF session and close the connection
  vSRX.close()
  print "Connection to ICC_FW Closed"
  result = "Configuration Applied"
  return HttpResponse(result)




def GetInterfaceConfig(request):
 
  with open('/var/www/html/Show_Version/FW_To_Configure.txt', 'r') as f:
   ip = f.readline()
   f.close()

  with open('/var/www/html/Show_Version/RequiredIntConf.txt', 'r') as f:
   RequiredIntConf = f.readline()
   f.close()

  try:
   vSRX = Device(host=ip,user=username,password=password)
   vSRX.open(gather_facts=False)
   result = GetInterfaceConfig(vSRX).get(interface = RequiredIntConf)
   vSRX.close()

   list = []

   for item in result:

     list.append(item.unit)
     list.append(",")  
     list.append(item.UnitName)
     list.append(",")
     list.append(item.UnitVLAN)
     list.append(",")
     list.append(item.IP_Address)
     list.append("....")
     
  except paramiko.AuthenticationException:
      result = "Authentication problem"
  except socket.error, e:
      result = "Comunication problem"
      vSRX.close()

  return HttpResponse(list)




def RoutingTableNextHopTesting(request):

  try:
   f = open('/var/www/html/Show_Version/FW_To_Configure.txt', 'r')
   ip = f.readline()
   f.close()
   print (ip)
  except:
	print "ERROR Opening File FW_To_Configure from function RoutingTableNextHopTesting"
#  with open('/var/www/html/Show_Version/FW_To_Configure.txt', 'r') as f:
#   ip = f.readline()
#   f.close()
#   print (ip) 
  vSRX = Device(host=ip,user=username,password=password) 

  try:
#   vSRX = Device(host=ip,user=username,password=password)
   vSRX.open()
   print "CPE OPENED"
   #result = vSRXRoutingTable(vSRX).get(table="Service_VRF_1").items()
  # print "COLLECTING DETAILS"
  # result = RoutingTableNextHopTesting(vSRX).get(table="Service_VRF_1").items()
  # print "CPE CLOSE"
  # vSRX.close()
  except paramiko.AuthenticationException:
      result = "Authentication problem"
  except socket.error, e:
      result = "Comunication problem "
      vSRX.close()
  try:
   print "COLLECTING DETAILS"
   result1 = RoutingTableNextHopTestin(vSRX).get(table="Service_VRF_1").items()
   print "CPE CLOSE"
   print "Result: %s" %result1
   vSRX.close()
 
  except: 
	print "FAILED TO GET CONFIG"
	HttpResponse("FAILED")
  print "RETURN"

  return HttpResponse(str(result))







def PolicyTermNumber(request):

  with open('/var/www/html/Show_Version/FW_To_Configure.txt', 'r') as f:
   ip = f.readline()
   f.close()

  try:
   vSRX = Device(host=ip,user=username,password=password)
   vSRX.open(gather_facts=False)
   result = getsecuritypolicies(vSRX).get(detail=True,zone_context=True)
   vSRX.close()
 
   list = []

   for key in result:

     list.append(key.FromZone)
     list.append(",")  
     list.append(key.ToZone)
     list.append(",")
     list.append(key.Count)
     list.append("....")
     
  except paramiko.AuthenticationException:
      result = "Authentication problem"
  except socket.error, e:
      result = "Comunication problem"
      vSRX.close()

  try:
    f = open('/var/www/html/Show_Version/PolicyTermNumber.txt','w')
    f.write(str(list))
    f.close()
    print "FILE OPENED"
    result = "PolicyTermNumberCollected"
    
  except Exception as inst:
    print "Error %s" % inst
    result = "ErrorExperienced"

  return HttpResponse(list)







@login_required
def UniqueSession(request):

  with open('/var/www/html/Show_Version/FW_To_Configure.txt', 'r') as f:
   ip = f.readline()
   f.close()

  with open('/var/www/html/Show_Version/USessionSource.txt', 'r') as f:
   SessionSource = f.readline()
   f.close()

  with open('/var/www/html/Show_Version/USessionDestination.txt', 'r') as f:
   SessionDestination = f.readline()
   f.close()

  try:
   vSRX = Device(host=ip,user=username,password=password)
   vSRX.open(gather_facts=False)
   vSRX.timeout = 1000

   #SecurityPOLICY = SecurityFlowPOLICY(vSRX).get(source_prefix = SessionSource,destination_prefix = SessionDestination)
   ##SecurityTRAFFIC = SecurityFlowTRAFFIC(vSRX).get(source_prefix = SessionSource,destination_prefix = SessionDestination)
   SecurityTRAFFIC = SecurityFlowALL(vSRX).get(source_prefix = SessionSource,destination_prefix = SessionDestination)

   vSRX.close()  
 
  except paramiko.AuthenticationException:
      result = "Authentication problem"
  except Exception as inst:
    print "Error %s" % inst
    
  except socket.error, e:
      result = "Comunication problem"
      vSRX.close()
  except Exception as inst:
    print "Error %s" % inst

  ItemsNumber = 0

  list = []
  for item in SecurityTRAFFIC:
   list.append(item.Source_Addr)
   list.append("next")
   list.append(item.destination_address)
   list.append("next")
   list.append(item.session_protocol)
   list.append("next")   
   list.append(item.destination_port)
   list.append("next")  
   list.append(item.interface)
   list.append("next")
   list.append(item.session_direction)
   list.append("next")
   list.append(item.policy)
   list.append("ENDofITEM")
   ItemsNumber += 1

  try:
    f = open('/var/www/html/Show_Version/USessionsFromFW.txt','w')
    f.write(str(list))
    f.close()
    result = "SessionsCollected"

  except Exception as inst:
    print "Error %s" % inst
    result = "ErrorExperienced"


  return HttpResponse(result)





@login_required
def BGPpeerStatusView(request):

  with open('/var/www/html/Show_Version/FW_To_Configure.txt', 'r') as f:
   ip = f.readline()
   f.close()

  try:
   vSRX = Device(host=ip,user=username,password=password)
   vSRX.open(gather_facts=False)
   vSRX.timeout = 1000
   #result = BGPpeerStatus(vSRX).get(instance="Service_VRF_1", neighbor_address="100.100.100.100").items()
   result = BGPpeerStatusPolicy(vSRX).get(instance="Service_VRF_1").items()
   vSRX.close()
 
  except paramiko.AuthenticationException:
      result = "Authentication problem"
  except socket.error, e:
      result = "Comunication problem"
      vSRX.close()
  
  try:
    f = open('/var/www/html/Show_Version/BGPpeerStatusView.txt','w')
    f.write(str(result))
    f.close()
    result = "BGPPeerStatusCollected"
    
  except Exception as inst:
    print "Error %s" % inst
  
  return HttpResponse(result)



@login_required
def GetInstanceView(request):

  with open('/var/www/html/Show_Version/FW_To_Configure.txt', 'r') as f:
   ip = f.readline()
   f.close()

  try:
   vSRX = Device(host=ip,user=username,password=password)
   vSRX.open(gather_facts=False)
   vSRX.timeout = 1000
   #result = BGPpeerStatus(vSRX).get(instance="Service_VRF_1", neighbor_address="100.100.100.100").items()
   result = GetInstanceInformation(vSRX).get(detail=True).items()
   vSRX.close()


  except paramiko.AuthenticationException:
      result = "Authentication problem"
  except socket.error, e:
      result = "Comunication problem"
      vSRX.close()
  
  try:
    f = open('/var/www/html/Show_Version/GetInstanceInformation.txt','w')
    f.write(str(result))
    f.close()
    result = "VRFInfoCollected"
    
  except Exception as inst:
    print "Error %s" % inst
  
  return HttpResponse(result)