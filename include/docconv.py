import getopt, sys
import uno

from unohelper import Base, systemPathToFileUrl, absolutize
from os import getcwd
from os.path import splitext
from com.sun.star.beans import PropertyValue
from com.sun.star.uno import Exception as UnoException
from com.sun.star.io import IOException, XOutputStream

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
    retVal = 0
    doc = None
    stdout = False
    try:
        opts, args = getopt.getopt(sys.argv[1:], "hc:k:p:f:",
            ["help", "connection-string=" , "pdf", "stdout" ])
        url = "uno:socket,host=localhost,port=8100;urp;StarOffice.ComponentContext"
        filterName = "Text (Encoded)"
        extension  = "txt"
        #print opts, args
        for o, a in opts:
            if o in ("-h", "--help"):
                usage()
                sys.exit()
            if o in ("-c", "--connection-string" ):
                url = "uno:" + a + ";urp;StarOffice.ComponentContext"
#            if o == "--pages":
#                filterName = "HTML (StarWriter)"
#                extension  = "html"
            if o == "--pdf":
                filterName = "writer_pdf_Export"
                extension  = "pdf"
	    if o == "--stdout":
	    	stdout = True
	    if o == "-k":
                kr = a
            if o == "-p":
                pages = a
            if o == "-f":
                pFormat = a
                

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

#        fdata = [PropertyValue() for i in range(2)]
#        fdata[0].Name = "PageRange"
#        fdata[0].Value = str("1")
#        fdata[1].Name = "Watermark"
#        fdata[1].Value = "WATER"
#        outProps = (
#            PropertyValue( "FilterName" , 0, filterName , 0 ),
#            PropertyValue( "Watermark", 0, "WATER", 0),
#	    PropertyValue( "FilterData", 0, tuple(fdata), 0 ),
#            PropertyValue( "Overwrite" , 0, True , 0 ),
#            PropertyValue( "OutputStream", 0, OutputStream(), 0)
#	)
       
        # filter data
        fdata = []
        fdata1 = PropertyValue()
        fdata1.Name = "SelectPdfVersion"
        fdata1.Value = 1
        fdata2 = PropertyValue()
        fdata2.Name = "Quality"
        fdata2.Value = 100
#        fdata3 = PropertyValue()
#        fdata3.Name = "OpenInFullScreenMode"
#        fdata3.Value = True

        fdata.append(fdata1)
        fdata.append(fdata2)
#        fdata.append(fdata3)
        
#        unoWrap._FlagAsMethod("set")
#        unoWrap.set('[]com.sun.star.beans.PropertyValue', tuple(fdata))

        properties = [PropertyValue() for i in range(3)]
        properties[0].Name = "FilterName"
        properties[0].Value = "writer_pdf_Export"
        #properties[0].Value = "HTML (StarWriter)"
        properties[1].Name = "Overwrite"
        properties[1].Value = True
        properties[2].Name = "FilterData"
        properties[2].Value = uno.Any("[]com.sun.star.beans.PropertyValue", tuple(fdata) )

#        args = []
#        arg1 = PropertyValue()
#        arg1.Name = "FilterName"
#        arg1.Value = "writer_web_pdf_Export"
#        arg2 = PropertyValue()
#        arg2.Name = "FilterData"
#        arg2.Value = uno.Any(
#        "[]com.sun.star.beans.PropertyValue", tuple(fdata) )
#        args.append(arg1)
#        args.append(arg2)
#        outputprops = [
#                        PropertyValue( "FilterName" , 0,  "writer_pdf_Export" , 0 ),
#                        PropertyValue( "Overwrite" , 0, True , 0 ),
#                        PropertyValue( "Size", 0, "A3", 0 ),
#                        PropertyValue( "OutputStream", 0, OutputStream(), 0),
#
#                        ]
#
#                 ## To enable PDF/A
#     # outputprops.append()
#
#      outputprops = tuple(outputprops)

        inProps = PropertyValue( "Hidden" , 0 , True, 0 ),
        for path in args:
            try:
                fileUrl = absolutize( cwd, systemPathToFileUrl(path) )
                doc = desktop.loadComponentFromURL( fileUrl , "_default", 0, inProps )
		#info = doc.getDocumentInfo()
		#text = doc.Text
		#tRange = text.End
                #info.Title = title
		#cursor = text.createTextCursor()
		#sys.stdout.write( "Author:" + str( dir(doc) ) + "\n" )

                cursor  = doc.Text.createTextCursor()
                vcursor = doc.CurrentController.getViewCursor()
                #cursor.gotoEnd (True)
