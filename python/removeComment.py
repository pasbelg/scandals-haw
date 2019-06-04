"""
# Manuelle Schritte
- Suchanfrage auf Nexis
- Dokumente als HTML (Alle Haken herausnehmen) in 200er Batches herunterladen (Limit von Nexis) und Speichern

# Imports
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
        # Speichern des Dateinamens ohne Format.
        fileName = (os.path.splitext(file)[0])
        print(fileName)
        # Definieren der Verzeichnisse aus den Dateinamen der HTML-Datei.
        writePath='./html/changed/' + fileName + '/'
        # Entfernen aller Kommentare in den HTML-Dateien.
        with open(HTMLpath + file, 'rb') as html:
            string = html.read()
            removeCommentTag = re.sub('<!--|-->', '', str(string))
            # Erstellen der Verzeichnisse pro HTML-Datei.
            try:  
                os.mkdir(writePath)
            except OSError:  
                print ("Creation of the directory failed")
            print (writePath)         
            # Speichern der kommentarfreien HTML-Dateien in den angelegten Verzeichnissen.
            with open(writePath + file, 'w', encoding='utf8') as f:
                    f.write(removeCommentTag)