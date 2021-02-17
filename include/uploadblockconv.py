#! /usr/bin/python

# To change this template, choose Tools | Templates
# and open the template in the editor.

__author__="banuchka"
__date__ ="$Jan 22, 2011 1:40:44 PM$"

import getopt, sys
import uno
import io
#import ooutils

from unohelper import Base, systemPathToFileUrl, absolutize
from os import getcwd
from os.path import splitext
from os.path import exists
from math import *
from com.sun.star.beans import PropertyValue
from com.sun.star.uno import Exception as UnoException
from com.sun.star.io import IOException, XOutputStream
from PyPDF2 import PdfFileWriter, PdfFileReader
from reportlab.lib import pagesizes
from reportlab.pdfgen import canvas
from reportlab.lib.units import cm, mm, inch
#from io.StringIO import StringIO
from com.sun.star.awt import Size

#Google Drive Api

#import httplib2
import pprint

#from apiclient.discovery import build
#from apiclient.http import MediaFileUpload
#from oauth2client.client import OAuth2WebServerFlow
#from oauth2client.file import Storage

# Copy your credentials from the console
#CLIENT_ID = '159874999662-t5uf0m5ubrmsi7svc0p30v8c9ifj7pnd.apps.googleusercontent.com'
#CLIENT_SECRET = 'a7ySwcmE1gf7FCiwIUhV8zZq'

# Check https://developers.google.com/drive/scopes for all available scopes
#OAUTH_SCOPE = 'https://www.googleapis.com/auth/drive'

# Redirect URI for installed apps
#REDIRECT_URI = 'urn:ietf:wg:oauth:2.0:oob'
#REDIRECT_URI = 'http://localhost:8000'

# Path to the crendentials
#CRED_FILENAME = '/home/httpd/editus.ru/www/credentials'

### For storing token
#storage = Storage(CRED_FILENAME)

# Path to the file to upload
#FILENAME = 'thesample.doc'

def download_file(service, drive_file):
  download_url = drive_file['exportLinks']['application/pdf']
  if download_url:
    resp, content = service._http.request(download_url)
    if resp.status == 200:
      #print 'Status: %s' % resp
      return content
    else:
      #print 'An error occurred: %s' % resp
      return None
  else:
    return None

def download_file(service, drive_file):
  """Download a file's content.

  Args:
    service: Drive API service instance.
    drive_file: Drive File instance.

  Returns:
    File's content if successful, None otherwise.
  """
  #pprint.pprint(drive_file)
  #pprint()
  #print drive_file['id']
  #print drive_file
  #download_url = drive_file.get('downloadUrl')
  #print download_url
  download_url = drive_file['exportLinks']['application/pdf']
  if download_url:
    resp, content = service._http.request(download_url)
    if resp.status == 200:
      #print 'Status: %s' % resp
      return content
    else:
      #print 'An error occurred: %s' % resp
      return None
  else:
    # The file doesn't have any content stored on Drive.
    return None
def retrieve_all_files(service):
  """Retrieve a list of File resources.

  Args:
    service: Drive API service instance.
  Returns:
    List of File resources.
  """
  result = []
  page_token = None
  while True:
    try:
      param = {}
      if page_token:
        param['pageToken'] = page_token
      files = service.files().list(**param).execute()

      result.extend(files['items'])
      page_token = files.get('nextPageToken')
      if not page_token:
        break
    except (errors.HttpError, error):
      print ('An error occurred: %s',error)
      break
  return result


class PageFormatUtils:
   A5 = Size(14800,21000);
   A4 = Size(21000,29700);
   A3 = Size(29700,42000);
   Letter = Size(21500,28000);
   Digest = Size(14000,22000);
   Square = Size(21000,21000);
   Pocket = Size(12000,15000);
   A6 = Size(10500,14800);

   def settingPageOrientationAndSize(self, document,pFormat):
      #print dir(document)
      pageStyleCollection = document.getStyleFamilies().getByName("PageStyles")
      propertySet = pageStyleCollection.getByName("Standard")
      wasH=propertySet.getPropertyValue("Size" ).Height
      wasW=propertySet.getPropertyValue("Size" ).Width
      k='ok'
