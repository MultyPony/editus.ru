#!/usr/bin/python
from pyPdf import PdfFileWriter, PdfFileReader
from reportlab.pdfgen import canvas
from reportlab.lib.units import cm, mm, inch
from reportlab.graphics.barcode import createBarcodeDrawing
import sys
output = PdfFileWriter()
input1 = PdfFileReader(file(sys.argv[1], "rb"))

# print the title of document1.pdf
#print "title = %s" % (input1.getDocumentInfo().title)

# add page 1 from input1 to output document, unchanged
page = input1.getPage(0)
#page.trimBox.lowerLeft = (25, 25)
page.trimBox.lowerLeft = (3*mm, 3*mm)
page.trimBox.upperRight = (float(page.mediaBox.getUpperRight_x())-3*mm,float(page.mediaBox.getUpperRight_y())-3*mm)
page.bleedBox.lowerLeft = (0, 0)
page.bleedBox.upperRight = (float(page.mediaBox.getUpperRight_x()),float(page.mediaBox.getUpperRight_y()))
#page.cropBox.lowerLeft = (50, 50)
#page.cropBox.upperRight = (70, 70)
#barcode.drawOn(page,50*mm,50*mm)
#watermark = PdfFileReader(file("/home/httpd/editus.banuchka.ru/www/uploads/10/100507/100507_barcode.pdf", "rb"))
#page.mergePage(watermark.getPage(0))
output.addPage(page)
outputStream = file(sys.argv[2], "wb")
output.write(outputStream)
outputStream.close()
c=canvas.Canvas("barcode.pdf",pagesize=(45*mm,30*mm))
barcode=createBarcodeDrawing('EAN13', value='923456789012')
#barcode=code39.Extended39("123456789",barWidth=0.5*mm,barHeight=20*mm)
#barcode=eanbc.Ean13BarcodeWidget("123456789000")
barcode.drawOn(c,18,5)
c.rotate(90)
c.drawString(5, -10, "www.editus.ru")
c.showPage()
c.save()

