#!/usr/bin/env python
#-*- coding: utf-8 -*-

""" usage:
  u'Podaj liczbę całkowitą:13
  u'Liczba 13 w notacji rzymskiej to: XIII
"""

rzym = {
        1000:"M", 900:"CM", 500:"D", 400:"CD", 100:"C", 90:"XC", 50:"L",
        40:"XL", 10:"X", 9:"IX", 5:"V", 4:"IV", 1:"I" 
}

x = input("Podaj liczbę całkowitą:")

print "Liczba",`x`,"w notacji rzymskiej to:", 
r = rzym.keys()

r.sort()
r.reverse()

lr = ""
for i in r:
    while i <= x:
        lr += rzym[i]
        x -= i
        
print lr