#      sys.stdout.write( "pFormat: " + str( pFormat )+ "\n" )
#      sys.stdout.write( "H: " + str( wasH ) + " "+ str(self.A4.Height)+"\n" )
#      sys.stdout.write( "W: " + str( wasW/100 )+ " "+ str(self.A4.Width)+"\n" )
      
      
      #Switch the size
      if pFormat=="A4":
        if abs(wasH-self.A4.Height)<5 and abs(wasW-self.A4.Width)<5:
            k="ok"
        else:
            k="change A4"
        propertySet.setPropertyValue("Size",self.A4);
        #sys.stdout.write( "pFormat: " + str( document.CurrentController.PageCount )+ "\n" )
      if pFormat == "A5":
          if abs(wasH - self.A5.Height)<5 and (wasW - self.A5.Width)<5:
              k = "ok"
          else:
              k = "change A5"
          propertySet.setPropertyValue("Size", self.A5);

      if pFormat == "A6":
          if abs(wasH - self.A6.Height)<5 and (wasW - self.A6.Width)<5:
              k = "ok"
          else:
              k = "change A6"
          propertySet.setPropertyValue("Size", self.A6);

      if pFormat == "A3":
          if abs(wasH - self.A3.Height)<5 and abs(wasW == self.A3.Width)<5:
              k = "ok"
          else:
              k = "change A3"
          propertySet.setPropertyValue("Size", self.A3);

      if pFormat == "Letter":
          if abs(wasH - self.Letter.Height)<5 and abs(wasW - self.Letter.Width)<5:
              k = "ok"
          else:
              k = "change Letter"
          propertySet.setPropertyValue("Size", self.Letter);

      if pFormat == "Digest":
          if abs(wasH - self.Digest.Height)<5 and abs(wasW - self.Digest.Width)<5:
              k = "ok"
          else:
              k = "change Digest"
          propertySet.setPropertyValue("Size", self.Digest);

      if pFormat == "Square":
          if abs(wasH - self.Square.Height)<5 and abs(wasW - self.Square.Width)<5:
              k = "ok"
          else:
              k = "change Square"
          propertySet.setPropertyValue("Size", self.Square);

      if pFormat == "Pocket":
          if abs(wasH - self.Pocket.Height)<5 and abs(wasW - self.Pocket.Width)<5:
              k = "ok"
          else:
              k = "change Pocket"
          propertySet.setPropertyValue("Size", self.Pocket);

      return k


   def switchToLandscape(self, pageProperties):
      # Check if it is not already Landscape
      if not pageProperties.getPropertyValue("IsLandscape"):
         # Redeclare sizes to match Landscape
         size = pageProperties.getPropertyValue("Size");
         width = size.Width
         size.Width = size.Height
         size.Height = width
         pageProperties.setPropertyValue("Size", size);
         pageProperties.setPropertyValue("IsLandscape", True)

PAGESIZE = pagesizes.A4

class OutputStream( Base, XOutputStream ):
    def __init__( self ):
        self.closed = 0
    def closeOutput(self):
        self.closed = 1
    def writeBytes( self, seq ):
        sys.stdout.write( seq.value )
    def flush( self ):
        pass

def main():
    #if not storage.get():
        # Run through the OAuth flow and retrieve authorization code
    #    flow = OAuth2WebServerFlow(CLIENT_ID, CLIENT_SECRET, OAUTH_SCOPE, REDIRECT_URI)
    #    authorize_url = flow.step1_get_authorize_url()
    #    lineprint = 'Go to the following link in your browser: ' + authorize_url
    #    print (lineprint)
    #    code = raw_input('Enter verification code: ').strip()
    #    credentials = flow.step2_exchange(code)

        ### Storing access token and a refresh token in CRED_FILENAME
    #    storage.put(credentials)
    #else:
        ### Getting access_token,expires_in,token_type,Refresh_toke info from CRED_FILENAME to 'credentials'
    #    credentials = storage.get()
    # Create an httplib2.Http object and authorize it with our credentials



    retVal = 0
    doc = None
    stdout = False
    
    try:
        opts, args = getopt.getopt(sys.argv[1:], "hc:k:p:f:n",
            ["help", "connection-string=" , "pdf", "stdout", "ispdf","xls","google" ])
        url = "uno:socket,host=localhost,port=8100;urp;StarOffice.ComponentContext"
        filterName = "Text (Encoded)"
        extension  = "txt"
        for o, a in opts:
            if o in ("-h", "--help"):
                usage()
                sys.exit()
            if o in ("-c", "--connection-string" ):
                url = "uno:" + a + ";urp;StarOffice.ComponentContext"
            if o == "--pdf":
                filterName = "writer_pdf_Export"
                extension  = "pdf"
            if o == "--xls":
                #print "Hello"
                extension  = "pdf"
                xls2pdf(args)
                sys.exit()
            if o == "--stdout":
               stdout = True
            #if o == '--google':
            #    FILENAME = '102344_block.doc'
            #    print FILENAME
            #
            #    exit(1)
            if o == "-k":
               kr = a
            if o == "-p":
               pages = a
            if o == "-f":
               pFormat = a
