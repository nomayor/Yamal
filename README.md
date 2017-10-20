# Yamal
Yamal Models for Juniper

This is a django-based project. Django-related files are in the branch: Django Files.

I use the Yamal, found in the branch Yamal-Models, models as follows:

1. Upon login, the user is presented with the html page: MainPageLogging.html
2. There he can select a series of options, to either view the status of the Juniper device, or configure something on it.
3. Upon selecting the action, the html page executes an ajax call back to the server, invoking the corresponding function in the views.py    file, as the urls file dictates.
4. In the views.py file, you can see how each Yamal model is called. Not all are called the same way.
5. The Juniper device responds and in most of the occasions, the result is written locally. In a few occasions it is reflected back to the    browser of the user.
6. Once the browser receives the notification that the ajax call has completed successfully, it proceeds to make a second ajax call to the    corresponding PHP file which reads the output, selects the required bits of each result and reflects back to the user browser a table      with the results. 


For configuration, the PHP files cross-check what the user is trying to do, with what is in the network. For example if a VLAN number is already in use on an interface, it will not send to the SRX the configuration, it will block it. There are also multiple other checks, trying to ensure that what the user is trying to do, makes sense. As an example, if the user is attempting to create a static route, the next hop of which is included in the subnet for which he adds the static route, the corresponding php file exits and uses the "StaticRouteOverlapTest.py" small programm, to check if the two overlap. If they do, no configuration is sent to the router.

The PHP files are found in the branch: PHP-Files.

