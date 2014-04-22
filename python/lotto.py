#!/usr/bin/env python
#-*- coding: utf-8 -*-
 
# program losuje 6 liczb od 1 do 49

from random import choice

Wylosowane = set()

while len(Wylosowane) < 6:
    Wylosowane.add(choice(range(1,50)))
    
for x in Wylosowane:
    print x,

