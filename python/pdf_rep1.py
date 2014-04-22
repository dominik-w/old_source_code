# -*- coding: utf-8 -*-

from reportlab.platypus import Table, TableStyle, Paragraph
from reportlab.lib import colors
from reportlab.pdfgen import canvas
from reportlab.lib.pagesizes import A4
from reportlab.pdfbase import pdfmetrics
from reportlab.pdfbase.ttfonts import TTFont
from reportlab.lib.styles import getSampleStyleSheet

c = canvas.Canvas('plik.pdf', pagesize=A4)
width, height = A4
# dodanie czcionek
pdfmetrics.registerFont(TTFont('Arial-Bold', 'arialbd.ttf'))
pdfmetrics.registerFont(TTFont('Arial', 'arial.ttf'))

# umieszczanie grafiki
minus = 460
c.drawImage('foto.jpg', 40, (height-minus))
minus += 40

# prosty tekst
c.setFont("Arial", 14)
c.drawString(40,(height-minus), "Prosty tekst")
minus += 40

# paragraf
stylesheet=getSampleStyleSheet()
styleN = stylesheet['Normal']
styleN.fontSize = 17
styleN.fontName = 'Arial-Bold'
p = Paragraph(u'<para align="center">Tekst złożony <u>bardziej</u></para>', styleN)
w,h = p.wrap(width, height)
p.drawOn(c, 0, height-minus)

# zapis do pliku
c.showPage()
c.save()
