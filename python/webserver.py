# -*- coding: utf8 -*-

import SimpleHTTPServer, SocketServer, sys

#SET THE PORT VARIABLE TO COMMAND-LINE ARGUMENT
# PORT = sys.argv[1] 
PORT = '8888'


def RunServer():
    try:
        httphandler = SimpleHTTPServer.SimpleHTTPRequestHandler
    
        httpd = SocketServer.TCPServer(("", int(PORT)), httphandler)
    
        print "Serwer WWW w Pythonie, obsługa na porcie " + PORT
        httpd.serve_forever()
    
    except (KeyboardInterrupt, SystemExit):
        print "Kończenie pracy..."
        sys.exit
    except:
        print "Wystąpił problem z uruchomieniem serwera na porcie " + PORT
        
RunServer()

