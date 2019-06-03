"""
# Manuelle Schritte
- Suchanfrage auf Nexis
- Dokumente als HTML (Alle Haken herausnehmen) in 200er Batches herunterladen (Limit von Nexis) und Speichern

# Imports und Setup
"""
import os, re
from bs4 import BeautifulSoup
import json
import datetime
import locale

# Definieren des Dateipfades
HTMLpath = '../html/'
htmlDirs = os.listdir(HTMLpath)

"""Extrahieren der Datumsangaben"""
# Um deutsche Datumsangaben umwandeln zu können muss die deutsche Zeit gesetzt werden.
locale.setlocale(locale.LC_TIME, '')
# Diese Funktion wandelt die von Nexis sehr wirr angegebenen Daten in ein einheitliches Datumsformat um.
def guess_date(string):
        for fmt in ['%d. %B %Y',
                    '%A %d. %B %Y',
                    '%A, %d. %B %Y',
                    '%A %d. %B %Y %I:%M AM %Z',
                    '%A %d. %B %Y %I:%M PM %Z',
                    '%A %d.%B %Y %I:%M AM %Z',
                    '%A %d.%B %Y %I:%M PM %Z',
                    '%A %d. %B %Y %I:%M AM %Z+1',
                    '%A %d. %B %Y %I:%M PM %Z+1',
                    '%d. %B %Y %A %I:%M PM %Z',
                    '%d. %B %Y %A %I:%M AM %Z',
                    '%B %d, %Y %A']:
            try:
                x = datetime.datetime.strptime(string, fmt).date()
                return x.strftime("%d-%m-%Y")
            except ValueError:
                continue
# Ab hier werden für jede HTML-Dateien die Daten ausgelesen
for workingDir in htmlDirs:
    newHTML = os.listdir(HTMLpath + workingDir)
    loopNo = 1
    allData = {}
    dataArray = []
    valueCountEnd=0
    for f in newHTML:
        filepath=HTMLpath + workingDir + '/' +  f
        if f.find('.HTML') != -1:
            with open(filepath, 'r', encoding="utf8") as html:
                soup = BeautifulSoup(html, "html.parser")
                documents = soup.findAll('docfull')
                # Durchsuchen aller Tags in denen Datumsangaben stehen.
                for doc in documents:
                    valueCountStart = valueCountEnd                                         
                    dateDiv = doc.findAll('div', {'class': 'c3'})
                    # Genaueres definieren des Tags in dem die Datumsangaben zu finden sind.
                    for date in dateDiv:
                        try:
                            day = date.find('p', {'class': 'c1'}).text
                            monthYear = date.find('span', {'class': 'c2'}).text
                        except:
                            # Ausgabe der Dateien in denen es Probleme beim Auslesen gibt.
                            print(f)
                            continue
                        combinedDate = monthYear.strip()                   
                        # Vereinheitlichung der Datumsangaben
                        cleanDate = guess_date(combinedDate)
                        valueCountEnd +=1
                        # Speichern der Datumsangaben in ein großes Array (ein Array pro Skandalverzeichnis)
                        dataArray.append(cleanDate)
                    loopNo += 1  
                # Erstellen des Verzeichnisses für das speichern der JSON-Dateien
                try:  
                    os.mkdir('./json')
                except OSError:  
                    print ("Creation of the directory failed")
                try:  
                    os.mkdir('./json/' + workingDir)
                except OSError:  
                    print ("Creation of the directory failed")
                # Umwandeln des Arrays in eine JSON-Datei welche unter json/ abgespeichert wird
                with open('./json/'+workingDir+'/'+ 'data.json', 'w') as outfile:
                    json.dump(dataArray, outfile, indent=1, ensure_ascii=False)
