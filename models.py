from django.db import models
from django.contrib.auth.models import User
from django.contrib.auth.signals import user_logged_in, user_logged_out

# Create your models here.

class Firewall_Sessions(models.Model):
	Source_IP = models.CharField(max_length=120, default='ABC')
	Destination_IP = models.CharField(max_length=120, default='ABC')
	Source_Port = models.CharField(max_length=120, default='ABC')
	Destination_Port = models.CharField(max_length=120, default='ABC')
	Protocol = models.CharField(max_length=120, default='ABC')

	timestamp = models.DateTimeField(auto_now_add  = True, auto_now=False)
	updated = models.DateTimeField(auto_now_add  = False, auto_now=True)

	def __unicode__(self):
		    return "%s" %(self)

class firstLogin (models.Model):
    name = models.CharField(max_length=120, default='ABC')
    firstlogin = models.BooleanField(default=False)
    timerstamp = models.DateTimeField(auto_now_add=True, auto_now=False)

    def __unicode__(self):
                    return self.name



class LoggedUser(models.Model):
	username = models.CharField(max_length=30, primary_key=True)

	def __unicode__(self):
	  return self.username

	def login_user(sender, request, user, **kwargs):
	  LoggedUser(username=user.username).save()

	def logout_user(sender, request, user, **kwargs):
	  try:
	    u = LoggedUser.objects.get(pk=user.username)
	    u.delete()
	  except LoggedUser.DoesNotExist:
	    pass

	user_logged_in.connect(login_user)
	user_logged_out.connect(logout_user)