#		sys.stdout.write( "Pformat: " + str( pFormat ) + "\n" )
            if o == "--ispdf":
                ispdftest(args,kr,pFormat)
                sys.exit()
        if not len( args ):
            usage()
            sys.exit()
        ctxLocal = uno.getComponentContext()
        smgrLocal = ctxLocal.ServiceManager

        resolver = smgrLocal.createInstanceWithContext(
                 "com.sun.star.bridge.UnoUrlResolver", ctxLocal )
        ctx = resolver.resolve( url )
        smgr = ctx.ServiceManager

        desktop = smgr.createInstanceWithContext("com.sun.star.frame.Desktop", ctx )

        cwd = systemPathToFileUrl( getcwd() )
        fdata = []
        fdata1 = PropertyValue()
        fdata1.Name = "SelectPdfVersion"
        fdata1.Value = 0
        fdata2 = PropertyValue()
        fdata2.Name = "Quality"
        fdata2.Value = 100
        fdata.append(fdata1)
        fdata.append(fdata2)
        properties = [PropertyValue() for i in range(3)]
        properties[0].Name = "FilterName"
        properties[0].Value = "writer_pdf_Export"
        properties[1].Name = "Overwrite"
        properties[1].Value = True
        properties[2].Name = "FilterData"
        properties[2].Value = uno.Any("[]com.sun.star.beans.PropertyValue", tuple(fdata) )
        inProps = PropertyValue( "Hidden" , 0 , True, 0 ),
        chcnt=0
        for path in args:
            try:
                fileUrl = absolutize( cwd, systemPathToFileUrl(path) )
                #FILENAME='/home/httpd/editus.ru/www/include/'+path
                #media_body = MediaFileUpload(FILENAME, mimetype='text/plain', resumable=True)
                #body = {
                #'title': path,
                #'description': 'A test document',
                #'mimeType': 'application/msword'
                #}

                #r = retrieve_all_files(drive_service)
                titles = []
                #add=0
                #for i in r:
                # if path in i['title']:
                #     add=1
                #if add==0:
                #http = httplib2.Http()
                #http = credentials.authorize(http)
                #drive_service = build('drive', 'v2', http=http)
                #file = drive_service.files().insert(body=body, media_body=media_body,convert=True).execute()
                #(destg, ext) = splitext(path)
                #destg = destg + "_converted.pdf"
                #f = open(destg, 'w')
                #f.write(download_file(drive_service,file))
                #f.close()
                doc = desktop.loadComponentFromURL( fileUrl , "_default", 0, inProps )
                another_operator = PageFormatUtils()
                reformatreturn=another_operator.settingPageOrientationAndSize(doc,pFormat)
                pageCnt = doc.CurrentController.PageCount
                chcnt=doc.CharacterCount
