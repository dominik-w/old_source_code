#!/usr/bin/env python
#-*- coding: utf-8 -*

from urllib2 import urlopen
import socket, sys, time, datetime

socket.setdefaulttimeout(15)

def CheckExternalSites(sites):
    logfile = open ("logfile.txt", "a")
    logtime = time.strftime("\n%a, %d %b %Y %H:%M:%S")
    print logtime
    logfile.write(logtime + "\n")
    
    for site in sites:
        try:
            start = time.time()
            data = urlopen("http://" + site)
            stuff = data.read()
            end = time.time()
            difference = end - start
            output = "Ładowanie strony %s zajęło %2.2f sekund" %( site, difference )
            logfile.write(output + "\n")
            print output
        except:
            errno, errstr = sys.exc_info()[:2]
            if errno == socket.timeout:
                timeouterror = "czas oczekiwania został przekroczony"
                logfile.write(timeouterror + "\n\n")
                print timeouterror + "\n"
                raw_input("Naciśnij Enter:  ")
                return
            else:
                genericerror = "Błąd połączenia ze stroną %s" % (site)
                logfile.write(genericerror + "\n\n")
                print genericerror + "\n"
                raw_input("Naciśnij Enter:  ")
                return
    print "\n"
    logfile.write("\n")
    logfile.close()
    raw_input("Naciśnij Enter:  ")
                
def CheckInternalWebServers(serverlist, port):
    logfile = open ("logfile.txt", "a")
    logtime = time.strftime("\n%a, %d %b %Y %H:%M:%S")
    print logtime
    logfile.write(logtime + "\n")
    
    textfile = "textfile.txt"
    binaryfile = "binaryfile.exe"
    for server in serverlist:
        try:
            start = time.time()
            serveroutput =  server + ":"
            logfile.write(serveroutput + "\n")
            print serveroutput
            for file in textfile, binaryfile:
                data = urlopen("http://%s:%s/%s") % (server, port, file)
                stuff = data.read()
                end = time.time()
                difference = end - start
                print "Ładowanie pliku %s zajęło %2.2f sekund" % (file,  difference)
                logfile.write("Ładowanie pliku %s zajęło %2.2f sekund" % (file, difference) + "\n")
        except:
            errno, errstr = sys.exc_info()[:2]
            if errno == socket.timeout:
                timeouterror = "czas oczekiwania został przekroczony"
                logfile.write(timeouterror + "\n\n")
                print timeouterror
                logfile.close()
                raw_input("Naciśnij Enter:  ")
                return
            else:
                genericerror = "Błąd połączenia z serwerem %s" % server
                logfile.write(genericerror + "\n\n")
                print genericerror
                raw_input("Naciśnij Enter:  ")
                return
    print "\n"
    logfile.write("\n")
    logfile.close()
    raw_input("Naciśnij Enter:  ")

