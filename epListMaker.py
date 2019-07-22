import os
import sys
import pathlib as p

if len(sys.argv)<=1:
    basePath = input('Tv show name : ')
else:
    basePath = sys.argv[1]
os.chdir('videos/shows/'+basePath)
currentPath=p.Path.cwd()
pathList=[x for x in currentPath.iterdir() if x.is_dir()]
pp=[str(x) for x in pathList]
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
        del pathList[k]
output=open('epList.js','w')
print('function showOpenEp(season,episode) {','document.getElementById(\"videoPlayer\").style.display=\"block\"; ','var vidPath = \"videos/shows/'+basePath+'/S\"+season+\"/E\"+episode+\"/vid/manifest.mpd\";','var player = dashjs.MediaPlayer().create();','player.initialize(document.querySelector(\"#videoPlayer\"), vidPath, true); }','','epList = \'', sep='\n',end='',file=output)
if pp==[]:
    print('<p>No episodes</p>\"','document.getElementById("showEpSelector").innerHTML = epList;',sep='\n',file=output)
    sys.exit(0)

ppp=[int(x[1:]) for x in pp]
for i in range(len(ppp)):
    k=0
    while k<i and ppp[k]<ppp[i]:
        k+=1
    ppp=ppp[:k]+[ppp[i]]+ppp[k:i]+ppp[i+1:]
    pp=pp[:k]+[pp[i]]+pp[k:i]+pp[i+1:]
    pathList=pathList[:k]+[pathList[i]]+pathList[k:i]+pathList[i+1:]
for i in range(len(ppp)):
    print('<p class=\"season\">Season ',str(ppp[i]),'</p>',sep='',end='',file=output)
    os.chdir(str(pp[i]))
    cPath=p.Path.cwd()
    pList=[x for x in cPath.iterdir() if x.is_dir()]
    PP=[str(x) for x in pList]
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
            del pList[k]
    if PP==[]:
        print('<p>No episodes</p>',end='',file=output)
    else:
        PPP=[int(x[1:]) for x in PP]
        for j in range(len(PPP)):
            k=0
            while k<j and PPP[k]<PPP[j]:
                k+=1
            PPP=PPP[:k]+[PPP[j]]+PPP[k:j]+PPP[j+1:]
            PP=PP[:k]+[PP[j]]+PP[k:j]+PP[j+1:]
            pList=pList[:k]+[pList[j]]+pList[k:j]+pList[j+1:]
        for j in range(len(PPP)):
            print('<button class=\"loadButton\" onclick=\"showOpenEp(',ppp[i],',',PPP[j],')\">',PPP[j],'</button>', sep='',end='',file=output)
    os.chdir('..')
print('\'','document.getElementById("showEpSelector").innerHTML = epList;',sep='\n',end='',file=output)
output.close()