#                cursor  = doc.Text.createTextCursor()
#                vcursor = doc.CurrentController.getViewCursor()
#                text = doc.Text
#                tRange = text.End
                tmpkr=int(kr)
                if int(pageCnt)>int(kr):
                    ptoadd = tmpkr-pageCnt%tmpkr
                if int(pageCnt)<=int(kr):
                    ptoadd = int(kr)-int(pageCnt)
                #print('im here')
                #print(dir(doc))
                #print(doc.DocumentInfo.DocumentStatistic)
                #print (dir(doc.getDocumentProperties))
                #doc.xDocumentInfo.Author = "Editus"
                

                if not doc:
                    raise UnoException( "Couldn't open stream for unknown reason", None )
                if o == "-n":
                    doc.dispose()
                    sys.exit()

                if not stdout:
                    (dest, ext) = splitext(path)
                    dest = dest + "_converte." + extension
                    destUrl = absolutize( cwd, systemPathToFileUrl(dest) )
                    doc.storeToURL(destUrl, tuple(properties))
                else:
                    doc.storeToURL("private:stream",tuple(properties))
            except (IOException, e):
                sys.stderr.write( "Error during conversion: " + e.Message + "\n" )
                retVal = 1
            except (UnoException, e):
                sys.stderr.write( "Error ("+repr(e.__class__)+") during conversion:" + e.Message + "\n" )
                retVal = 1
            if doc:
                doc.dispose()

    except (UnoException, e):
        sys.stderr.write( "Error ("+repr(e.__class__)+") :" + e.Message + "\n" )
        retVal = 1
    except (getopt.GetoptError,e):
        sys.stderr.write( str(e) + "\n" )
        usage()
        retVal = 1
        
    calcpdf(dest,kr,pFormat)
    
    sys.stdout.write( "CharacterCount: " + str( chcnt ) + "\n" )
    sys.stdout.write( "OrigPageCount: " + str( pageCnt ) + "\n" )
    sys.stdout.write( "Format: " + str( reformatreturn ) + "\n" )
    sys.exit(retVal)

def usage():
    sys.stderr.write( "usage: ooextract.py --help | --stdout\n"+
                  "       [-c <connection-string> | --connection-string=<connection-string>\n"+
		  "       [--html|--pdf]\n"+
		  "       [--stdout]\n"+
                  "       file1 file2 ...\n"+
                  "\n" +
                  "Extracts plain text from documents and prints it to a file (unless --stdout is specified).\n" +
                  "Requires an OpenOffice.org instance to be running. The script and the\n"+
                  "running OpenOffice.org instance must be able to access the file with\n"+
                  "by the same system path. [ To have a listening OpenOffice.org instance, just run:\n"+
		  "openoffice \"-accept=socket,host=localhost,port=2002;urp;\" \n"
                  "\n"+
		  "--stdout \n" +
		  "         Redirect output to stdout. Avoids writing to a file directly\n" +
                  "-c <connection-string> | --connection-string=<connection-string>\n" +
                  "        The connection-string part of a uno url to where the\n" +
                  "        the script should connect to in order to do the conversion.\n" +
                  "        The strings defaults to socket,host=localhost,port=2002\n"
                  "--html \n"
                  "        Instead of the text filter, the writer html filter is used\n"
                  "--pdf \n"
                  "        Instead of the text filter, the pdf filter is used\n"
                  )

def xls2pdf(args=0):
    url = "uno:socket,host=localhost,port=8100;urp;StarOffice.ComponentContext"
    ctxLocal = uno.getComponentContext()
    smgrLocal = ctxLocal.ServiceManager

    resolver = smgrLocal.createInstanceWithContext(
             "com.sun.star.bridge.UnoUrlResolver", ctxLocal )
    ctx = resolver.resolve( url )
    smgr = ctx.ServiceManager

    desktop = smgr.createInstanceWithContext("com.sun.star.frame.Desktop", ctx )
    cwd = systemPathToFileUrl( getcwd() )
    fdata = []
    fdata1 = PropertyValue()
    fdata1.Name = "SelectPdfVersion"
    fdata1.Value = 0
    fdata2 = PropertyValue()
    fdata2.Name = "Quality"
    fdata2.Value = 100
    fdata.append(fdata1)
    fdata.append(fdata2)
    properties = [PropertyValue() for i in range(3)]
    properties[0].Name = "FilterName"
    properties[0].Value = "writer_pdf_Export"
    properties[1].Name = "Overwrite"
    properties[1].Value = True
    properties[2].Name = "FilterData"
    properties[2].Value = uno.Any("[]com.sun.star.beans.PropertyValue", tuple(fdata) )
    inProps = PropertyValue( "Hidden" , 0 , True, 0 ),
    
    for path in args:
            try:
                fileUrl = absolutize( cwd, systemPathToFileUrl(path) )
                doc = desktop.loadComponentFromURL( fileUrl , "_default", 0, () )
                extension  = "pdf"
                #doc.DocumentInfo.Author = "Editus"
                (dest, ext) = splitext(path)
                dest = dest + ".pdf"
                destUrl = absolutize( cwd, systemPathToFileUrl(dest) )
                doc.storeToURL(destUrl, tuple(properties))
                if not doc:
                    raise UnoException( "Couldn't open stream for unknown reason", None )
                if doc:
                   doc.dispose()
            except (IOException, e):
                sys.stderr.write( "Error during conversion: " + e.Message + "\n" )
            except (UnoException, e):
                sys.stderr.write( "Error ("+repr(e.__class__)+") during conversion:" + e.Message + "\n" )
