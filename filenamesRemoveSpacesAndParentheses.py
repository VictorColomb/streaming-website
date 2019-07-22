import os
import pathlib as p
import copy
import subprocess

os.chdir('C:/Users/vicco/Documents/Streaming website/videos/shows/Friends/S10')

cur=p.Path.cwd()
pp=[x for x in cur.iterdir()]
ppp=[x for x in pp if not(x.is_dir())]
PP=[str(x) for x in ppp]

for j in range(len(PP)):
        k=len(PP[j])-1
        while PP[j][k]!='\\':
            k-=1
        PP[j]=PP[j][k+1:]
PPP=[]
for e in PP:
    e=e.replace(' ','')
    e=e.replace('(','')
    PPP.append(e.replace(')',''))
for i in range(len(PP)):
    os.system('ren \"'+PP[i]+'\" \"'+PPP[i]+'\"')
