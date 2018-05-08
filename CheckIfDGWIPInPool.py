
from netaddr import IPNetwork, IPAddress

with open('/var/www/html/Show_Version/DHCPPoolDefaultGateway.txt', 'r') as f:
  IP_ADDRESS = f.readline()
  f.close()
 
with open('/var/www/html/Show_Version/DHCPPoolSubnet.txt', 'r') as f:
  IP_SUBNETtext = f.readline()
  f.close()

IP_SUBNETArray = IP_SUBNETtext.split(",")  

result = "NoOverlap"

for i in IP_SUBNETArray:

    bool = IPAddress(IP_ADDRESS) in IPNetwork(i)
    if bool:
     result = "Overlap"


f = open('/var/www/html/Show_Version/CheckIfDGWIPInPool.txt','w')
f.write(result) # python will convert \n to os.linesep
f.close()