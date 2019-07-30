import sys
import os
import pathlib as p
import mysql.connector
import datetime

# REGLAGES DATABASE ICI !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
db = mysql.connector.connect(host="localhost", user="python", passwd="Lulubad7883", database="streaming_server")
sql = db.cursor()

os.chdir("C:/Users/vicco/Documents/Streaming website")

todayDate = str(datetime.datetime.now()).split(' ')[0]

moviesSqlQuery = "INSERT IGNORE INTO movies (name, type, date_added) VALUES "

# MOVIES
os.chdir('videos/movies')
currentPath=p.Path.cwd()
pathList=[x for x in currentPath.iterdir() if x.is_dir()]
qq=[str(x) for x in pathList]
for i in range(len(qq)):
    k=len(qq[i])-1
    while qq[i][k]!='\\':
        k-=1
    qq[i]=qq[i][k+1:]
for i in range(len(qq)):
    k=0
    while k<i and qq[k]<qq[i]:
        k+=1
    qq=qq[:k]+[qq[i]]+qq[k:i]+qq[i+1:]
for e in qq:
    temp = "(\""+e+"\", \"movie\", \""+todayDate+"\"),"
    moviesSqlQuery += temp
print(moviesSqlQuery[:-1])
sql.execute(moviesSqlQuery[:-1])
os.chdir('..')

# TV SHOWS
showsSqlQuery = "INSERT IGNORE INTO movies (name, date_added, type, serie, season, ep) VALUES "
os.chdir('shows')
currentPath=p.Path.cwd()
pathList=[x for x in currentPath.iterdir() if x.is_dir()]
qq=[str(x) for x in pathList]
for i in range(len(qq)):
    k=len(qq[i])-1
    while qq[i][k]!='\\':
        k-=1
    qq[i]=qq[i][k+1:]
for i in range(len(qq)):
    k=0
    while k<i and qq[k]<qq[i]:
        k+=1
    qq=qq[:k]+[qq[i]]+qq[k:i]+qq[i+1:]
for e in qq:
    os.chdir(e)
    cPath=p.Path.cwd()
    pList=[x for x in cPath.iterdir() if x.is_dir()]
    pp=[str(x) for x in pList]
    for i in range(len(pp)):
        k=len(pp[i])-1
        while pp[i][k]!='\\':
            k-=1
        pp[i]=pp[i][k+1:]
    k=0
    while k<len(pp):
        t=True
        try:
            int(pp[k][1:])
        except ValueError:
            t=False
        if pp[k][0]=='S' and t:
            k+=1
        else:
            del pp[k]
            del pList[k]
    ppp=[int(x[1:]) for x in pp]
    for i in range(len(ppp)):
        k=0
        while k<i and ppp[k]<ppp[i]:
            k+=1
        ppp=ppp[:k]+[ppp[i]]+ppp[k:i]+ppp[i+1:]
        pp=pp[:k]+[pp[i]]+pp[k:i]+pp[i+1:]
    for i in range(len(ppp)):
        os.chdir(str(pp[i]))
        cPath=p.Path.cwd()
        qList=[x for x in cPath.iterdir() if x.is_dir()]
        PP=[str(x) for x in qList]
        for j in range(len(PP)):
            k=len(PP[j])-1
            while PP[j][k]!='\\':
                k-=1
            PP[j]=PP[j][k+1:]
        k=0
        while k<len(PP):
            t=True
            try:
                int(PP[k][1:])
            except ValueError:
                t=False
            if PP[k][0]=='E' and t:
                k+=1
            else:
                del PP[k]
                del qList[k]
        else:
            PPP=[int(x[1:]) for x in PP]
            for j in range(len(PPP)):
                k=0
                while k<j and PPP[k]<PPP[j]:
                    k+=1
                PPP=PPP[:k]+[PPP[j]]+PPP[k:j]+PPP[j+1:]
                PP=PP[:k]+[PP[j]]+PP[k:j]+PP[j+1:]
            for j in range(len(PPP)):
                temp = "(\""+e+"_s"+str(ppp[i])+"e"+str(PPP[j])+"\", \""+todayDate+"\", \"show_ep\", \""+e+"\", \""+str(ppp[i])+"\", \""+str(PPP[j])+"\"),"
                showsSqlQuery += temp
        os.chdir('..')
    os.chdir('..')
print(showsSqlQuery[:-1])
sql.execute(showsSqlQuery[:-1])
db.commit()
sql.close()
db.close()
shit = input('Press <Enter> to continue...')
