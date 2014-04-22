# -*- coding: utf-8 -*-

import win32net

# lista użytkowników
users = win32net.NetUserEnum('localhost', 0)
print "UŻYTKOWNICY"
print "=========="
for user in users[0]:
    print user['name']
print ""

# lista grup
groups = win32net.NetGroupEnum('localhost', 0)
print "GRUPY"
print "=========="
for group in groups[0]:
    print group['name']
print ""

# lista zasobów sieciowych
shares = win32net.NetShareEnum('localhost', 0)
print "ZASOBY"
print "=========="
for share in shares[0]:
    print share['netname']
print ""

# lista serwerów
servers = win32net.NetServerEnum(None, 100)
print "SERWERY"
print "=========="
for server in servers[0]:
    print server['name']
print ""

