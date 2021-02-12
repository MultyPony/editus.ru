#! /usr/bin/env python
# -*- coding: utf-8 -*-

import httplib2
import pprint

from apiclient.discovery import build
from apiclient.http import MediaFileUpload
from oauth2client.client import OAuth2WebServerFlow
from oauth2client.file import Storage

# Copy your credentials from the console
CLIENT_ID = '159874999662-t5uf0m5ubrmsi7svc0p30v8c9ifj7pnd.apps.googleusercontent.com'
CLIENT_SECRET = 'a7ySwcmE1gf7FCiwIUhV8zZq'

# Check https://developers.google.com/drive/scopes for all available scopes
OAUTH_SCOPE = 'https://www.googleapis.com/auth/drive'

# Redirect URI for installed apps
REDIRECT_URI = 'urn:ietf:wg:oauth:2.0:oob'
#REDIRECT_URI = 'http://localhost:8000'

# Path to the crendentials
CRED_FILENAME = 'credentials'

### For storing token
storage = Storage(CRED_FILENAME)

# Path to the file to upload
FILENAME = 'sample.doc'
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
    except errors.HttpError, error:
      print 'An error occurred: %s' % error
      break
  return result

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
      print 'Status: %s' % resp
      return content
    else:
      print 'An error occurred: %s' % resp
      return None
  else:
    # The file doesn't have any content stored on Drive.
    return None

def retrieve_properties(service, file_id):
  """Retrieve a list of custom file properties.

  Args:
    service: Drive API service instance.
    file_id: ID of the file to retrieve properties for.
  Returns:
    List of custom properties.
  """
  #try:
  props = service.properties().list(fileId=file_id['id']).execute()
  print props
  return None
  #except errors.HttpError, error:
  #  print 'An error occurred: %s' % error
  #return None

def createRemoteFolder(self, folderName, parentID = None):
        # Create a folder on Drive, returns the newely created folders ID
        body = {
          'title': folderName,
          'mimeType': "application/vnd.google-apps.folder"
        }
        if parentID:
            body['parents'] = [{'id': parentID}]
        root_folder = drive_service.files().insert(body = body).execute()
        return root_folder['id']

if not storage.get():
    # Run through the OAuth flow and retrieve authorization code
    flow = OAuth2WebServerFlow(CLIENT_ID, CLIENT_SECRET, OAUTH_SCOPE, REDIRECT_URI)
    authorize_url = flow.step1_get_authorize_url()
    print 'Go to the following link in your browser: ' + authorize_url
    code = raw_input('Enter verification code: ').strip()
    credentials = flow.step2_exchange(code)

    ### Storing access token and a refresh token in CRED_FILENAME
    storage.put(credentials)
else:
    ### Getting access_token,expires_in,token_type,Refresh_toke info from CRED_FILENAME to 'credentials'
    credentials = storage.get()

# Create an httplib2.Http object and authorize it with our credentials
http = httplib2.Http()
http = credentials.authorize(http)

drive_service = build('drive', 'v2', http=http)

# Insert a file
media_body = MediaFileUpload(FILENAME, mimetype='text/plain', resumable=True)
body = {
    'title': 'My document_YEAH',
    'description': 'A test document',
    'mimeType': 'application/msword'
}






r = retrieve_all_files(drive_service)
titles = []
for i in r:
    titles.append(i['title'])
    if i['title'] == 'My document_YEAH':
        #print i.keys()

        #f = drive_service.files().get(fileId=i['id']).execute()

        f = open('workfile.pdf', 'w')
        #f.write(download_file(drive_service,i))
        f.close()
        retrieve_properties(drive_service,i)
        #print f
        #resp, content = drive_service.request(f.get('downloadUrl'))
        #print resp
        #print 'got'
if not 'Upload2' in titles:
    createRemoteFolder(drive_service,'Upload2')
    print 'created'
else:
    print 'already exist'
if not 'My document_YEAH' in titles:
    file = drive_service.files().insert(body=body, media_body=media_body,convert=True).execute()
    print 'created'
else:
    print 'Filename already exist'


