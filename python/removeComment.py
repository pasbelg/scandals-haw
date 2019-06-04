"""
# Manuelle Schritte
- Suchanfrage auf Nexis
- Dokumente als HTML (Alle Haken herausnehmen) in 200er Batches herunterladen (Limit von Nexis) und Speichern

# Imports und Setup
"""
import os, re
from bs4 import BeautifulSoup
import json

# Definieren des Pfades
HTMLpath = '../html/'
htmlFiles = os.listdir(HTMLpath)
for file in htmlFiles:
    # Ausschließen von Dateien mit anderen Dateiendungen als HTML.
    if file.find('.HTML') != -1:
        fileName=(os.path.splitext(file)[0])
        print(fileName)
        writePath='./html/changed/' + fileName + '/'
        with open(HTMLpath + file, 'rb') as html:
            string = html.read()
            removeCommentTag = re.sub('<!--|-->', '', str(string))
            try:  
                os.mkdir(writePath)
            except OSError:  
                print ("Creation of the directory failed")
            print (writePath)         
            with open(writePath + file, 'w', encoding='utf8') as f:
                    f.write(removeCommentTag)