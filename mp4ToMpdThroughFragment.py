from __future__ import print_function
import os
import pathlib as p
import copy
import subprocess
import shutil
import sys
from math import floor

# GRABS .mp4 OR .mkv FILES (preferably called E??.mp4/.mkv) AND TRANSFORMS THEM INTO DASH READY FILES, ORGANISED INTO vid?? DIRECTORIES (for the dash) AND E?? DIRECTORIES (for the .mp4)
# REQUIRES ffmpeg AND bento4 UTILITIES TO BE ACCESSIBLE EVERYWHERE ON THE DEVICE !!!!!!!!!!!!!
# REQUIRES PYTHON 2.x !!!!!!!!!!!!

cur=p.Path.cwd()
pp=[x for x in cur.iterdir()]
ppp=[x for x in pp if not(x.is_dir())]
PP=[str(x) for x in ppp]

for j in range(len(PP)):
        k=len(PP[j])-1
        while PP[j][k]!='\\':
            k-=1
        PP[j]=PP[j][k+1:]
PPP=[x.split('.')[0] for x in PP]
PPp=[x.split('.')[-1] for x in PP]
PPPP=[x+'-frag.mp4' for x in PPP]

# Fragment each media file to file-frag.mp4 AND move original media files to /E?
i=0
print("REMUX EVENTUEL ET FRAGMENTATION","=================================",sep='\n')
while i<len(PP):
    testInt= True
    try:
        shit = int(PPP[i][1:])
    except ValueError:
        testInt = False
    if (PPp[i] in ['mp4','mkv']) and testInt and PP[i][0]=='E':
        i+=1
    else:
        del PP[i]
        del PPP[i]
        del PPp[i]
        del PPPP[i]
for i in range(len(PP)):
    k=0
    while k<i and int(PPP[k][1:])<int(PPP[i][1:]):
        k+=1
    PP=PP[:k]+[PP[i]]+PP[k:i]+PP[i+1:]
    PPP=PPP[:k]+[PPP[i]]+PPP[k:i]+PPP[i+1:]
    PPPP=PPPP[:k]+[PPPP[i]]+PPPP[k:i]+PPPP[i+1:]
    PPp=PPp[:k]+[PPp[i]]+PPp[k:i]+PPp[i+1:]

length=len(PP)
for i in range(len(PP)):
    print(PPP[i],'   |','='*int(floor(i/length*20)),' '*(20-int(floor(i/length*20))),'|  ',int(floor(i/length*100)),'%', sep='', end='\r')
    sys.stdout.flush()
    if PPp[i]=='mkv':
        subprocess.call(['ffmpeg','-loglevel','quiet','-i',PP[i],'-codec','copy',PPP[i]+'.mp4'])
        os.system('del '+PP[i])
        PP[i]=PPP[i]+'.mp4'
    os.system('mkdir '+PPP[i])
    subprocess.call(['mp4fragment',PP[i],PPPP[i]], stdout=subprocess.PIPE, stderr=subprocess.PIPE)
    shutil.move(PP[i],PPP[i])
print(PPP[length-1],'   |','='*20,'|  100%',sep='')


# Partition each file-frag.mp4 using mp4dash
FNULL = open(os.devnull,'w')
print("",'SECTIONNING FILES','====================', sep='\n')
for i in range(len(PP)):
    print(PPP[i],'   |','='*int(floor(i/length*20)),' '*(20-int(floor(i/length*20))),'|  ',int(floor(i/length*100)),'%', sep='', end='\r')
    sys.stdout.flush()
    dumbProcess = subprocess.call('mp4dash -o vid'+PPP[i]+' --mpd-name=manifest.mpd --use-segment-timeline --force '+PPPP[i], shell=True, stdout=FNULL)
    os.system('del '+PPPP[i])
    shutil.move('vid'+PPP[i],PPP[i])
    os.chdir(PPP[i])
    os.system('ren vid'+PPP[i]+' vid')
    os.system('ren '+PP[i]+' vid.mp4')
    os.chdir('..')
print(PPP[length-1],'   |','='*20,'|  100%',sep='')
shit = input('Press <Enter> to continue...')