def calcpdf(path="",kr=1,pFormat="A4"):
    
    input1 = PdfFileReader(open(path, "rb"))
    output = PdfFileWriter()
    for i in range(input1.getNumPages()):
        output.addPage(input1.getPage(i))

    if int(input1.getNumPages())>int(kr):
        ptoadd = str(int(input1.getNumPages())%int(kr))
    if int(input1.getNumPages())<=int(kr):
        ptoadd = int(kr)-int(input1.getNumPages())
    a=pagesizes.A4;
    if pFormat=="A3":
        a=pagesizes.A3;
    if pFormat=="A5":
        a=pagesizes.A5;
    if pFormat=="A3":
        a=pagesizes.A3;
    if pFormat=="Letter":
        a=pagesizes.LETTER;
    if pFormat=="Digest":
        a=(14*cm,22*cm);
    if pFormat=="Square":
        a=(21*cm,21*cm);
    if pFormat=="Pocket":
        a=(12*cm,15*cm);
    if pFormat=="A6":
        a=pagesizes.A6;
    
    
    
    
    emptyPageBuffer = createPdfPage(1,a)
    emptyPageReader = PdfFileReader(emptyPageBuffer)

    for i in range(int(ptoadd)):
        output.addPage(emptyPageReader.getPage(0))

    (dest, ext) = splitext(path)
    #print dest
    outputStream = open(dest+"d.pdf", "wb")
    output.write(outputStream)
    outputStream.close()
    sys.stdout.write( "PagesAddedSuccessfull: " + str( ptoadd ) + "\n" )
    sys.stdout.write( "PageCount: " + str( int(input1.getNumPages()) +int(ptoadd) ) + "\n" )
    
    
def createPdfPage(nPages, pagesize=None, content=None):
    buffer = io.BytesIO()
    c = canvas.Canvas(None)
    #print pagesize
    if pagesize is None:
        pagesize = PAGESIZE
#	sys.stdout.write( "PS" + pagesize + "\n" )
    c.setPageSize(pagesize)
    c.showOutline()
    for page in range(nPages):
        if content:
            c.drawString(9*cm, 22*cm, content)
        c.showPage()
    buffer.write(c.getpdfdata())
    buffer.seek(0)
    return buffer
def oo_properties(**args):
    """
    Convert args to OpenOffice property values.
    """
    props = []
    for key in args:
        prop       = PropertyValue()
        prop.Name  = key
        prop.Value = args[key]
        props.append(prop)

    return tuple(props)
