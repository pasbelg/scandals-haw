import os, re
from bs4 import BeautifulSoup
import json

HTMLpath = './html/'
htmlFiles = os.listdir(HTMLpath)
for file in htmlFiles:
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