#                vcursor.gotoStart (False)
                #newPage = doc.CurrentController.createPage()
#                model = XSCRIPTCONTEXT.getDocument()
                text = doc.Text
#                #create an XTextRange at the end of the document
                tRange = text.End
#                #and set the string

                
                
                #doc.Text.insertString(cursor, "\n\n\tAnd this is another new paragraph.", 0)
                pageCnt = doc.CurrentController.PageCount
                if int(pageCnt)>int(kr):
                    ptoadd = str(int(pageCnt)%int(kr))
                if int(pageCnt)<=int(kr):
                    ptoadd = int(kr)-int(pageCnt)

#                i=0
#                while doc.CurrentController.PageCount < (pageCnt+int(ptoadd)):
#                    i=i+1
#                    #pageCnt = doc.CurrentController.PageCount
#                    tRange = text.End
#                    tRange.String = "\n"
#                    #tRange.String = "\n"+str(pageCnt)
                pdata = []
                pdata1 = PropertyValue()
                pdata1.Name = "Title"
                pdata1.Value = pageCnt
                doc.DocumentInfo.Author = "Editus"
                #doc.CurrentController.Title = "huinya"
                #doc.CurrentController.setPropertyValue( "Title", 6710932 )
#                xUserField = doc.createInstance("com.sun.star.text.TextField.User")
#                xMasterPropSet = doc.createInstance("com.sun.star.text.FieldMaster.User")
#                xMasterPropSet.setPropertyValue("Name", "UserEmperor")
                sys.stdout.write( "PagesAddedSuccessfull: " + str( ptoadd ) + "\n" )
                sys.stdout.write( "PageCount: " + str( pageCnt +int(ptoadd) ) + "\n" )
                sys.stdout.write( "CharacterCount: " + str( doc.CharacterCount - i) + "\n" )
                sys.stdout.write( "OrigPageCount: " + str( pageCnt ) + "\n" )
                #sys.stdout.write( str(doc.DocumentInfo.getUserFieldCount()) + "\n" )
                #sys.stdout.write(doc.DocumentInfo.PrintedBy + "\n" )
                #fsys.stdout.write(str(dir(doc.DocumentInfo)))
		
#                for page in range (doc.CurrentController.PageCount):
#                    vcursor.jumpToEndOfPage ()
#                    cursor.gotoRange (vcursor.Start, True)
#                    print page
#                    print cursor.String
#                    if vcursor.Page < doc.CurrentController.PageCount:
#                        vcursor.jumpToNextPage ()
#                        cursor.gotoRange (vcursor.Start, False)
                      



                #sys.stdout.write( "CharacterCount:" + str( doc.leaseNumber ) + "\n" )
		
                
                if not doc:
                    raise UnoException( "Couldn't open stream for unknown reason", None )

		if not stdout:
                    (dest, ext) = splitext(path)
                    dest = dest + "." + extension
                    destUrl = absolutize( cwd, systemPathToFileUrl(dest) )
                    #sys.stderr.write(destUrl + "\n")
                    #doc.storeToURL(destUrl, outProps)
                    doc.storeToURL(destUrl, tuple(properties))
		else:
		    #doc.storeToURL("private:stream",outProps)
                    doc.storeToURL("private:stream",tuple(properties))
            except IOException, e:
                sys.stderr.write( "Error during conversion: " + e.Message + "\n" )
                retVal = 1
            except UnoException, e:
                sys.stderr.write( "Error ("+repr(e.__class__)+") during conversion:" + e.Message + "\n" )
                retVal = 1
            if doc:
                doc.dispose()

    except UnoException, e:
        sys.stderr.write( "Error ("+repr(e.__class__)+") :" + e.Message + "\n" )
        retVal = 1
    except getopt.GetoptError,e:
        sys.stderr.write( str(e) + "\n" )
        usage()
        retVal = 1

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


main()