def ispdftest(args=0,kr=0,pFormat="A4"):
    cwd = systemPathToFileUrl( getcwd() )
    #sys.stdout.write( "Pformat: " + str( pFormat ) + "\n" )

    for path in args:
        try:
            if exists(path):
                #sys.stdout.write( "PagesAddedSuccessfull: "  +path+ "\n" )
                input1 = PdfFileReader(open(path, "rb"))
                output = PdfFileWriter()
                for i in range(input1.getNumPages()):
                    output.addPage(input1.getPage(i))

                if int(input1.getNumPages())>int(kr):
                    ptoadd = str(int(input1.getNumPages())%int(kr))
                if int(input1.getNumPages())<=int(kr):
                    ptoadd = int(kr)-int(input1.getNumPages())
                a=pagesizes.A4;
                if pFormat=="A3":
                    a=pagesizes.A3;
                if pFormat=="A5":
                    a=pagesizes.A5;
                if pFormat=="A6":
                    a=pagesizes.A6;
		    #sys.stdout.write( "I'm A5 \n" )
                if pFormat=="A3":
                    a=pagesizes.A3;
                if pFormat=="Letter":
                    a=pagesizes.LETTER;
                if pFormat=="Digest":
                    a=(14*cm,22*cm);
                if pFormat=="Square":
                    a=(21*cm,21*cm);
                if pFormat=="Pocket":
                    a=(12*cm,15*cm);
		#sys.stdout.write( "I'm A5"+ str(a)+"\n" )
		#sys.stdout.write( "I'm A4"+ str(pagesizes.A4)+"\n" )
                emptyPageBuffer = createPdfPage(1,a)
                emptyPageReader = PdfFileReader(emptyPageBuffer)

                for i in range(int(ptoadd)):
                    output.addPage(emptyPageReader.getPage(0))

                (dest, ext) = splitext(path)
                #print dest
                outputStream = open(dest + "_converted.pdf", "wb")
                output.write(outputStream)
                outputStream.close()
                sys.stdout.write( "PagesAddedSuccessfull: " + str( ptoadd ) + "\n" )
                sys.stdout.write( "PageCount: " + str( int(input1.getNumPages()) +int(ptoadd) ) + "\n" )
                sys.stdout.write( "CharacterCount: " + "\n" )
                sys.stdout.write( "OrigPageCount: " + str( input1.getNumPages() ) + "\n" )
                sys.stdout.write( "Format: ok \n")
                
        except (IOException, e):
                sys.stderr.write( "Error during conversion: " + e.Message + "\n" )
                retVal = 1


def OnlyShow(args=0,kr=1,pFormat="A4"):
    cwd = systemPathToFileUrl( getcwd() )
    url = "uno:socket,host=localhost,port=8100;urp;StarOffice.ComponentContext"
    print (args)
    for path in args:
        try:
            ctxLocal = uno.getComponentContext()
            smgrLocal = ctxLocal.ServiceManager

            resolver = smgrLocal.createInstanceWithContext(
                                                           "com.sun.star.bridge.UnoUrlResolver", ctxLocal)
            ctx = resolver.resolve(url)
            smgr = ctx.ServiceManager

            desktop = smgr.createInstanceWithContext("com.sun.star.frame.Desktop", ctx)
            inProps = PropertyValue("Hidden", 0, True, 0),
            fileUrl = absolutize(cwd, systemPathToFileUrl(path))
            doc = desktop.loadComponentFromURL(fileUrl, "_default", 0, inProps)
            another_operator = PageFormatUtils()
            reformatreturn = another_operator.settingPageOrientationAndSize(doc, pFormat)
            cursor  = doc.Text.createTextCursor()
            vcursor = doc.CurrentController.getViewCursor()
            text = doc.Text
            tRange = text.End
            pCnt = doc.CurrentController.PageCount

            if int(pCnt) > int(kr):
                ptoadd = str(int(pCnt) % int(kr))
            if int(pCnt) <= int(kr):
                ptoadd = int(kr)-int(pCnt)
            sys.stdout.write("PagesAddedSuccessfull: " + str(ptoadd) + "\n")
            sys.stdout.write("PageCount: " + str(pCnt + int(ptoadd)) + "\n")
            sys.stdout.write("CharacterCount: " + str(doc.CharacterCount) + "\n")
            sys.stdout.write("OrigPageCount: " + str(pCnt) + "\n")
            sys.stdout.write("Format: " + str(reformatreturn) + "\n")
            doc.dispose()


    #fileUrl = absolutize( cwd, systemPathToFileUrl(path) )
#
        except (IOException, e):
                sys.stderr.write( "Error during conversion: " + e.Message + "\n" )
                retVal = 1
        except (UnoException, e):
                sys.stderr.write( "Error ("+repr(e.__class__)+") during conversion:" + e.Message + "\n" )
                retVal = 1
    
main()
