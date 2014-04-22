# -*- coding: utf-8 -8-

import yaml
document = """Jabłko:
  waga: 0,5kg
  rozmiar: 20cm
  kolor: zielony
"""
print yaml.load(document)
